@extends('layouts.app')

@section('title', __(key: 'Dashboard'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __(key: 'Dashboard') }}</h3>
                    <p class="text-subtitle text-muted">
                        Ringkasan logbook, event, dan partisipan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        @if (session(key: 'status'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session(key: 'status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Welcome --}}
        <div class="card mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h4 class="mb-1">Hi 👋, {{ auth()->user()->name }}</h4>
                    <p class="mb-0 text-muted">{{ __(key: 'You are logged in!') }} · {{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @can('event view')
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-calendar-event"></i> Events
                        </a>
                    @endcan
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-box-arrow-up-right"></i> Halaman Depan
                    </a>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon purple mb-0">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted font-semibold mb-0">Total Event</h6>
                                <h5 class="font-extrabold mb-0">{{ number_format($stats['total_event']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon blue mb-0">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted font-semibold mb-0">Total Logs</h6>
                                <h5 class="font-extrabold mb-0">{{ number_format($stats['total_log']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon green mb-0">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted font-semibold mb-0">Callsign Unik</h6>
                                <h5 class="font-extrabold mb-0">{{ number_format($stats['total_callsign']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon red mb-0">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted font-semibold mb-0">User Admin</h6>
                                <h5 class="font-extrabold mb-0">{{ number_format($stats['total_user']) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <h6 class="text-muted mb-1">Logs Hari Ini</h6>
                        <h4 class="mb-0">{{ number_format($stats['log_hari_ini']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <h6 class="text-muted mb-1">Logs Bulan Ini</h6>
                        <h4 class="mb-0">{{ number_format($stats['log_bulan_ini']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <h6 class="text-muted mb-1">Event + Sertifikat</h6>
                        <h4 class="mb-0 text-success">{{ number_format($stats['event_sertifikat']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <h6 class="text-muted mb-1">Event Tanpa Sertifikat</h6>
                        <h4 class="mb-0 text-secondary">{{ number_format($stats['event_tanpa_sertifikat']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Logs per Bulan (12 bulan terakhir)</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-logs-month" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Config Sertifikat Event</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-sertifikat" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Event berdasarkan Logs</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-logs-event" style="min-height: 340px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Top 5 Callsign</h5>
                        <span class="badge bg-light-primary">by logs</span>
                    </div>
                    <div class="card-body">
                        @forelse ($topCallsigns as $i => $row)
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-light-{{ $i === 0 ? 'warning' : ($i === 1 ? 'secondary' : 'primary') }} me-3">
                                    <span class="avatar-content">{{ $i + 1 }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">
                                        <span class="badge bg-primary">{{ $row->callsign }}</span>
                                    </h6>
                                    <small class="text-muted text-uppercase">{{ $row->nama_peserta }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>{{ $row->jumlah_log }}</strong>
                                    <div class="text-muted small">logs · {{ $row->jumlah_event }} event</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data log.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Log Terbaru</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-lg mb-0">
                            <thead>
                                <tr>
                                    <th>Callsign</th>
                                    <th>Peserta</th>
                                    <th>Event</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentLogs as $log)
                                    <tr>
                                        <td><span class="badge bg-success">{{ $log->callsign }}</span></td>
                                        <td class="text-uppercase">{{ $log->nama_peserta }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($log->nama_event, 35) }}</td>
                                        <td class="text-muted small">
                                            {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada log.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Event Terbaru</h5>
                        @can('event view')
                            <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary">Lihat semua</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        @forelse ($upcomingEvents as $event)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $event->nama_event }}</h6>
                                    <small class="text-muted">
                                        {{ $event->tanggal_mulai?->format('d M Y H:i') ?? '-' }}
                                        –
                                        {{ $event->tanggal_selesai?->format('d M Y H:i') ?? '-' }}
                                    </small>
                                </div>
                                @if ($event->ada_sertifikat)
                                    <span class="badge bg-success">Sertifikat</span>
                                @else
                                    <span class="badge bg-secondary">Tanpa Sertif</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada event.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.25rem;
        }

        .stats-icon.purple {
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
        }

        .stats-icon.blue {
            background: linear-gradient(45deg, #0ea5e9, #3b82f6);
        }

        .stats-icon.green {
            background: linear-gradient(45deg, #16a34a, #22c55e);
        }

        .stats-icon.red {
            background: linear-gradient(45deg, #f97316, #ef4444);
        }

        .avatar.bg-light-warning {
            background-color: #fff3cd !important;
            color: #856404;
        }

        .avatar.bg-light-secondary {
            background-color: #e9ecef !important;
            color: #495057;
        }

        .avatar.bg-light-primary {
            background-color: #e7f1ff !important;
            color: #0d6efd;
        }

        .avatar-content {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: 700;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('mazer') }}/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
        const chartData = @json($chart);

        // Logs per month
        if (document.querySelector('#chart-logs-month')) {
            new ApexCharts(document.querySelector('#chart-logs-month'), {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: 'Logs',
                    data: chartData.monthTotals
                }],
                colors: ['#435ebe'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: chartData.months,
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: val => Math.round(val)
                    }
                },
                grid: {
                    borderColor: '#eef2f7'
                },
                tooltip: {
                    y: {
                        formatter: val => val + ' logs'
                    }
                }
            }).render();
        }

        // Certificate doughnut
        if (document.querySelector('#chart-sertifikat')) {
            new ApexCharts(document.querySelector('#chart-sertifikat'), {
                chart: {
                    type: 'donut',
                    height: 320,
                    fontFamily: 'inherit'
                },
                series: chartData.sertifikatSeries,
                labels: chartData.sertifikatLabels,
                colors: ['#198754', '#6c757d'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Event',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true
                }
            }).render();
        }

        // Logs per event
        if (document.querySelector('#chart-logs-event')) {
            const hasEventData = chartData.eventTotals && chartData.eventTotals.length > 0;
            new ApexCharts(document.querySelector('#chart-logs-event'), {
                chart: {
                    type: 'bar',
                    height: 340,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: 'Logs',
                    data: hasEventData ? chartData.eventTotals : [0]
                }],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '60%'
                    }
                },
                colors: ['#4f9d69'],
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: hasEventData ? chartData.eventLabels : ['Belum ada data']
                },
                grid: {
                    borderColor: '#eef2f7'
                },
                tooltip: {
                    y: {
                        formatter: val => val + ' logs'
                    }
                }
            }).render();
        }
    </script>
@endpush
