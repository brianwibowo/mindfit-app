<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - MindFit</title>
    <style>
        @page {
            size: a4;
            margin: 20mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            font-size: 11px;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-cell {
            width: 15%;
            text-align: left;
            vertical-align: middle;
        }
        .logo-img {
            max-height: 60px;
            width: auto;
        }
        .header-cell {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-right: 40px;
        }
        .header-cell h1 {
            font-size: 22px;
            margin: 0;
            color: #1a2035;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header-cell p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #555;
        }

        /* Report Title */
        .report-title {
            text-align: center;
            margin-bottom: 25px;
        }
        .report-title h2 {
            font-size: 16px;
            margin: 0 0 4px 0;
            text-decoration: underline;
            text-transform: uppercase;
            color: #1a2035;
        }
        .report-title p {
            margin: 0;
            color: #555;
            font-style: italic;
        }

        /* Summary Cards Table */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-card {
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 12px;
            text-align: center;
        }
        .summary-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .summary-val {
            font-size: 14px;
            font-weight: bold;
            color: #1a2035;
        }

        /* Section Title */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #1a2035;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            text-transform: uppercase;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-align: left;
            border: 1px solid #ddd;
            padding: 8px 12px;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-success {
            color: #2ecc71;
            font-weight: bold;
        }
        .text-danger {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Signature block */
        .signature-section {
            margin-top: 40px;
            width: 100%;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 220px;
        }
        .signature-box p {
            margin: 0;
        }
        .signature-space {
            height: 60px;
        }
        
        .footer-note {
            margin-top: 30px;
            font-size: 9px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT (LETTERHEAD) -->
    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('storage/images/logo.png') }}" class="logo-img" alt="MindFit Logo">
            </td>
            <td class="header-cell">
                <h1>MindFit Coaching Platform</h1>
                <p style="font-style: italic; font-weight: bold; color: #1a2035; margin: 4px 0;">Train smart. Live balanced.</p>
                <p>Email: admin@mindfit.co.id | WA: +62 851-9961-5786 | Website: https://mindfit.id</p>
            </td>
        </tr>
    </table>

    <!-- REPORT TITLE -->
    <div class="report-title">
        <h2>Laporan Keuangan MindFit</h2>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }} WIB</p>
    </div>

    <!-- Summary Cards -->
    <table class="summary-table">
        <tr>
            <td class="summary-card" style="width: 32%; border-left: 4px solid #2ecc71;">
                <div class="summary-label">Total Pemasukan</div>
                <div class="summary-val text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td style="width: 2%;"></td>
            <td class="summary-card" style="width: 32%; border-left: 4px solid #e74c3c;">
                <div class="summary-label">Total Pengeluaran</div>
                <div class="summary-val text-danger">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
            </td>
            <td style="width: 2%;"></td>
            <td class="summary-card" style="width: 32%; border-left: 4px solid #3498db;">
                <div class="summary-label">Laba Bersih</div>
                <div class="summary-val" style="color: {{ $netProfit >= 0 ? '#3498db' : '#e74c3c' }}">
                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Pemasukan Section -->
    <div class="section-title">A. Rincian Pemasukan (Pembayaran Klien)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Nama Klien</th>
                <th style="width: 35%;">Nama Paket</th>
                <th style="width: 20%;" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $noIncome = 1; @endphp
            @forelse($payments as $payment)
                @php
                    $incomeVal = $payment->package_data['total_price'] ?? $payment->package_data['package_price'] ?? 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $noIncome++ }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>{{ $payment->user->name ?? 'Klien Mindfit' }}</td>
                    <td>{{ $payment->package_data['package_name'] ?? 'Paket Premium' }}</td>
                    <td class="text-right text-success">Rp {{ number_format($incomeVal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-muted">Tidak ada data pemasukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pengeluaran Section -->
    <div class="section-title">B. Rincian Pengeluaran Operasional</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Kategori</th>
                <th style="width: 35%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $noExpense = 1; @endphp
            @forelse($expensesList as $exp)
                <tr>
                    <td class="text-center">{{ $noExpense++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($exp->date)->format('d/m/Y') }}</td>
                    <td><span style="text-transform: capitalize;">{{ $exp->category }}</span></td>
                    <td>{{ $exp->description }}</td>
                    <td class="text-right text-danger">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-muted">Tidak ada data pengeluaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SIGNATURE BLOCK -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Semarang, {{ date('d F Y') }}</p>
            <p><strong>Manager Finance MindFit</strong></p>
            <div class="signature-space"></div>
            <hr style="width: 180px; margin: 0 auto 5px auto; border: none; border-top: 1px solid #333;">
            <p>MindFit Administrator</p>
        </div>
    </div>

    <div class="footer-note">
        Laporan ini dihasilkan secara otomatis oleh Sistem Mindfit Coaching Platform.
    </div>

</body>
</html>
