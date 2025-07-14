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
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 10px;
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
        th, td {
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
        .footer {
            text-align: right;
            font-size: 11px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>
<body>
    <h2>KEMENTERIAN DALAM NEGERI</h2>
    <h1>LAPORAN STATISTIK ARSIP DOKUMEN</h1>
    <hr>

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

    <div class="section">
        <h3>Dokumen per Departemen</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Departemen</th>
                    <th>Jumlah Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentsPerDepartment as $index => $dept)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dept->name }}</td>
                        <td>{{ $dept->documents_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
    </div>
</body>
</html>
