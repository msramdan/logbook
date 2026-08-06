<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Net Kemerdekaan - RAPI DIY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a4d2e;
            /* Deep forest green */
            --secondary-color: #4f9d69;
            /* Vibrant green */
            --accent-color: #ff9f29;
            /* Golden orange */
            --dark-color: #1e1e1e;
            /* Dark gray */
            --light-color: #f8f9fa;
            /* Light gray */
            --gradient-start: #1a4d2e;
            --gradient-end: #4f9d69;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            padding: 0;
            margin: 0;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(26, 77, 46, 0.05) 0%, rgba(26, 77, 46, 0.05) 90%),
                linear-gradient(135deg, #f5f7fa 0%, #f0f4f8 100%);
            min-height: 100vh;
        }

        .container-box {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            padding: 0;
            position: relative;
            z-index: 1;
            border: none;
        }

        .container-box::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            z-index: 0;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);
        }

        .header-container {
            position: relative;
            padding: 40px 40px 0;
            margin-bottom: 30px;
            text-align: center;
            color: white;
        }

        .header-logo {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .header-logo img {
            height: 100px;
            margin-bottom: 15px;
            transition: transform 0.3s;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        }

        .header-logo:hover {
            transform: translateY(-5px);
        }

        .header-logo img:hover {
            transform: scale(1.05) rotate(-2deg);
        }

        .header-title {
            margin: 20px 0;
            position: relative;
            display: inline-block;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-title h1 {
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin: 0;
            font-size: 2rem;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
            font-weight: 400;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .header-banner {
            width: 100%;
            max-width: 900px;
            border-radius: 15px;
            margin: 0 auto 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            display: block;
            border: 3px solid white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 2;
            transform: perspective(1000px) rotateX(0deg) rotateY(0deg);
        }

        .header-banner:hover {
            transform: perspective(1000px) rotateX(1deg) rotateY(-1deg) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .content-area {
            padding: 0 40px 40px;
            position: relative;
            z-index: 2;
        }

        .search-box {
            position: relative;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            z-index: 3;
        }

        .search-box input {
            padding-left: 50px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 50px;
            transition: all 0.3s;
            font-size: 1rem;
            border: 2px solid transparent;
            background: white;
        }

        .search-box input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 15px 30px rgba(79, 157, 105, 0.2);
            outline: none;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2em;
            z-index: 4;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
            position: relative;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
            color: white;
            position: sticky;
            top: 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table th {
            padding: 15px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
            border: none;
            position: relative;
        }

        .table th:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 15%;
            height: 70%;
            width: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        .table td {
            padding: 15px 20px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: rgba(79, 157, 105, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:hover td {
            color: var(--primary-color);
        }

        .badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            font-weight: 600;
            padding: 8px 15px;
            min-width: 90px;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(26, 77, 46, 0.2);
            letter-spacing: 0.5px;
            display: inline-block;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .btn-download {
            background: linear-gradient(135deg, var(--accent-color), #ff8a00);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9em;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(255, 159, 41, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            /* Tambahkan ini agar tidak ada garis bawah */
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #ff8a00, var(--accent-color));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 159, 41, 0.4);
            color: white;
        }

        .btn-download i {
            margin-right: 8px;
            font-size: 1.1em;
        }

        .footer {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            color: #666;
            font-size: 0.9em;
            position: relative;
            z-index: 1;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .footer .text-muted {
            font-size: 0.8em;
        }

        .pagination .page-link {
            border: 1px solid var(--secondary-color);
            color: var(--primary-color);
            padding: 6px 14px;
            font-weight: 500;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .pagination .page-item.active .page-link {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }

        .pagination .page-link:hover {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 0;
            color: #666;
        }

        .empty-state i {
            font-size: 4em;
            color: #e0e0e0;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-box">
        <div class="header-container">
            <div class="header-logo">
                <img src="{{ asset('logo.png') }}" alt="Logo RAPI DIY">
            </div>
            <div class="text-center">
                @if ($lastEvent && $lastEvent->poster)
                    <img src="{{ $lastEvent->poster }}" alt="Banner RAPI DIY" class="header-banner">
                @endif
                <h3 class="mt-3"
                    style="color: var(--primary-color); font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    LOGBOOK RAPIDA 12 DIY
                </h3>
            </div>
        </div>

        <div class="content-area">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control"
                    placeholder="Cari berdasarkan callsign, peserta, atau nama event...">
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th><i class="bi bi-broadcast me-2"></i>Callsign</th>
                                <th><i class="bi bi-person me-2"></i>Peserta</th>
                                <th><i class="bi bi-file-earmark-text me-2"></i>Sertifikat</th>
                                <th><i class="bi bi-calendar-event me-2"></i>Nama Event</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="pagination-links">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let searchTerm = '';
        let currentPage = 1;
        let searchTimeout;

        document.addEventListener('DOMContentLoaded', function() {
            loadPeserta();

            document.getElementById('searchInput').addEventListener('keyup', function() {
                searchTerm = this.value;
                currentPage = 1;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadPeserta();
                }, 300); // Delay 300ms sebelum melakukan pencarian
            });
        });

        function loadPeserta(page = 1) {
            fetch(`/get-peserta?search=${encodeURIComponent(searchTerm)}&page=${page}`)
                .then(res => res.json())
                .then(res => {
                    const tbody = document.getElementById('table-body');
                    tbody.innerHTML = '';

                    if (res.data.length > 0) {
                        res.data.forEach(item => {
                            // === PERUBAHAN UTAMA ADA DI SINI ===
                            // Membuat URL unduh dengan format yang benar
                            const downloadUrl =
                                `/events/${item.event_id}/peserta/${item.id}/download-sertifikat`;

                            tbody.innerHTML += `
                                <tr>
                                    <td><span class="badge">${item.callsign}</span></td>
                                    <td><strong>${item.nama_peserta}</strong></td>
                                    <td>
                                        <a href="${downloadUrl}" target="_blank" class="btn-download">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    </td>
                                    <td>${item.nama_event}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Data Tidak Ditemukan</h5>
                                    <p>Silakan coba dengan kata kunci lain.</p>
                                </td>
                            </tr>
                        `;
                    }

                    renderPagination(res.pagination);
                });
        }

        function gotoPage(page) {
            currentPage = page;
            loadPeserta(page);
        }

        function renderPagination(pagination) {
            const paginationContainer = document.getElementById('pagination-links');
            paginationContainer.innerHTML = '';

            if (pagination.last_page > 1) {
                // Tombol Previous
                paginationContainer.innerHTML += `
                    <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${pagination.current_page - 1})">&laquo;</a>
                    </li>
                `;

                // Tombol Halaman
                for (let i = 1; i <= pagination.last_page; i++) {
                    paginationContainer.innerHTML += `
                        <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${i})">${i}</a>
                        </li>
                    `;
                }

                // Tombol Next
                paginationContainer.innerHTML += `
                    <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${pagination.current_page + 1})">&raquo;</a>
                    </li>
                `;
            }
        }
    </script>
</body>

</html>
