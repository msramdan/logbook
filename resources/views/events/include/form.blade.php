<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-event">{{ __(key: 'Nama Event') }}</label>
            <input type="text" name="nama_event" id="nama-event"
                class="form-control @error('nama_event') is-invalid @enderror"
                value="{{ isset($event) ? $event->nama_event : old(key: 'nama_event') }}"
                placeholder="{{ __(key: 'Nama Event') }}" required />
            @error('nama_event')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal-mulai">{{ __(key: 'Tanggal Mulai') }}</label>
            <input type="datetime-local" name="tanggal_mulai" id="tanggal-mulai"
                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                value="{{ isset($event) && $event?->tanggal_mulai ? $event?->tanggal_mulai?->format('Y-m-d\TH:i') : old(key: 'tanggal_mulai') }}"
                placeholder="{{ __(key: 'Tanggal Mulai') }}" required />
            @error('tanggal_mulai')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal-selesai">{{ __(key: 'Tanggal Selesai') }}</label>
            <input type="datetime-local" name="tanggal_selesai" id="tanggal-selesai"
                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                value="{{ isset($event) && $event?->tanggal_selesai ? $event?->tanggal_selesai?->format('Y-m-d\TH:i') : old(key: 'tanggal_selesai') }}"
                placeholder="{{ __(key: 'Tanggal Selesai') }}" required />
            @error('tanggal_selesai')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-sertifikat">{{ __(key: 'Kode Sertifikat') }}</label>
            <input type="text" name="kode_sertifikat" id="kode-sertifikat"
                class="form-control @error('kode_sertifikat') is-invalid @enderror"
                value="{{ isset($event) ? $event->kode_sertifikat : old(key: 'kode_sertifikat') }}"
                placeholder="{{ __(key: 'Nama Event') }}" required />
            @error('kode_sertifikat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-nc">{{ __(key: 'Nama Ncs') }}</label>
            <input type="text" name="nama_ncs" id="nama-nc"
                class="form-control @error('nama_ncs') is-invalid @enderror"
                value="{{ isset($event) ? $event->nama_ncs : old(key: 'nama_ncs') }}"
                placeholder="{{ __(key: 'Nama Ncs') }}" required />
            @error('nama_ncs')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="callsign-nc">{{ __(key: 'Callsign Ncs') }}</label>
            <input type="text" name="callsign_ncs" id="callsign-nc"
                class="form-control @error('callsign_ncs') is-invalid @enderror"
                value="{{ isset($event) ? $event->callsign_ncs : old(key: 'callsign_ncs') }}"
                placeholder="{{ __(key: 'Callsign Ncs') }}" required />
            @error('callsign_ncs')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="row g-0">
            <div class="col-md-5 text-center">
                <img src="{{ $event?->template_sertifikat ?? 'https://placehold.co/300?text=No+Image+Available' }}"
                    alt="Template Sertifikat" class="rounded img-fluid mt-1" style="width: 300px;" />
            </div>
            <div class="col-md-7">
                <div class="form-group ms-3">
                    <label for="template-sertifikat">{{ __(key: 'Template Sertifikat') }}</label>
                    <input type="file" name="template_sertifikat"
                        class="form-control @error('template_sertifikat') is-invalid @enderror" id="template-sertifikat"
                        {{ !isset($event) ? 'required' : '' }}>
                    @error('template_sertifikat')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    @isset($event)
                        <div id="template-sertifikat-help-block" class="form-text">
                            {{ __(key: 'Leave the template sertifikat blank if you don`t want to change it.') }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row g-0">
            <div class="col-md-5 text-center">
                <img src="{{ $event?->poster ?? 'https://placehold.co/300?text=No+Image+Available' }}" alt="Poster"
                    class="rounded img-fluid mt-1" style="width:300px;" />
            </div>
            <div class="col-md-7">
                <div class="form-group ms-3">
                    <label for="poster">{{ __(key: 'Poster') }}</label>
                    <input type="file" name="poster" class="form-control @error('poster') is-invalid @enderror"
                        id="poster" {{ !isset($event) ? 'required' : '' }}>
                    @error('poster')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    @isset($event)
                        <div id="poster-help-block" class="form-text">
                            {{ __(key: 'Leave the poster blank if you don`t want to change it.') }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>