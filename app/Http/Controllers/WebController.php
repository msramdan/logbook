<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class WebController extends Controller
{
    public function index()
    {
        $lastEvent = Event::latest()->first();
        $topPeserta = $this->buildTopRankGroups(limit: 5);

        return view('welcome', compact('lastEvent', 'topPeserta'));
    }

    /**
     * Detail partisipan by callsign: logs, event diikuti, rank (log sama = rank sama).
     */
    public function getPesertaDetail(Request $request)
    {
        $callsign = trim((string) $request->input('callsign', ''));

        if ($callsign === '') {
            return response()->json(['message' => 'Callsign wajib diisi.'], 422);
        }

        $stats = $this->getCallsignStats();
        $me = $stats->first(fn ($row) => strcasecmp($row->callsign, $callsign) === 0);

        if (!$me) {
            return response()->json(['message' => 'Data partisipan tidak ditemukan.'], 404);
        }

        $rankMap = $this->buildRankMap($stats);
        $rank = $rankMap[$me->callsign] ?? null;
        $peersAtRank = $stats->filter(fn ($row) => ($rankMap[$row->callsign] ?? null) === $rank)->count();

        $events = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->where('pesertas.callsign', $me->callsign)
            ->select(
                'events.id',
                'events.nama_event',
                'events.tanggal_mulai',
                'events.tanggal_selesai',
                DB::raw('COUNT(pesertas.id) as jumlah_log_event')
            )
            ->groupBy(
                'events.id',
                'events.nama_event',
                'events.tanggal_mulai',
                'events.tanggal_selesai'
            )
            ->orderByDesc('events.tanggal_mulai')
            ->get();

        return response()->json([
            'callsign' => $me->callsign,
            'nama_peserta' => $me->nama_peserta,
            'jumlah_log' => (int) $me->jumlah_log,
            'jumlah_event' => (int) $me->jumlah_event,
            'rank' => $rank,
            'peers_at_rank' => $peersAtRank,
            'events' => $events,
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, object>
     */
    private function getCallsignStats()
    {
        return DB::table('pesertas')
            ->select(
                'callsign',
                DB::raw('MAX(nama_peserta) as nama_peserta'),
                DB::raw('COUNT(*) as jumlah_log'),
                DB::raw('COUNT(DISTINCT event_id) as jumlah_event')
            )
            ->groupBy('callsign')
            ->orderByDesc('jumlah_log')
            ->orderBy('nama_peserta')
            ->get();
    }

    /**
     * Dense rank map: callsign => rank (same log count shares rank).
     *
     * @param  \Illuminate\Support\Collection  $stats
     * @return array<string, int>
     */
    private function buildRankMap($stats): array
    {
        $grouped = $stats->groupBy('jumlah_log')->sortKeysDesc();
        $map = [];
        $rank = 1;

        foreach ($grouped as $members) {
            foreach ($members as $member) {
                $map[$member->callsign] = $rank;
            }
            $rank++;
        }

        return $map;
    }

    /**
     * Top N rank groups for homepage leaderboard.
     */
    private function buildTopRankGroups(int $limit = 5)
    {
        $stats = $this->getCallsignStats();
        $grouped = $stats->groupBy('jumlah_log')->sortKeysDesc()->take($limit);

        $topPeserta = collect();
        $rank = 1;

        foreach ($grouped as $jumlahLog => $members) {
            $sorted = $members->sortBy(fn ($m) => strtoupper($m->nama_peserta))->values();
            $topPeserta->push((object) [
                'rank' => $rank,
                'jumlah_log' => (int) $jumlahLog,
                'members' => $sorted,
                'display' => $sorted->first(),
                'others_count' => max(0, $sorted->count() - 1),
            ]);
            $rank++;
        }

        return $topPeserta;
    }

    public function getPeserta(Request $request)
    {
        $search = $request->input('search', '');
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $query = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->select(
                'pesertas.id',
                'pesertas.event_id',
                'pesertas.callsign',
                'pesertas.nama_peserta',
                'pesertas.nomor_sertifikat',
                'events.nama_event',
                'events.tanggal_mulai',
                'events.tanggal_selesai',
                'events.ada_sertifikat',
                'events.kode_sertifikat',
                'events.template_sertifikat'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pesertas.callsign', 'like', "%{$search}%")
                    ->orWhere('pesertas.nama_peserta', 'like', "%{$search}%")
                    ->orWhere('pesertas.nomor_sertifikat', 'like', "%{$search}%")
                    ->orWhere('events.nama_event', 'like', "%{$search}%");
            });
        }

        // Filter rentang berdasarkan field tanggal_mulai event
        if ($tanggalMulai) {
            $query->whereDate('events.tanggal_mulai', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $query->whereDate('events.tanggal_mulai', '<=', $tanggalSelesai);
        }

        $pesertas = $query->orderBy('pesertas.created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'data' => $pesertas->items(),
            'pagination' => [
                'total' => $pesertas->total(),
                'per_page' => $pesertas->perPage(),
                'current_page' => $pesertas->currentPage(),
                'last_page' => $pesertas->lastPage(),
                'next_page_url' => $pesertas->nextPageUrl(),
                'prev_page_url' => $pesertas->previousPageUrl(),
            ]
        ]);
    }

    public function downloadSertifikat($eventId, $pesertaId)
    {
        // 1. Ambil data peserta beserta event terkait
        $peserta = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->where('pesertas.id', $pesertaId)
            ->where('events.id', $eventId)
            ->select(
                'pesertas.nama_peserta',
                'pesertas.callsign',
                'pesertas.nomor_sertifikat',
                'events.nama_event',
                'events.ada_sertifikat',
                'events.kode_sertifikat',
                'events.template_sertifikat'
            )
            ->first();

        // 2. Validasi jika peserta tidak ditemukan
        if (!$peserta) {
            abort(404, 'Data Peserta atau Event tidak ditemukan.');
        }

        if (!$peserta->ada_sertifikat) {
            abort(404, 'Event ini tidak menyediakan sertifikat.');
        }

        // 3. Validasi jika template sertifikat tidak ada
        if (empty($peserta->template_sertifikat)) {
            return back()->with('error', 'Template sertifikat untuk event ini belum diatur.');
        }

        // 4. Dapatkan path lokal dari URL template
        $templateName = basename($peserta->template_sertifikat);
        $templatePath = storage_path('app/public/template-sertifikats/' . $templateName);

        if (!file_exists($templatePath)) {
            abort(404, 'File template sertifikat tidak ditemukan di server.');
        }

        // 5. Buat nomor sertifikat lengkap TANPA CALLSIGN (SESUAI REVISI)
        $nomorLengkap = "{$peserta->nomor_sertifikat}.{$peserta->kode_sertifikat}";

        // 6. Siapkan data untuk dikirim ke view
        $data = [
            'namaPeserta'     => $peserta->nama_peserta,
            'callsign'     => $peserta->callsign,
            'nomorSertifikat' => $nomorLengkap,
            'templatePath'    => $templatePath,
        ];

        // 7. Generate PDF dari view
        $pdf = Pdf::loadView('sertifikat.download', $data)
            ->setPaper('a4', 'landscape');

        // 8. Buat nama file yang akan diunduh
        $namaFile = 'Sertifikat-' . Str::slug($peserta->nama_event) . '-' . Str::slug($peserta->nama_peserta) . '.pdf';

        // 9. Kirim PDF ke browser untuk diunduh
        return $pdf->stream($namaFile);
    }
}
