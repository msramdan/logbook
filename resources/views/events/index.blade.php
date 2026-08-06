@extends('layouts.app')

@section('title', __(key: 'Events'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __(key: 'Events') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __(key: 'Below is a list of all events.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __(key: 'Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __(key: 'Events') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            <div class="d-flex justify-content-end">
                {{-- @can('event create') --}}
                <a href="{{ route(name: 'events.create') }}" class="btn btn-primary mb-3 me-3">
                    <i class="fas fa-plus"></i>
                    {{ __(key: 'Create a new event') }}
                </a>
                {{-- @endcan --}}


            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __(key: 'Nama Event') }}</th>
                                            <th>{{ __(key: 'Tanggal Mulai') }}</th>
                                            <th>{{ __(key: 'Tanggal Selesai') }}</th>
                                            <th>{{ __(key: 'Kode Sertifikat') }}</th>
                                            <th>{{ __(key: 'Nama Ncs') }}</th>
                                            <th>{{ __(key: 'Callsign Ncs') }}</th>
                                            <th>{{ __(key: 'Template Sertifikat') }}</th>
                                            <th>{{ __(key: 'Poster') }}</th>
                                            <th>{{ __(key: 'Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route(name: 'events.index') }}",
            columns: [{
                    data: 'nama_event',
                    name: 'nama_event',
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai',
                },
                {
                    data: 'tanggal_selesai',
                    name: 'tanggal_selesai',
                },
                {
                    data: 'kode_sertifikat',
                    name: 'kode_sertifikat',
                },
                {
                    data: 'nama_ncs',
                    name: 'nama_ncs',
                },
                {
                    data: 'callsign_ncs',
                    name: 'callsign_ncs',
                },
                {
                    data: 'template_sertifikat',
                    name: 'template_sertifikat',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `<div >
                            <img src="${data}" alt="Template Sertifikat" style="width:100px"  />
                        </div>`;
                    }
                },
                {
                    data: 'poster',
                    name: 'poster',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `<div >
                            <img src="${data}" alt="Poster" style="width:100px"  />
                        </div>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
