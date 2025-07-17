<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Setoran Infaq</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 0;
            border-bottom: 2px solid #1a5d1a;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
            margin-right: 15px;
        }

        .header-text {
            text-align: left;
        }

        .header-text h1 {
            font-size: 14pt;
            font-weight: bold;
            color: #1a5d1a;
            margin: 0;
            text-transform: uppercase;
        }

        .header-text p {
            font-size: 9pt;
            margin: 2px 0;
            color: #555;
        }

        .report-title {
            text-align: center;
            margin: 10px 0;
        }

        .report-title h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 5px 0;
            color: #333;
        }

        .report-title p {
            font-size: 10pt;
            margin: 2px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9pt;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #1a5d1a;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .rupiah {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('admin/img/LAZISNU.png') }}" alt="Lazisnu Logo">
        <div class="header-text">
            <h1>Lembaga Amil Zakat Infaq dan Shodaqoh Nahdlatul Ulama’ (LAZISNU)</h1>
            <p>Desa Singocandi, Kecamatan Kota Kudus, Kabupaten Kudus</p>
            <p>INUK: Infaq NU Kudus</p>
        </div>
    </div>

    <div class="report-title">
        <h2>Laporan Hasil Setoran Infaq</h2>
        @if ($filterOption === 'full_date' && $tanggal)
            <p>Periode: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
        @elseif ($filterOption === 'month_year' && $month && $tahun)
            <p>Periode: {{ $months[$month] }} {{ $tahun }}</p>
        @else
            <p>Periode: Semua Data</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Petugas</th>
                <th rowspan="2">Tanggal Kirim</th>
                <th rowspan="2">Jenis Infaq</th>
                <th colspan="3">Wilayah Infaq</th>
                <th colspan="4">Nominal Infaq</th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>RT/RW</th>
                <th>Minggu I</th>
                <th>Minggu II</th>
                <th>Minggu III</th>
                <th>Minggu IV</th>
            </tr>
        </thead>
        <tbody>
            @php
                if (!function_exists('rupiah')) {
                    function rupiah($angka)
                    {
                        return $angka !== null ? 'Rp ' . number_format((float)$angka, 0, ',', '.') : '-';
                    }
                }
            @endphp
            @foreach ($hasilinfaq as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->petugas->nama_petugas ?? '-' }}</td>
                    <td>{{ $item->tgl_kirim ? \Carbon\Carbon::parse($item->tgl_kirim)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->setor->jenis_infaq ?? '-' }}</td>
                    <td>{{ $item->setor->kecamatan->nama_kecamatan ?? '-' }}</td>
                    <td>{{ $item->setor->kelurahan->nama_kelurahan ?? '-' }}</td>
                    <td>
                        @if ($item->setor->petugas && $item->setor->petugas->wilayahTugas->isNotEmpty())
                            {{ $item->setor->petugas->wilayahTugas
                                ->where('id_kecamatan', $item->setor->id_kecamatan)
                                ->where('id_kelurahan', $item->setor->id_kelurahan)
                                ->map(function ($wilayah) {
                                    return ($wilayah->RT ?? '-') . '/' . ($wilayah->RW ?? '-');
                                })->implode(', ') ?: '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="rupiah">{{ rupiah($item->setor->minggu1) }}</td>
                    <td class="rupiah">{{ rupiah($item->setor->minggu2) }}</td>
                    <td class="rupiah">{{ rupiah($item->setor->minggu3) }}</td>
                    <td class="rupiah">{{ rupiah($item->setor->minggu4) }}</td>
                    <td class="rupiah">{{ rupiah($item->setor->jumlah) }}</td>
                    <td>{{ $item->setor->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
            @if ($hasilinfaq->isEmpty())
                <tr>
                    <td colspan="13" class="text-center">Tidak ada data tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} | Halaman <span class="page-number"></span></p>
    </div>
</body>
</html>