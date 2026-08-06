@extends('layouts.app')

@section('title', __('Detail of Events'))

@push('styles')
    <style>
        .card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none !important;
            padding: 1rem 1.5rem;
        }

        .card-header h6 {
            color: white !important;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-striped>tbody>tr:nth-of-type(odd)>td {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .template-image,
        .poster-image {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .template-image:hover,
        .poster-image:hover {
            transform: scale(1.05);
        }

        .search-container {
            position: relative;
        }

        .search-loader {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .search-result {
            border-radius: 10px;
            padding: 0;
            margin-top: 1rem;
        }

        .result-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .result-error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
        }

        .result-info-item {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
        }

        .result-label {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .result-value {
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-search {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 0 8px 8px 0;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            transform: scale(1.05);
        }

        .form-control {
            border-radius: 8px 0 0 8px;
            border: 2px solid #e0e6ed;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .back-btn {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border: none;
            color: #333;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .page-title h3 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
        }

        #participantsTable {
            width: 100%;
            border-collapse: collapse;
        }

        #participantsTable th {
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #e0e6ed;
        }

        #participantsTable td {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e6ed;
            vertical-align: middle;
        }

        #participantsTable tr:hover td {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3><i class="fas fa-calendar-alt me-2"></i>{{ __('Events') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of event and participant management.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard"><i class="fas fa-home me-1"></i>{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('events.index') }}">{{ __('Events') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Left: Detail Event --}}
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle"></i>
                                {{ __('Event Details') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tr>
                                        <td class="fw-bold text-muted" style="width: 35%;">
                                            {{ __('Nama Event') }}
                                        </td>
                                        <td class="fw-semibold">{{ $event->nama_event }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Tanggal Mulai') }}
                                        </td>
                                        <td>{{ $event->tanggal_mulai?->format('d M Y, H:i') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Tanggal Selesai') }}
                                        </td>
                                        <td>{{ $event->tanggal_selesai?->format('d M Y, H:i') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Kode Sertifikat') }}
                                        </td>
                                        <td class="fw-semibold">{{ $event->kode_sertifikat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Template Sertifikat') }}
                                        </td>
                                        <td>
                                            <img src="{{ $event->template_sertifikat }}" alt="Template Sertifikat"
                                                class="template-image border"
                                                style="object-fit: cover; width: 350px; height: 200px; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#templateModal">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Nama NCS') }}
                                        </td>
                                        <td>{{ $event->nama_ncs }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Callsign NCS') }}
                                        </td>
                                        <td>
                                            {{ $event->callsign_ncs }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">
                                            {{ __('Poster') }}
                                        </td>
                                        <td>
                                            <img src="{{ $event->poster }}" alt="Poster" class="poster-image border"
                                                style="object-fit: cover; width: 350px; height: 200px; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#posterModal">
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <div class="mt-4">
                                <a href="{{ route('events.index') }}" class="btn back-btn">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Events') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Search + List Peserta --}}
                <div class="col-lg-5">
                    {{-- Search Callsign --}}
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-search"></i>
                                {{ __('Search Callsign') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="searchCallsignForm" onsubmit="return false;">
                                <div class="search-container">
                                    <div class="input-group">
                                        <input type="text" name="callsign" id="callsign" class="form-control"
                                            placeholder="Enter Callsign (e.g., JZ12APB)" autocomplete="off" required>
                                        <button class="btn btn-search btn-primary" type="button" id="btnSearch">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                    <div class="search-loader">
                                        <div class="spinner"></div>
                                    </div>
                                </div>
                            </form>
                            <div id="searchResult" class="search-result"></div>
                        </div>


                    </div>

                    {{-- List Peserta --}}
                    <div class="card shadow-lg border-0">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-users"></i>
                                {{ __('Participants List') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="participantsTable">
                                    <thead>
                                        <tr>
                                            <th>Callsign</th>
                                            <th>Nama Peserta</th>
                                            <th>No. Sertifikat</th>
                                            <th>Waktu Daftar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Participants will be loaded here via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3" id="noParticipants">
                                <i class="fas fa-user-plus fa-3x mb-3 opacity-25"></i>
                                <p>{{ __('Belum ada peserta yang terdaftar.') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    {{-- Template Modal --}}
    <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateModalLabel">{{ __('Template Sertifikat') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $event->template_sertifikat }}" class="img-fluid rounded" alt="Template Sertifikat">
                </div>
            </div>
        </div>
    </div>

    {{-- Poster Modal --}}
    <div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="posterModalLabel">{{ __('Event Poster') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $event->poster }}" class="img-fluid rounded" alt="Poster">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPeserta" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Nama Peserta</td>
                            <td id="pesertaNama"></td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td id="pesertaProvinsi"></td>
                        </tr>
                        <tr>
                            <td>Callsign</td>
                            <td id="pesertaCallsign"></td>
                        </tr>
                        <tr>
                            <td>Masa Laku</td>
                            <td id="pesertaMasaLaku"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="pesertaStatus"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button class="btn btn-primary" id="btnAddParticipant">Tambahkan Peserta</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Load participants function
        // Load participants function
        function loadParticipants() {
            const eventId = {{ $event->id }}; // Ambil ID event untuk URL
            $.ajax({
                url: "{{ route('events.participants', $event->id) }}",
                method: "GET",
                success: function(res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        $('#noParticipants').hide();

                        let html = '';
                        res.data.forEach(participant => {
                            // UBAH BAGIAN INI
                            html += `
                                    <tr>
                                        <td>${participant.callsign}</td>
                                        <td>${participant.nama_peserta}</td>
                                        <td>${participant.nomor_sertifikat}</td>
                                        <td>${new Date(participant.created_at).toLocaleString()}</td>
                                        <td>
                                            <a href="/events/${eventId}/peserta/${participant.id}/download-sertifikat" target="_blank" class="btn btn-sm btn-success" title="Unduh Sertifikat">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteParticipant(${participant.id})" title="Hapus Peserta">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            // AKHIR PERUBAHAN
                        });

                        $('#participantsTable tbody').html(html);
                    } else {
                        $('#noParticipants').show();
                        $('#participantsTable tbody').empty();
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat daftar peserta'
                    });
                }
            });
        }


        // Global function for deleting participants
        function deleteParticipant(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Peserta akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/participants/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                loadParticipants();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Gagal menghapus peserta'
                            });
                        }
                    });
                }
            });
        }

        $(function() {
            const eventId = {{ $event->id }};

            // Load participants on page load
            loadParticipants();

            // Search callsign function
            function searchCallsign() {
                const callsign = $('#callsign').val().trim().toUpperCase();
                if (!callsign) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan masukkan callsign terlebih dahulu.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('participants.search') }}",
                    method: "GET",
                    data: {
                        callsign: callsign
                    },
                    beforeSend: function() {
                        $('.search-loader').show();
                        $('#btnSearch').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Mencari...');
                    },
                    success: function(res) {
                        if (res.status === 'not_found') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tidak Ditemukan',
                                text: 'Callsign ' + callsign +
                                    ' tidak ditemukan dalam database.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else if (res.status === 'success' && res.data) {
                            $('#pesertaNama').text(res.data.nama_pemilik || '-');
                            $('#pesertaProvinsi').text(res.data.provinsi || '-');
                            $('#pesertaCallsign').text(res.data.callsign || callsign);
                            $('#pesertaMasaLaku').text(res.data.masa_laku || '-');
                            $('#pesertaStatus').text(res.data.status || '-');
                            $('#modalPeserta').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Tidak Lengkap',
                                text: 'Data ditemukan tetapi tidak lengkap.',
                                timer: 2500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Gagal melakukan pencarian. Silakan coba lagi.';
                        if (xhr.status === 422) {
                            errorMessage = xhr.responseJSON.message || errorMessage;
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
                        } else if (xhr.status === 0) {
                            errorMessage =
                                'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    },
                    complete: function() {
                        $('.search-loader').hide();
                        $('#btnSearch').prop('disabled', false).html(
                            '<i class="fas fa-search"></i> Cari');
                    }
                });
            }

            // Add participant function
            $('#btnAddParticipant').on('click', function() {
                const callsign = $('#pesertaCallsign').text();
                const namaPeserta = $('#pesertaNama').text();

                if (callsign === '-' || namaPeserta === '-') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Data peserta tidak valid'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('participants.store') }}",
                    method: "POST",
                    data: {
                        event_id: eventId,
                        callsign: callsign,
                        nama_peserta: namaPeserta,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#btnAddParticipant').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Peserta berhasil ditambahkan',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#modalPeserta').modal('hide');
                            loadParticipants();
                            $('#callsign').val('');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Gagal menambahkan peserta';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    },
                    complete: function() {
                        $('#btnAddParticipant').prop('disabled', false).html(
                            'Tambahkan Peserta');
                    }
                });
            });

            // Event listeners
            $('#btnSearch').on('click', function(e) {
                e.preventDefault();
                searchCallsign();
            });

            $('#callsign').on('keypress', function(e) {
                if (e.which === 13 || e.keyCode === 13) {
                    e.preventDefault();
                    searchCallsign();
                }
            });

            $('#callsign').on('focus', function() {
                $('.search-loader').hide();
                $('#btnSearch').prop('disabled', false).html('<i class="fas fa-search"></i> Cari');
            });
        });
    </script>
@endpush
