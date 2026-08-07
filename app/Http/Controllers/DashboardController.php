<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $now = Carbon::now();

        $totalEvent = Event::count();
        $totalLog = DB::table('pesertas')->count();
        $totalCallsign = (int) DB::table('pesertas')->selectRaw('COUNT(DISTINCT callsign) as total')->value('total');
        $totalUser = User::count();

        $eventAdaSertifikat = Event::where('ada_sertifikat', true)->count();
        $eventTanpaSertifikat = Event::where('ada_sertifikat', false)->count();

        $logHariIni = DB::table('pesertas')
            ->whereDate('created_at', $now->toDateString())
            ->count();

        $logBulanIni = DB::table('pesertas')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        // Logs per bulan (12 bulan terakhir)
        $logsPerMonth = collect(range(11, 0))->map(function (int $i) use ($now) {
            $date = $now->copy()->subMonths($i);

            return [
                'label' => $date->translatedFormat('M Y'),
                'total' => DB::table('pesertas')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        });

        // Top event by log count
        $topEvents = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->select('events.nama_event', DB::raw('COUNT(pesertas.id) as total_log'))
            ->groupBy('events.id', 'events.nama_event')
            ->orderByDesc('total_log')
            ->limit(8)
            ->get();

        // Top callsign by logs
        $topCallsigns = DB::table('pesertas')
            ->select(
                'callsign',
                DB::raw('MAX(nama_peserta) as nama_peserta'),
                DB::raw('COUNT(*) as jumlah_log'),
                DB::raw('COUNT(DISTINCT event_id) as jumlah_event')
            )
            ->groupBy('callsign')
            ->orderByDesc('jumlah_log')
            ->orderBy('callsign')
            ->limit(5)
            ->get();

        // Recent logs
        $recentLogs = DB::table('pesertas')
            ->join('events', 'pesertas.event_id', '=', 'events.id')
            ->select(
                'pesertas.callsign',
                'pesertas.nama_peserta',
                'pesertas.created_at',
                'events.nama_event'
            )
            ->orderByDesc('pesertas.created_at')
            ->limit(8)
            ->get();

        // Upcoming / ongoing / latest events
        $upcomingEvents = Event::query()
            ->orderByDesc('tanggal_mulai')
            ->limit(5)
            ->get(['id', 'nama_event', 'tanggal_mulai', 'tanggal_selesai', 'ada_sertifikat']);

        $chart = [
            'months' => $logsPerMonth->pluck('label')->values(),
            'monthTotals' => $logsPerMonth->pluck('total')->values(),
            'eventLabels' => $topEvents->pluck('nama_event')->map(fn ($n) => \Illuminate\Support\Str::limit($n, 28))->values(),
            'eventTotals' => $topEvents->pluck('total_log')->values(),
            'sertifikatSeries' => [$eventAdaSertifikat, $eventTanpaSertifikat],
            'sertifikatLabels' => ['Ada Sertifikat', 'Tanpa Sertifikat'],
        ];

        return view('dashboard', [
            'stats' => [
                'total_event' => $totalEvent,
                'total_log' => $totalLog,
                'total_callsign' => $totalCallsign,
                'total_user' => $totalUser,
                'log_hari_ini' => $logHariIni,
                'log_bulan_ini' => $logBulanIni,
                'event_sertifikat' => $eventAdaSertifikat,
                'event_tanpa_sertifikat' => $eventTanpaSertifikat,
            ],
            'topCallsigns' => $topCallsigns,
            'recentLogs' => $recentLogs,
            'upcomingEvents' => $upcomingEvents,
            'chart' => $chart,
        ]);
    }
}
