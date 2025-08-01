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

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 0;
            border-bottom: 2px solid #1a5d1a;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
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

        /* Title */
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

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9pt;
        }

        th,
        td {
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

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Footer */
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

        /* Utility */
        .text-center {
            text-align: center;
        }

        .rupiah {
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('admin/img/LAZISNU.png') }}" alt="Lazisnu Logo">
        <div class="header-text">
            <h1>Lembaga Amil Zakat Infaq dan Shodaqoh Nahdlatul Ulama’ (LAZISNU)</h1>
            @php
                use Illuminate\Support\Str;

                $first = $hasilinfaq->first();
                $kecamatan = Str::title($first->plotting?->kecamatan?->nama_kecamatan ?? '-');
                $kelurahan = Str::title($first->plotting?->kelurahan?->nama_kelurahan ?? '-');
            @endphp

            <p>
                {{ $kecamatan }}, {{ $kelurahan }}, Kabupaten Kudus
            </p>


            <p><strong>INUK: Infaq NU Kudus</strong></p>
        </div>
    </div>

    <!-- Report Title -->
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

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Tanggal Kirim</th>
                <th colspan="3">Wilayah Infaq</th>
                <th rowspan="2">Nominal Infaq</th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Nama Bank</th>
                <th rowspan="2">Rekening</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>RT/RW</th>
            </tr>
        </thead>
        <tbody>
            @php
                if (!function_exists('rupiah')) {
                    function rupiah($angka)
                    {
                        return $angka !== null ? 'Rp ' . number_format((float) $angka, 0, ',', '.') : '-';
                    }
                }
            @endphp
            @foreach ($hasilinfaq as $index => $item)
                <tr>
                    <td class="text-center" class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->user->username ?? '-' }}</td>
                    <td class="text-center">
                        {{ $item->tglSetor ? \Carbon\Carbon::parse($item->tglSetor)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">{{ Str::title($item->plotting->kecamatan->first()->nama_kecamatan ?? '-') }}
                    </td>
                    <td class="text-center">
                        {{ Str::title($item->plotting->kelurahan->nama_kelurahan ?? '-') }}</td>
                    <td class="text-center">
                        {{ $item->Rt ?? '-' }} - {{ $item->Rw ?? '-' }}
                    </td>
                    <td class="rupiah">{{ rupiah($item->nominal) ?? '-' }}</td>
                    <td class="rupiah">{{ rupiah($item->jumlah) ?? '-' }}</td>
                    <td class="text-center">{{ $item->namaBank ?? '-' }}</td>
                    <td class="text-center">{{ $item->Rekening ?? '-' }}</td>
                    <td class="text-center">-</td>
                </tr>
            @endforeach
            @if ($hasilinfaq->isEmpty())
                <tr>
                    <td colspan="12" class="text-center">Tidak ada data tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} | Halaman <span
                class="page-number"></span></p>
    </div>
</body>

</html>
