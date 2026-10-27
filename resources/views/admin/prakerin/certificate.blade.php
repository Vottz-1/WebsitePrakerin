<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Prakerin - {{ $student->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #fff;
        }
        .certificate {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
            border: 12px solid #1e3a8a;
            padding: 40px 60px;
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #d97706;
            pointer-events: none;
        }
        .header {
            text-align: center;
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }
        .header h1 {
            font-size: 42px;
            letter-spacing: 8px;
            text-transform: uppercase;
            color: #1e3a8a;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .header h2 {
            font-size: 18px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 5px;
        }
        .header .sub {
            font-size: 14px;
            color: #475569;
            margin-top: 8px;
        }
        .body {
            text-align: center;
            margin-top: 40px;
            position: relative;
            z-index: 1;
            line-height: 1.8;
        }
        .body .text {
            font-size: 16px;
            color: #334155;
            margin-bottom: 15px;
        }
        .student-name {
            font-size: 36px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2px solid #1e3a8a;
            display: inline-block;
            padding: 10px 60px;
            margin: 15px 0;
            text-transform: uppercase;
        }
        .details {
            font-size: 15px;
            color: #334155;
            margin: 10px 0;
        }
        .scores {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 30px 0;
        }
        .score-box {
            text-align: center;
            padding: 15px 25px;
            background: rgba(30, 58, 138, 0.05);
            border: 1px solid rgba(30, 58, 138, 0.3);
            border-radius: 8px;
        }
        .score-box .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #64748b;
        }
        .score-box .value {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 5px;
        }
        .footer {
            position: absolute;
            bottom: 60px;
            left: 60px;
            right: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            z-index: 1;
        }
        .signature {
            text-align: center;
            width: 250px;
        }
        .signature .line {
            border-top: 1px solid #0f172a;
            margin-top: 60px;
            padding-top: 8px;
            font-size: 14px;
            color: #334155;
        }
        .signature .name {
            font-weight: bold;
            font-size: 15px;
            color: #0f172a;
        }
        .date {
            text-align: center;
            font-size: 14px;
            color: #334155;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            z-index: 1000;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Cetak Sertifikat</button>

    <div class="certificate">
        <div class="header">
            <h2>PEMERINTAH / SEKOLAH MENENGAH KEJURUAN</h2>
            <h1>SERTIFIKAT</h1>
            <div class="sub">Nomor : /SK/PRAKERIN/{{ date('Y') }}/{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="body">
            <div class="text">Diberikan kepada :</div>
            <div class="student-name">{{ $student->name }}</div>
            <div class="details">
                NISN : {{ $student->prakerinProfile->nisn ?? '-' }} | 
                Sekolah : {{ $student->prakerinProfile->school ?? '-' }} | 
                Jurusan : {{ $student->prakerinProfile->department ?? '-' }}
            </div>
            <div class="text" style="margin-top: 25px;">
                Telah melaksanakan <strong>PRAKTIK KERJA INDUSTRI (PRAKERIN)</strong><br>
                di tempat pelaksanaan Prakerin dengan penuh tanggung jawab, disiplin dan prestasi yang baik<br>
                selama periode <strong>{{ \Carbon\Carbon::parse($student->prakerinProfile->start_date)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($student->prakerinProfile->end_date)->translatedFormat('d F Y') }}</strong>
            </div>

            <div class="scores">
                <div class="score-box">
                    <div class="label">Nilai Keterampilan</div>
                    <div class="value">{{ $techAvg }}</div>
                </div>
                <div class="score-box">
                    <div class="label">Nilai Sikap</div>
                    <div class="value">{{ $attitudeAvg }}</div>
                </div>
                <div class="score-box">
                    <div class="label">Kedisiplinan</div>
                    <div class="value">{{ $discipline }}</div>
                </div>
                <div class="score-box">
                    <div class="label">Nilai Akhir</div>
                    <div class="value">{{ $finalScore }}</div>
                </div>
            </div>

            <div class="text">
                Dengan predikat : <strong>{{ $finalScore >= 90 ? 'SANGAT BAIK' : ($finalScore >= 80 ? 'BAIK' : ($finalScore >= 70 ? 'CUKUP' : 'PERLU BIMBINGAN')) }}</strong>
            </div>
        </div>

        <div class="footer">
            <div class="signature">
                <div class="date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="line">
                    <div class="name">( __________________________ )</div>
                    <div>Kepala Sekolah / Pembimbing</div>
                </div>
            </div>
            <div class="signature">
                <div style="height: 20px;"></div>
                <div class="line">
                    <div class="name">( __________________________ )</div>
                    <div>Pimpinan Perusahaan / Instansi</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print on load
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
