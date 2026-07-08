<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Perkembangan Fisik - {{ $log->client->name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 40px;
            font-size: 14px;
        }

        /* Kop Surat (Letterhead) */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo-container {
            width: 15%;
            text-align: left;
        }

        .logo-img {
            max-height: 70px;
            width: auto;
        }

        .header-container {
            width: 85%;
            text-align: center;
            padding-right: 40px; /* offset logo */
        }

        .header-container h1 {
            font-size: 26px;
            margin: 0;
            color: #1a2035;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header-container p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }

        /* Laporan Title */
        .report-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-title h2 {
            font-size: 20px;
            margin: 0 0 5px 0;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .report-title p {
            margin: 0;
            color: #555;
            font-style: italic;
        }

        /* Information Grid */
        .info-section {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 6px 12px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 20%;
            color: #555;
        }

        .info-separator {
            width: 2%;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .data-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-align: left;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .data-table td {
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        /* Visual Summary Cards in Print */
        .summary-box {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 35px;
        }

        .summary-box h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            color: #1a2035;
        }

        .summary-grid {
            display: flex;
            justify-content: space-between;
        }

        .summary-item {
            width: 23%;
            text-align: center;
            border-right: 1px solid #eee;
            padding: 5px;
        }

        .summary-item:last-child {
            border-right: none;
        }

        .summary-val {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
            color: #1a2035;
        }

        .summary-lbl {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }

        /* Note section */
        .notes-container {
            margin-bottom: 40px;
        }

        .note-card {
            background-color: #fff;
            border-left: 4px solid #1a2035;
            padding: 12px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .note-card h4 {
            margin: 0 0 5px 0;
            font-size: 13px;
            color: #555;
            text-transform: uppercase;
        }

        .note-card p {
            margin: 0;
            font-style: italic;
        }

        /* Signature block */
        .signature-section {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            width: 250px;
        }

        .signature-box p {
            margin: 0;
        }

        .signature-space {
            height: 75px;
        }

        /* Hide elements in print dialog */
        @media print {
            @page {
                size: A4;
                margin: 20mm 15mm;
            }
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- KOP SURAT (LETTERHEAD) -->
    <div class="kop-surat">
        <div class="logo-container">
            <img src="{{ asset('storage/images/logo.png') }}" class="logo-img" alt="MindFit Logo">
        </div>
        <div class="header-container">
            <h1>MindFit Coaching Platform</h1>
            <p style="font-style: italic; font-weight: bold; color: #1a2035; margin: 4px 0;">Train smart. Live balanced.</p>
            <p>Email: admin@mindfit.co.id | WA: +62 851-9961-5786 | Website: https://mindfit.id</p>
        </div>
    </div>

    <!-- REPORT TITLE -->
    <div class="report-title">
        <h2>Laporan Perkembangan Fisik Klien</h2>
        <p>Log Tanggal: {{ $log->date->format('d F Y') }}</p>
    </div>

    <!-- CLIENT & COACH INFORMATION -->
    <table class="info-section">
        <tr>
            <td class="info-label">Nama Klien</td>
            <td class="info-separator">:</td>
            <td>{{ $log->client->name }}</td>
            <td class="info-label">Pelatih (PT)</td>
            <td class="info-separator">:</td>
            <td>
                @php
                    $pt = $log->client->coaches()->where('specialization', 'fitness')->first();
                @endphp
                {{ $pt ? $pt->name : '-' }}
            </td>
        </tr>
        <tr>
            <td class="info-label">Email Klien</td>
            <td class="info-separator">:</td>
            <td>{{ $log->client->email }}</td>
            <td class="info-label">Ahli Gizi</td>
            <td class="info-separator">:</td>
            <td>
                @php
                    $nutri = $log->client->coaches()->where('specialization', 'nutritionist')->first();
                @endphp
                {{ $nutri ? $nutri->name : '-' }}
            </td>
        </tr>
    </table>

    <!-- PROGRESS LOG TABLE -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Metrik Fisik</th>
                <th>Hasil Pengukuran</th>
                <th>Tipe Log</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Berat Badan</td>
                <td><strong>{{ $log->weight ? $log->weight . ' kg' : '-' }}</strong></td>
                <td>{{ ucfirst($log->type) }}</td>
            </tr>
            <tr>
                <td>Lingkar Pinggang</td>
                <td><strong>{{ $log->waist ? $log->waist . ' cm' : '-' }}</strong></td>
                <td>{{ ucfirst($log->type) }}</td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td><strong>{{ $log->height ? $log->height . ' cm' : '-' }}</strong></td>
                <td>{{ ucfirst($log->type) }}</td>
            </tr>
        </tbody>
    </table>

    @php
        // Find latest stats
        $latestHeightLog = $clientLogs->where('height', '>', 0)->last();
        $latestHeight = $latestHeightLog ? $latestHeightLog->height : null;

        $latestWeightLog = $clientLogs->where('weight', '>', 0)->last();
        $latestWeight = $latestWeightLog ? $latestWeightLog->weight : null;

        $latestWaistLog = $clientLogs->where('waist', '>', 0)->last();
        $latestWaist = $latestWaistLog ? $latestWaistLog->waist : null;

        // Calculate BMI
        $bmi = null;
        $bmiStatus = 'Tidak Terpantau';
        if ($latestHeight && $latestWeight) {
            $bmi = $latestWeight / (($latestHeight / 100) ** 2);
            if ($bmi < 18.5) $bmiStatus = 'Kurang (Underweight)';
            elseif ($bmi < 25) $bmiStatus = 'Normal';
            elseif ($bmi < 30) $bmiStatus = 'Berlebih (Overweight)';
            else $bmiStatus = 'Obesitas';
        }

        // Calculations (earliest vs latest)
        $earliestWeightLog = $clientLogs->where('weight', '>', 0)->first();
        $earliestWeight = $earliestWeightLog ? $earliestWeightLog->weight : null;
        $weightChange = null;
        if ($earliestWeight && $latestWeight) {
            $weightChange = $latestWeight - $earliestWeight;
        }

        $earliestWaistLog = $clientLogs->where('waist', '>', 0)->first();
        $earliestWaist = $earliestWaistLog ? $earliestWaistLog->waist : null;
        $waistChange = null;
        if ($earliestWaist && $latestWaist) {
            $waistChange = $latestWaist - $earliestWaist;
        }
    @endphp

    <!-- VISUAL SUMMARY FOR REPORT -->
    <div class="summary-box">
        <h3>Ringkasan Transformasi Fisik</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-lbl">BMI Saat Ini</div>
                <div class="summary-val">{{ $bmi ? number_format($bmi, 1) : '-' }}</div>
                <div style="font-size: 11px; margin-top: 3px; font-weight: bold;">{{ $bmiStatus }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-lbl">Selisih Berat</div>
                <div class="summary-val">{{ $weightChange !== null ? ($weightChange > 0 ? '+' : '') . number_format($weightChange, 1) . ' kg' : '-' }}</div>
                <div style="font-size: 11px; margin-top: 3px;">{{ $weightChange < 0 ? 'Mengurangi Lemak' : ($weightChange > 0 ? 'Massa Otot Naik' : 'Stabil') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-lbl">Selisih Pinggang</div>
                <div class="summary-val">{{ $waistChange !== null ? ($waistChange > 0 ? '+' : '') . number_format($waistChange, 1) . ' cm' : '-' }}</div>
                <div style="font-size: 11px; margin-top: 3px;">{{ $waistChange < 0 ? 'Menyusut' : ($waistChange > 0 ? 'Melebar' : 'Stabil') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-lbl">Tinggi Badan</div>
                <div class="summary-val">{{ $latestHeight ? number_format($latestHeight, 1) . ' cm' : '-' }}</div>
                <div style="font-size: 11px; margin-top: 3px;">Fisik Terpantau</div>
            </div>
        </div>
    </div>

    <!-- NOTES / FEEDBACK -->
    <div class="notes-container">
        <div class="note-card">
            <h4>Catatan Aktivitas Klien</h4>
            <p>"{{ $log->description ?: 'Tidak ada catatan aktivitas.' }}"</p>
        </div>
        <div class="note-card" style="border-left-color: #2ecc71;">
            <h4>Feedback Pelatih / Coach</h4>
            <p>"{{ $log->coach_note ?: 'Belum ada feedback yang diberikan untuk log ini.' }}"</p>
        </div>
    </div>

    <!-- SIGNATURE BLOCK -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Semarang, {{ date('d F Y') }}</p>
            <p><strong>Pelatih Pendamping MindFit</strong></p>
            <div class="signature-space"></div>
            <hr style="width: 200px; margin: 0 auto 5px auto; border: none; border-top: 1px solid #333;">
            <p>{{ $pt ? $pt->name : ($nutri ? $nutri->name : 'MindFit Coach') }}</p>
        </div>
    </div>

</body>
</html>
