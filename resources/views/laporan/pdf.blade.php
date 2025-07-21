<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Arsip</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #999;
            padding-bottom: 10px;
        }

        .logo {
            width: 70px;
        }

        .title {
            text-align: center;
            flex: 1;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }

        .section {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .summary {
            margin-top: 10px;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .footer {
            text-align: right;
            font-size: 11px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/diskop.png') }}" class="logo">
        <div class="title">
            <h2>DINAS KOPERASI dan UMKM SUMATRA SELATAN</h2>
            <h3>SISTEM INFORMASI ARSIP</h3>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 20px;">LAPORAN STATISTIK DOKUMEN</h1>

    <div class="summary">
        <p><strong>Total Dokumen:</strong> {{ $totalDocuments }}</p>
        <p><strong>Total Unduhan:</strong> {{ $totalDownloads }}</p>
    </div>

    <div class="section">
        <h3>Dokumen per Kategori</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Jumlah Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentsPerCategory as $index => $cat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->documents_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Palembang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p style="margin-top: 50px;">__________________________</p>
        <p style="margin-top: -10px;">Dr. Agus Setiawan<br>NIP. 123456789</p>
    </div>

    <div class="footer">
        Dicetak otomatis oleh sistem • {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
    </div>

</body>

</html>