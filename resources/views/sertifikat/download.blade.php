// File: views/sertifikat/download.blade.php (Setelah diperbaiki)

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat {{ $namaPeserta }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("{{ $templatePath }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .nomor-sertifikat {
            position: absolute;
            top: 30px;
            /* Jarak dari atas */
            right: 10px;
            /* Jarak dari kanan */
            font-size: 16px;
            font-weight: Medium;

            /* color: white; */
            color: black;

        }

        .nama-peserta {
            position: absolute;
            top: 300px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            color: black;
        }
    </style>
</head>

<body>
    {{-- Nomor Sertifikat (tanpa teks "Nomor : ") --}}
    <div class="nomor-sertifikat">
        {{ $nomorSertifikat }}
    </div>

    {{-- Nama Peserta --}}
    <div class="nama-peserta">
        {{ $namaPeserta }} - {{ $callsign }}
    </div>
</body>

</html>
