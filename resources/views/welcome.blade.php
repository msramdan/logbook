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

        /* ===== Top 5 Ranking ===== */
        .ranking-section {
            margin: 0 auto 28px;
            max-width: 900px;
        }

        .ranking-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 18px;
            text-align: center;
        }

        .ranking-header h4 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.15rem;
            letter-spacing: 0.3px;
        }

        .ranking-header .trophy {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f6c945, #f39c12);
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 8px 18px rgba(243, 156, 18, 0.35);
        }

        .ranking-header p {
            margin: 4px 0 0;
            font-size: 0.82rem;
            color: #6c757d;
            font-weight: 400;
        }

        .ranking-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rank-card {
            display: grid;
            grid-template-columns: 56px 1fr auto;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(26, 77, 46, 0.08);
            box-shadow: 0 8px 22px rgba(26, 77, 46, 0.07);
            position: relative;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            animation: rankSlideIn 0.5s ease both;
        }

        .rank-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(26, 77, 46, 0.12);
        }

        .rank-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--secondary-color);
        }

        .rank-card.rank-1 {
            background: linear-gradient(90deg, rgba(246, 201, 69, 0.14), #fff 45%);
        }

        .rank-card.rank-1::before {
            background: linear-gradient(180deg, #f6c945, #e67e22);
            width: 5px;
        }

        .rank-card.rank-2 {
            background: linear-gradient(90deg, rgba(189, 195, 199, 0.22), #fff 45%);
        }

        .rank-card.rank-2::before {
            background: linear-gradient(180deg, #bdc3c7, #7f8c8d);
        }

        .rank-card.rank-3 {
            background: linear-gradient(90deg, rgba(205, 127, 50, 0.14), #fff 45%);
        }

        .rank-card.rank-3::before {
            background: linear-gradient(180deg, #cd7f32, #a65e1d);
        }

        .rank-card.has-others {
            cursor: pointer;
        }

        .rank-card.has-others:hover {
            border-color: rgba(26, 77, 46, 0.25);
        }

        .rank-others {
            display: inline-flex;
            align-items: center;
            margin-left: 6px;
            padding: 2px 10px;
            border-radius: 999px;
            background: rgba(26, 77, 46, 0.1);
            color: var(--primary-color);
            font-size: 0.72rem;
            font-weight: 600;
            vertical-align: middle;
            white-space: nowrap;
            transition: background 0.2s;
        }

        .rank-card.has-others:hover .rank-others {
            background: var(--primary-color);
            color: #fff;
        }

        .rank-name-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
            min-width: 0;
        }

        .rank-name-row .name {
            margin: 0;
            max-width: 100%;
        }

        .rank-hint {
            margin-top: 4px;
            font-size: 0.7rem;
            color: #8a9590;
            font-style: italic;
        }

        /* Ranking modal */
        .rank-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 30, 20, 0.55);
            z-index: 1050;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(3px);
        }

        .rank-modal-backdrop.show {
            display: flex;
        }

        .rank-modal {
            width: 100%;
            max-width: 480px;
            max-height: min(80vh, 560px);
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: rankSlideIn 0.3s ease both;
        }

        .rank-modal-header {
            padding: 18px 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .rank-modal-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .rank-modal-header p {
            margin: 2px 0 0;
            font-size: 0.78rem;
            opacity: 0.9;
        }

        .rank-modal-close {
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .rank-modal-close:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .rank-modal-body {
            padding: 12px 16px 18px;
            overflow-y: auto;
        }

        .rank-modal-item {
            display: grid;
            grid-template-columns: 36px 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 12px 10px;
            border-bottom: 1px solid #eef2ef;
        }

        .rank-modal-item:last-child {
            border-bottom: none;
        }

        .rank-modal-item .no {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #eef5f0;
            color: var(--primary-color);
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rank-modal-item .cs {
            display: inline-flex;
            padding: 2px 10px;
            border-radius: 999px;
            background: var(--primary-color);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .rank-modal-item .nm {
            margin: 0;
            font-size: 0.88rem;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
        }

        .rank-modal-item .lg {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .rank-modal-item .lg small {
            display: block;
            font-size: 0.65rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* Clickable participant links */
        .participant-link {
            cursor: pointer;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }

        .participant-link:hover {
            opacity: 0.88;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .table .badge.participant-link:hover {
            text-decoration: none;
            transform: scale(1.04);
        }

        strong.participant-link {
            color: inherit;
        }

        /* Participant detail modal */
        .detail-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 30, 20, 0.55);
            z-index: 1100;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(3px);
        }

        .detail-modal-backdrop.show {
            display: flex;
        }

        .detail-modal {
            width: 100%;
            max-width: 520px;
            max-height: min(85vh, 640px);
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: rankSlideIn 0.3s ease both;
        }

        .detail-modal-header {
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .detail-modal-header .cs {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .detail-modal-header h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .detail-modal-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 16px 16px 8px;
        }

        .detail-stat {
            background: #f4f8f5;
            border-radius: 14px;
            padding: 12px 10px;
            text-align: center;
            border: 1px solid rgba(26, 77, 46, 0.08);
        }

        .detail-stat .val {
            display: block;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1.1;
        }

        .detail-stat .lbl {
            font-size: 0.68rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-stat.rank-stat {
            background: linear-gradient(135deg, rgba(246, 201, 69, 0.2), rgba(79, 157, 105, 0.12));
        }

        .detail-modal-body {
            padding: 8px 16px 18px;
            overflow-y: auto;
        }

        .detail-modal-body h6 {
            margin: 8px 0 10px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .detail-event-item {
            padding: 10px 12px;
            border-radius: 12px;
            background: #f8faf9;
            border: 1px solid #eef2ef;
            margin-bottom: 8px;
        }

        .detail-event-item .en {
            font-weight: 600;
            font-size: 0.88rem;
            color: #2c3e50;
            margin: 0 0 2px;
        }

        .detail-event-item .ed {
            margin: 0;
            font-size: 0.75rem;
            font-style: italic;
            color: #6c757d;
        }

        .detail-loading,
        .detail-error {
            text-align: center;
            padding: 28px 16px;
            color: #6c757d;
        }

        .detail-error {
            color: #b02a37;
        }

        .rank-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            box-shadow: 0 8px 16px rgba(26, 77, 46, 0.2);
            line-height: 1.1;
        }

        .rank-card.rank-1 .rank-badge {
            background: linear-gradient(135deg, #f6c945, #e67e22);
            box-shadow: 0 8px 16px rgba(230, 126, 34, 0.35);
        }

        .rank-card.rank-2 .rank-badge {
            background: linear-gradient(135deg, #d5d8dc, #7f8c8d);
            box-shadow: 0 8px 16px rgba(127, 140, 141, 0.35);
        }

        .rank-card.rank-3 .rank-badge {
            background: linear-gradient(135deg, #e0a96d, #a65e1d);
            box-shadow: 0 8px 16px rgba(166, 94, 29, 0.35);
        }

        .rank-badge small {
            font-size: 0.58rem;
            font-weight: 600;
            letter-spacing: 0.6px;
            opacity: 0.9;
            text-transform: uppercase;
        }

        .rank-badge strong {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .rank-info {
            min-width: 0;
        }

        .rank-info .callsign-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 999px;
            background: var(--primary-color);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            box-shadow: 0 4px 10px rgba(26, 77, 46, 0.2);
            margin-bottom: 4px;
        }

        .rank-info .name {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rank-progress {
            margin-top: 8px;
            height: 6px;
            background: #eef2ef;
            border-radius: 999px;
            overflow: hidden;
        }

        .rank-progress span {
            display: block;
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
            transition: width 0.8s ease;
        }

        .rank-stat {
            text-align: right;
            min-width: 78px;
        }

        .rank-stat .count {
            display: block;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .rank-stat .label {
            font-size: 0.7rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .ranking-empty {
            text-align: center;
            padding: 24px;
            color: #6c757d;
            background: #f8faf9;
            border-radius: 16px;
            border: 1px dashed rgba(26, 77, 46, 0.15);
        }

        @keyframes rankSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .rank-card {
                grid-template-columns: 44px 1fr;
                gap: 10px;
                padding: 12px 14px;
            }

            .rank-badge {
                width: 42px;
                height: 42px;
                border-radius: 12px;
            }

            .rank-stat {
                grid-column: 2;
                text-align: left;
                min-width: 0;
                display: flex;
                align-items: baseline;
                gap: 6px;
            }

            .rank-stat .count {
                font-size: 1.15rem;
            }
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

        .filter-date-box {
            max-width: 600px;
            margin: -10px auto 30px;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }

        .filter-date-box label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 4px;
            display: block;
        }

        .filter-date-box input[type="date"] {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            height: 42px;
            padding: 0 12px;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            background: white;
            width: 100%;
        }

        .filter-date-box input[type="date"]:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 8px 16px rgba(79, 157, 105, 0.15);
        }

        .filter-date-box .btn-reset-filter {
            height: 42px;
            border-radius: 12px;
            border: none;
            background: #e9ecef;
            color: #495057;
            padding: 0 14px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .filter-date-box .btn-reset-filter:hover {
            background: #dee2e6;
            color: var(--primary-color);
        }

        @media (max-width: 576px) {
            .filter-date-box {
                grid-template-columns: 1fr;
            }

            .filter-date-box .btn-reset-filter {
                width: 100%;
            }
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
            @if ($topPeserta->isNotEmpty())
                @php
                    $maxLog = max(1, (int) $topPeserta->max('jumlah_log'));
                @endphp
                <div class="ranking-section">
                    <div class="ranking-header flex-column">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="trophy"><i class="bi bi-trophy-fill"></i></div>
                            <h4>Top 5 Partisipan Teraktif</h4>
                        </div>
                        <p>Peringkat berdasarkan jumlah logs terbanyak (log sama = rank sama)</p>
                    </div>

                    <div class="ranking-list">
                        @foreach ($topPeserta as $index => $group)
                            @php
                                $rank = $group->rank;
                                $row = $group->display;
                                $percent = min(100, round(($group->jumlah_log / $maxLog) * 100));
                                $hasOthers = $group->others_count > 0;
                            @endphp
                            <div
                                class="rank-card {{ $rank <= 3 ? 'rank-'.$rank : '' }} {{ $hasOthers ? 'has-others' : '' }}"
                                style="animation-delay: {{ $index * 0.08 }}s"
                                @if ($hasOthers)
                                    role="button"
                                    tabindex="0"
                                    data-rank-modal="rank-modal-{{ $rank }}"
                                    aria-label="Lihat semua di rank {{ $rank }}"
                                @endif
                            >
                                <div class="rank-badge">
                                    <small>Rank</small>
                                    <strong>{{ $rank }}</strong>
                                </div>
                                <div class="rank-info">
                                    <span class="callsign-pill participant-link"
                                        data-callsign="{{ $row->callsign }}"
                                        title="Lihat detail">{{ $row->callsign }}</span>
                                    <div class="rank-name-row">
                                        <p class="name participant-link"
                                            data-callsign="{{ $row->callsign }}"
                                            title="{{ $row->nama_peserta }} — lihat detail">{{ $row->nama_peserta }}</p>
                                        @if ($hasOthers)
                                            <span class="rank-others" data-rank-others="+">+ {{ $group->others_count }} orang lain</span>
                                        @endif
                                    </div>
                                    @if ($hasOthers)
                                        <div class="rank-hint">Ketuk +orang lain untuk daftar rank, atau nama/callsign untuk detail</div>
                                    @endif
                                    <div class="rank-progress" aria-hidden="true">
                                        <span style="width: {{ $percent }}%"></span>
                                    </div>
                                </div>
                                <div class="rank-stat">
                                    <span class="count">{{ $group->jumlah_log }}</span>
                                    <span class="label">{{ $group->jumlah_log > 1 ? 'Logs' : 'Log' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Popup daftar rank dengan multi partisipan --}}
                @foreach ($topPeserta as $group)
                    @if ($group->others_count > 0)
                        <div class="rank-modal-backdrop" id="rank-modal-{{ $group->rank }}" aria-hidden="true">
                            <div class="rank-modal" role="dialog" aria-modal="true"
                                aria-labelledby="rank-modal-title-{{ $group->rank }}">
                                <div class="rank-modal-header">
                                    <div>
                                        <h5 id="rank-modal-title-{{ $group->rank }}">
                                            Rank {{ $group->rank }} — {{ $group->jumlah_log }} Logs
                                        </h5>
                                        <p>{{ $group->members->count() }} partisipan (urutan abjad)</p>
                                    </div>
                                    <button type="button" class="rank-modal-close" data-close-modal
                                        aria-label="Tutup">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                                <div class="rank-modal-body">
                                    @foreach ($group->members as $i => $m)
                                        <div class="rank-modal-item">
                                            <div class="no">{{ $i + 1 }}</div>
                                            <div>
                                                <span class="cs participant-link"
                                                    data-callsign="{{ $m->callsign }}">{{ $m->callsign }}</span>
                                                <p class="nm participant-link"
                                                    data-callsign="{{ $m->callsign }}">{{ $m->nama_peserta }}</p>
                                            </div>
                                            <div class="lg">
                                                {{ $m->jumlah_log }}
                                                <small>Logs</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            {{-- Popup detail partisipan --}}
            <div class="detail-modal-backdrop" id="peserta-detail-modal" aria-hidden="true">
                <div class="detail-modal" role="dialog" aria-modal="true" aria-labelledby="peserta-detail-title">
                    <div class="detail-modal-header">
                        <div>
                            <span class="cs" id="detail-callsign">—</span>
                            <h5 id="peserta-detail-title">—</h5>
                        </div>
                        <button type="button" class="rank-modal-close" data-close-detail aria-label="Tutup">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="detail-modal-stats" id="detail-stats" style="display:none;">
                        <div class="detail-stat rank-stat">
                            <span class="val" id="detail-rank">—</span>
                            <span class="lbl">Rank Global</span>
                        </div>
                        <div class="detail-stat">
                            <span class="val" id="detail-logs">—</span>
                            <span class="lbl">Total Logs</span>
                        </div>
                        <div class="detail-stat">
                            <span class="val" id="detail-events">—</span>
                            <span class="lbl">Event Diikuti</span>
                        </div>
                    </div>
                    <div class="detail-modal-body" id="detail-body">
                        <div class="detail-loading">Memuat data...</div>
                    </div>
                </div>
            </div>

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control"
                    placeholder="Cari berdasarkan callsign, peserta, atau nama event...">
            </div>

            <div class="filter-date-box">
                <div>
                    <label for="filterTanggalMulai"><i class="bi bi-calendar3 me-1"></i>Tanggal Mulai</label>
                    <input type="date" id="filterTanggalMulai">
                </div>
                <div>
                    <label for="filterTanggalSelesai"><i class="bi bi-calendar3 me-1"></i>Tanggal Selesai</label>
                    <input type="date" id="filterTanggalSelesai">
                </div>
                <button type="button" id="btnResetFilter" class="btn-reset-filter" title="Reset filter tanggal">
                    <i class="bi bi-x-circle"></i> Reset
                </button>
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
        let tanggalMulaiFilter = '';
        let tanggalSelesaiFilter = '';
        let currentPage = 1;
        let searchTimeout;

        document.addEventListener('DOMContentLoaded', function() {
            loadPeserta();

            // Ranking popup: log sama = rank sama
            document.querySelectorAll('[data-rank-modal]').forEach(function(card) {
                const openModal = function(e) {
                    // Jangan buka list rank jika klik detail partisipan
                    if (e.target.closest('.participant-link')) {
                        return;
                    }
                    // Hanya buka list bila ada badge +orang lain / area card
                    const modal = document.getElementById(card.getAttribute('data-rank-modal'));
                    if (modal) {
                        modal.classList.add('show');
                        modal.setAttribute('aria-hidden', 'false');
                        document.body.style.overflow = 'hidden';
                    }
                };
                card.addEventListener('click', openModal);
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openModal(e);
                    }
                });
            });

            document.querySelectorAll('[data-close-modal]').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const modal = btn.closest('.rank-modal-backdrop');
                    if (modal) {
                        modal.classList.remove('show');
                        modal.setAttribute('aria-hidden', 'true');
                        if (!document.querySelector('.detail-modal-backdrop.show')) {
                            document.body.style.overflow = '';
                        }
                    }
                });
            });

            document.querySelectorAll('.rank-modal-backdrop').forEach(function(backdrop) {
                backdrop.addEventListener('click', function(e) {
                    if (e.target === backdrop) {
                        backdrop.classList.remove('show');
                        backdrop.setAttribute('aria-hidden', 'true');
                        if (!document.querySelector('.detail-modal-backdrop.show')) {
                            document.body.style.overflow = '';
                        }
                    }
                });
            });

            // Detail partisipan (delegation untuk table + ranking)
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.participant-link');
                if (!link) return;
                e.preventDefault();
                e.stopPropagation();
                const callsign = link.getAttribute('data-callsign');
                if (callsign) {
                    openPesertaDetail(callsign);
                }
            });

            document.querySelectorAll('[data-close-detail]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    closePesertaDetail();
                });
            });

            const detailBackdrop = document.getElementById('peserta-detail-modal');
            if (detailBackdrop) {
                detailBackdrop.addEventListener('click', function(e) {
                    if (e.target === detailBackdrop) {
                        closePesertaDetail();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closePesertaDetail();
                    document.querySelectorAll('.rank-modal-backdrop.show').forEach(function(modal) {
                        modal.classList.remove('show');
                        modal.setAttribute('aria-hidden', 'true');
                    });
                    document.body.style.overflow = '';
                }
            });

            document.getElementById('searchInput').addEventListener('keyup', function() {
                searchTerm = this.value;
                currentPage = 1;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadPeserta();
                }, 300); // Delay 300ms sebelum melakukan pencarian
            });

            document.getElementById('filterTanggalMulai').addEventListener('change', function() {
                tanggalMulaiFilter = this.value;
                currentPage = 1;
                loadPeserta();
            });

            document.getElementById('filterTanggalSelesai').addEventListener('change', function() {
                tanggalSelesaiFilter = this.value;
                currentPage = 1;
                loadPeserta();
            });

            document.getElementById('btnResetFilter').addEventListener('click', function() {
                document.getElementById('filterTanggalMulai').value = '';
                document.getElementById('filterTanggalSelesai').value = '';
                tanggalMulaiFilter = '';
                tanggalSelesaiFilter = '';
                currentPage = 1;
                loadPeserta();
            });
        });

        function formatTanggal(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(String(dateStr).replace(' ', 'T'));
            if (isNaN(d.getTime())) return dateStr;
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        function openPesertaDetail(callsign) {
            const backdrop = document.getElementById('peserta-detail-modal');
            const body = document.getElementById('detail-body');
            const stats = document.getElementById('detail-stats');

            if (!backdrop) return;

            document.getElementById('detail-callsign').textContent = callsign;
            document.getElementById('peserta-detail-title').textContent = 'Memuat...';
            stats.style.display = 'none';
            body.innerHTML = '<div class="detail-loading"><i class="bi bi-arrow-repeat"></i> Memuat data partisipan...</div>';
            backdrop.classList.add('show');
            backdrop.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            fetch(`/get-peserta-detail?callsign=${encodeURIComponent(callsign)}`)
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => Promise.reject(err));
                    }
                    return res.json();
                })
                .then(data => {
                    document.getElementById('detail-callsign').textContent = data.callsign;
                    document.getElementById('peserta-detail-title').textContent = data.nama_peserta;
                    document.getElementById('detail-rank').textContent = data.rank ?? '—';
                    document.getElementById('detail-logs').textContent = data.jumlah_log ?? 0;
                    document.getElementById('detail-events').textContent = data.jumlah_event ?? 0;
                    stats.style.display = 'grid';

                    let peersNote = '';
                    if (data.peers_at_rank > 1) {
                        peersNote = `<p style="margin:0 0 10px;font-size:0.8rem;color:#6c757d;">
                            Rank ${data.rank} dipegang bersama ${data.peers_at_rank} partisipan (log sama).
                        </p>`;
                    }

                    let eventsHtml = '';
                    if (data.events && data.events.length > 0) {
                        eventsHtml = data.events.map(ev => {
                            const tgl = `${formatTanggal(ev.tanggal_mulai)} – ${formatTanggal(ev.tanggal_selesai)}`;
                            return `<div class="detail-event-item">
                                <p class="en">${ev.nama_event || '-'}</p>
                                <p class="ed">${tgl} · ${ev.jumlah_log_event} log</p>
                            </div>`;
                        }).join('');
                    } else {
                        eventsHtml = '<div class="detail-loading">Belum ada daftar event.</div>';
                    }

                    body.innerHTML = `
                        ${peersNote}
                        <h6><i class="bi bi-calendar-event me-1"></i>Event yang diikuti (${data.jumlah_event || 0})</h6>
                        ${eventsHtml}
                    `;
                })
                .catch(err => {
                    document.getElementById('peserta-detail-title').textContent = 'Gagal memuat';
                    stats.style.display = 'none';
                    body.innerHTML = `<div class="detail-error">${err.message || 'Data partisipan tidak ditemukan.'}</div>`;
                });
        }

        function closePesertaDetail() {
            const backdrop = document.getElementById('peserta-detail-modal');
            if (!backdrop) return;
            backdrop.classList.remove('show');
            backdrop.setAttribute('aria-hidden', 'true');
            if (!document.querySelector('.rank-modal-backdrop.show')) {
                document.body.style.overflow = '';
            }
        }

        function loadPeserta(page = 1) {
            const params = new URLSearchParams({
                search: searchTerm,
                page: page
            });

            if (tanggalMulaiFilter) {
                params.set('tanggal_mulai', tanggalMulaiFilter);
            }
            if (tanggalSelesaiFilter) {
                params.set('tanggal_selesai', tanggalSelesaiFilter);
            }

            fetch(`/get-peserta?${params.toString()}`)
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
                            const tanggalEvent =
                                `${formatTanggal(item.tanggal_mulai)} – ${formatTanggal(item.tanggal_selesai)}`;
                            const adaSertifikat = item.ada_sertifikat == 1 || item.ada_sertifikat === true;
                            const sertifikatCell = adaSertifikat
                                ? `<a href="${downloadUrl}" target="_blank" class="btn-download">
                                        <i class="bi bi-download"></i> Unduh
                                   </a>`
                                : `<span class="text-muted" style="font-size: 0.85rem; font-style: italic;">—</span>`;
                            const cs = String(item.callsign || '').replace(/"/g, '&quot;');
                            const nama = String(item.nama_peserta || '').replace(/</g, '&lt;');

                            tbody.innerHTML += `
                                <tr>
                                    <td>
                                        <span class="badge participant-link" data-callsign="${cs}" title="Lihat detail">${cs}</span>
                                    </td>
                                    <td>
                                        <strong class="participant-link" data-callsign="${cs}" title="Lihat detail">${nama}</strong>
                                    </td>
                                    <td>
                                        ${sertifikatCell}
                                    </td>
                                    <td>
                                        <div>${item.nama_event}</div>
                                        <div style="font-size: 0.8rem; font-style: italic; color: #6c757d; margin-top: 2px;">
                                            ${tanggalEvent}
                                        </div>
                                    </td>
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

            const current = pagination.current_page;
            const last = pagination.last_page;
            const maxVisible = 10;

            if (last <= 1) return;

            // Tombol Previous
            paginationContainer.innerHTML += `
                <li class="page-item ${current === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${current - 1})">&laquo;</a>
                </li>
            `;

            // Hitung rentang halaman (maks 10 nomor)
            let start = Math.max(1, current - Math.floor(maxVisible / 2));
            let end = start + maxVisible - 1;

            if (end > last) {
                end = last;
                start = Math.max(1, end - maxVisible + 1);
            }

            if (start > 1) {
                paginationContainer.innerHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(1)">1</a>
                    </li>
                `;
                if (start > 2) {
                    paginationContainer.innerHTML += `
                        <li class="page-item disabled">
                            <span class="page-link">…</span>
                        </li>
                    `;
                }
            }

            for (let i = start; i <= end; i++) {
                paginationContainer.innerHTML += `
                    <li class="page-item ${i === current ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${i})">${i}</a>
                    </li>
                `;
            }

            if (end < last) {
                if (end < last - 1) {
                    paginationContainer.innerHTML += `
                        <li class="page-item disabled">
                            <span class="page-link">…</span>
                        </li>
                    `;
                }
                paginationContainer.innerHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${last})">${last}</a>
                    </li>
                `;
            }

            // Tombol Next
            paginationContainer.innerHTML += `
                <li class="page-item ${current === last ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); gotoPage(${current + 1})">&raquo;</a>
                </li>
            `;
        }
    </script>
</body>

</html>
