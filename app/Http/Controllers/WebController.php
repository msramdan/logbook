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
        return view('welcome', compact('lastEvent'));
    }

    public function getPeserta(Request $request)
    {
        $search = $request->input('search', '');

        $query = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->select(
                'pesertas.id',
                'pesertas.event_id',
                'pesertas.callsign',
                'pesertas.nama_peserta',
                'pesertas.nomor_sertifikat',
                'events.nama_event',
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
                'events.kode_sertifikat',
                'events.template_sertifikat'
            )
            ->first();

        // 2. Validasi jika peserta tidak ditemukan
        if (!$peserta) {
            abort(404, 'Data Peserta atau Event tidak ditemukan.');
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
