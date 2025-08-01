<x-utama.layout.main title="Kolektor | Rekap Data Infaq">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Report Data Infaq</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="page mb-3">
                                <h6>
                                    <li><strong>Sortir Data</strong></li>
                                </h6>
                                <hr>
                                <div class="row g-3 align-items-end justify-content-between">
                                    {{-- Filter Wilayah --}}
                                    <div class="col-lg-9">
                                        <form method="GET" action="{{ route('kolektor.setor-infaq') }}"
                                            class="row gx-2 gy-2 align-items-end" id="filterForm">
                                            <input type="hidden" name="page" value="1">

                                            <div class="col-md-auto">
                                                <label for="entries" class="form-label">Tampilkan:</label>
                                                <select name="entries" id="entries" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="10"
                                                        {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                                    </option>
                                                    <option value="25"
                                                        {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                                                    <option value="50"
                                                        {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100"
                                                        {{ request('entries') == 100 ? 'selected' : '' }}>100
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-auto">
                                                <label for="kecamatan" class="form-label">Kecamatan:</label>
                                                <select name="kecamatan" id="kecamatan"
                                                    class="form-select form-select-sm">
                                                    {{-- onchange="this.form.submit() --}}
                                                    <option value="">-- Pilih Kecamatan --</option>
                                                    @foreach ($kecamatans as $kec)
                                                        <option value="{{ $kec->id }}"
                                                            {{ $showAll ? '' : request('kecamatan') == ($kec->id ? 'selected' : '') }}>
                                                            {{ $kec->nama_kecamatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-auto">
                                                <label for="kelurahan" class="form-label">Kelurahan:</label>
                                                <select name="kelurahan" id="kelurahan"
                                                    class="form-select form-select-sm">
                                                    <option value="">-- Pilih Kelurahan --</option>
                                                    {{-- Diisi lewat JS --}}
                                                </select>
                                            </div>

                                            <div class="col-md-auto d-flex gap-2 align-items-end">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="tooltip" title="Filter"><i
                                                        class="bx bxs-filter-alt"></i></button>
                                                <a href="{{ route('kolektor.setor-infaq') }}"
                                                    class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                    title="Reset"><i class='bx bx-reset'></i></a>
                                                <button type="submit" name="show_all"
                                                    value="{{ $showAll ? '0' : '1' }}" class="btn btn-sm btn-info"
                                                    data-bs-toggle="tooltip" title="Semua Data">
                                                    <i class="fas fa-file-lines"></i>
                                                    {{ $showAll ? 'Hari Ini' : 'Semua' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Pencarian --}}
                                    <div class="col-lg-3">
                                        <form method="GET" action="{{ route('kolektor.setor-infaq') }}"
                                            class="d-flex align-items-end gap-2">
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm" placeholder="Cari...">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-toggle="tooltip" title="Cari">
                                                <i class='bx bx-search-alt-2'></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Filter Periode dan Export --}}
                                    <div class="col-12 mt-3">
                                        <h6>
                                            <li><strong>Export Data</strong></li>
                                        </h6>
                                        <hr>
                                        <form method="GET" action="{{ route('kolektor.setor-infaq') }}"
                                            class="row gx-2 gy-2 align-items-end" id="periodFilterForm">
                                            {{-- Select Periode --}}
                                            <div class="col-md-auto">
                                                <label class="form-label">Periode:</label>
                                                <select name="periode" id="periode"
                                                    class="form-select form-select-sm">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="custom"
                                                        {{ $showAll ? '' : ($periode == 'custom' ? 'selected' : '') }}>
                                                        Periode
                                                        Tanggal</option>
                                                    <option value="monthly"
                                                        {{ $showAll ? '' : ($periode == 'monthly' ? 'selected' : '') }}>
                                                        Per Bulan
                                                    </option>
                                                    <option value="quarterly"
                                                        {{ $showAll ? '' : ($periode == 'quarterly' ? 'selected' : '') }}>
                                                        Per 3 Bulan
                                                    </option>
                                                    <option value="semiannual"
                                                        {{ $showAll ? '' : ($periode == 'semiannual' ? 'selected' : '') }}>
                                                        Per 6
                                                        Bulan</option>
                                                    <option value="yearly"
                                                        {{ $showAll ? '' : ($periode == 'yearly' ? 'selected' : '') }}>
                                                        Per Tahun
                                                    </option>
                                                </select>
                                            </div>

                                            {{-- Tanggal Awal & Akhir --}}
                                            <div class="col-md-auto" id="custom-date" style="display: none;">
                                                <label class="form-label">Tanggal:</label>
                                                <div class="d-flex flex-row gap-2">
                                                    <input type="date" name="start_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ $startDate }}" placeholder="Awal">
                                                    <input type="date" name="end_date"
                                                        class="form-control form-control-sm"
                                                        value="{{ $endDate }}" placeholder="Akhir">
                                                </div>
                                            </div>

                                            {{-- Filter Bulan --}}
                                            <div class="col-md-auto" id="monthly" style="display: none;">
                                                <label class="form-label">Bulan & Tahun:</label>
                                                <div class="d-flex flex-row gap-2">
                                                    <select name="month" class="form-select form-select-sm">
                                                        <option value="">-- Bulan --</option>
                                                        @foreach (range(1, 12) as $m)
                                                            <option value="{{ $m }}"
                                                                {{ ($showAll ? '' : $month == $m) ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select name="year" class="form-select form-select-sm">
                                                        <option value="">-- Tahun --</option>
                                                        @foreach (range(Carbon\Carbon::today()->year, Carbon\Carbon::today()->year - 5) as $y)
                                                            <option value="{{ $y }}"
                                                                {{ $showAll ? '' : ($year == $y ? 'selected' : '') }}>
                                                                {{ $y }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Tahun untuk Quarterly, Semiannual, Yearly --}}
                                            <div class="col-md-auto" id="yearly" style="display: none;">
                                                <label class="form-label">Tahun:</label>
                                                <select name="year" class="form-select form-select-sm">
                                                    <option value="">-- Pilih Tahun --</option>
                                                    @foreach (range(Carbon\Carbon::today()->year, Carbon\Carbon::today()->year - 5) as $y)
                                                        <option value="{{ $y }}"
                                                            {{ $showAll ? '' : ($year == $y ? 'selected' : '') }}>
                                                            {{ $y }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Tombol Filter Periode --}}
                                            <div class="col-md-auto">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    id="filterPeriodBtn" data-bs-toggle="tooltip"
                                                    title="Terapkan Filter Periode">
                                                    <i class="bx bxs-filter-alt"></i> Filter
                                                </button>
                                                <a href="{{ route('kolektor.setor-infaq') }}"
                                                    class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                    title="Reset"><i class='bx bx-reset'></i> Reset
                                                </a>
                                            </div>

                                            {{-- Tombol Ekspor --}}
                                            <div class="col-md-auto d-flex gap-2 align-items-end">
                                                <button type="button"
                                                    class="btn btn-outline-success btn-sm export-excel-btn"
                                                    data-bs-toggle="tooltip" title="Export Excel"
                                                    onclick="exportExcel()">
                                                    <i class="fa-solid fa-file-excel"></i> Download Excel
                                                </button>
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm export-btn"
                                                    data-bs-toggle="tooltip" title="Export Pdf"
                                                    onclick="exportPdf()">
                                                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if ($hasil->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    <?php
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                        }
                                    }
                                    ?>
                                    @foreach ($hasil as $index => $item)
                                        @if ($item->status == 'Kirim')
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="card shadow-sm border-1 h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title mb-3 text-primary">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="no">
                                                                    #{{ $hasil->firstItem() + $index }} -
                                                                    <i class="fa-solid fa-money-check-dollar"></i>
                                                                    {{ $item->namaBank ?? '-' }}
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-circle-check me-1"></i>
                                                                        Terkirim
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </h6>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 85px;"><strong>Tanggal</strong>
                                                            </div>
                                                            <span class="me-1">:</span>
                                                            <div>
                                                                {{ \Carbon\Carbon::parse($item->created_at ?? '-')->format('d-m-Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 85px;"><strong>Rekening</strong>
                                                            </div>
                                                            <span class="me-1">:</span>
                                                            <div>
                                                                {{ $item->Rekening ?? '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 85px;"><strong>Jumlah</strong></div>
                                                            <span class="me-1">:</span>
                                                            <div>{{ Rupiah($item->jumlah) ?? '-' }}</div>
                                                        </div>
                                                        <p class="mb-2"><strong>Bukti Transfer:</strong><br>
                                                            @if ($item->bukti_foto)
                                                                @php
                                                                    $fileExtension = pathinfo(
                                                                        Storage::path($item->bukti_foto),
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                    $isImage = in_array(strtolower($fileExtension), [
                                                                        'jpg',
                                                                        'jpeg',
                                                                        'png',
                                                                    ]);
                                                                @endphp
                                                                <a href="#"
                                                                    class="btn btn-outline-primary btn-sm mt-1 view-media"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mediaModal"
                                                                    data-src="{{ Storage::url($item->bukti_foto) }}"
                                                                    data-type="{{ $isImage ? 'image' : 'file' }}">
                                                                    <i
                                                                        class="fas {{ $isImage ? 'fa-image' : 'fa-file' }}"></i>
                                                                    Lihat Bukti
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Tidak ada bukti</span>
                                                            @endif
                                                        </p>
                                                        <div class="text-end" style="font-size: 10px">
                                                            <i class="fa-solid fa-lock"></i>
                                                            <i class="fab fa-whatsapp"
                                                                style="color: #25D366; font-size: 12px;"></i>
                                                            {{ $noHp ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    <!-- Jumlah total -->
                                    <div class="col-12">
                                        <div class="card mt-2 border-0 bg-light text-center">
                                            <div
                                                class="card-body d-flex flex-column justify-content-start align-items-start">
                                                <i class="fa-solid fa-sack-dollar fa-2x mb-2 text-success"></i>
                                                Total Nominal :
                                                <span class="fs-5 fw-bold">
                                                    {{ Rupiah($hasil->sum('nominal')) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            </div>

                            <!-- Modal Media -->
                            <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog"
                                aria-labelledby="mediaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pratinjau Bukti Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body text-center" id="mediaContent"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                {{ $hasil->appends([
                                        'entries' => $entries,
                                        'show_all' => $showAll,
                                        'periode' => $periode,
                                        'start_date' => $startDate,
                                        'end_date' => $endDate,
                                        'month' => $month,
                                        'year' => $year,
                                    ])->links() }}
                            </div>

                            {{-- <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%; white-space: nowrap">
                                    <thead class="table-primary text-center align-middle">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Tanggal Setor</th>
                                            <th rowspan="2">Nama Bank</th>
                                            <th rowspan="2">Rekening</th>
                                            <th rowspan="2">Jumlah</th>
                                            <th rowspan="2">Bukti Foto Transfer</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!function_exists('Rupiah')) {
                                            function Rupiah($angka)
                                            {
                                                return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                            }
                                        }
                                        ?>
                                        @if ($hasil->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($hasil as $index => $item)
                                                @if ($item->status == 'Kirim')
                                                    <tr>
                                                        <td>{{ $hasil->firstItem() + $index }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at ?? '-')->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $item->namaBank ?? '-' }}</td>
                                                        <td>{{ $item->Rekening ?? '-' }}</td>
                                                        <td>{{ Rupiah($item->jumlah) }}</td>
                                                        <td>
                                                            @if ($item->bukti_foto)
                                                                @php
                                                                    $fileExtension = pathinfo(
                                                                        Storage::path($item->bukti_foto),
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                    $isImage = in_array(strtolower($fileExtension), [
                                                                        'jpg',
                                                                        'jpeg',
                                                                        'png',
                                                                    ]);
                                                                @endphp

                                                                <button type="button" class="btn btn-link view-media"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#mediaModal"
                                                                    data-src="{{ Storage::url($item->bukti_foto) }}"
                                                                    data-type="{{ $isImage ? 'image' : 'unknown' }}">
                                                                    @if ($isImage)
                                                                        <i class="fas fa-image"></i> Lihat Gambar
                                                                    @else
                                                                        <i class="fas fa-file"></i> Lihat File
                                                                    @endif
                                                                </button>

                                                                <div class="modal fade" id="mediaModal"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="mediaModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="mediaModalLabel">
                                                                                    Pratinjau Media</h5>
                                                                                <button type="button"
                                                                                    class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true"></span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div id="mediaContent">
                                                                                    <img src="{{ Storage::url($item->bukti_foto) }}"
                                                                                        width="100%" height="100%"
                                                                                        alt="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada foto</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item->status == 'Kirim')
                                                                <button class="btn btn-success">
                                                                    <i class="fas fa-circle-check"></i> Terkirim
                                                                </button>
                                                            @else
                                                                <button class="btn btn-warning">
                                                                    <i class="fa-solid fa-hourglass-start"></i>
                                                                    Pending
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="5" class="text-center fw-bold">Jumlah Total
                                                </td>
                                                <td colspan="2" class="fw-bold">
                                                    {{ Rupiah($hasil->sum('nominal')) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end mt-2">
                                    {{ $hasil->appends(['entries' => $entries, 'show_all' => $showAll, 'periode' => $periode, 'start_date' => $startDate, 'end_date' => $endDate, 'month' => $month, 'year' => $year])->links() }}
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.view-media').forEach(button => {
                button.addEventListener('click', function() {
                    const src = this.getAttribute('data-src');
                    const type = this.getAttribute('data-type');
                    const content = type === 'image' ?
                        `<img src="${src}" class="img-fluid" alt="Bukti Transfer">` :
                        `<a href="${src}" target="_blank">Lihat File</a>`;

                    document.getElementById('mediaContent').innerHTML = content;
                });
            });

            let pollingTimeout; // Variabel untuk menyimpan ID timeout polling

            function exportExcel() {
                const button = document.querySelector('.export-excel-btn');
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

                const form = document.querySelector('#periodFilterForm');
                if (!form) {
                    console.error('Form #periodFilterForm tidak ditemukan!');
                    button.disabled = false;
                    button.innerHTML = '<i class="fa-solid fa-file-excel"></i> Ekspor Excel';
                    return;
                }

                const formData = new FormData(form);
                const urlParams = new URLSearchParams(window.location.search);
                formData.append('search', urlParams.get('search') || '');
                formData.append('kecamatan', urlParams.get('kecamatan') || '');
                formData.append('kelurahan', urlParams.get('kelurahan') || '');
                formData.append('show_all', urlParams.get('show_all') || 'false');

                fetch("{{ route('kolektor.report.excel') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Gagal memproses laporan.');
                            });
                        }
                        return response.blob().then(blob => ({
                            blob,
                            headers: response.headers
                        }));
                    })
                    .then(({
                        blob,
                        headers
                    }) => {
                        const filename = headers.get('Content-Disposition')?.match(/filename="(.+)"/)?.[1] ||
                            'Laporan_Excel.xlsx';
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);

                        // Reset tombol
                        button.disabled = false;
                        button.innerHTML = '<i class="fa-solid fa-file-excel"></i> Ekspor Excel';
                    })
            }

            function exportPdf() {
                const button = document.querySelector('.export-btn');
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

                const form = document.querySelector('#periodFilterForm');
                if (!form) {
                    console.error('Form #periodFilterForm tidak ditemukan!');
                    button.disabled = false;
                    button.innerHTML = '<i class="fa-solid fa-file-pdf"></i> Ekspor PDF';
                    return;
                }

                const formData = new FormData(form);
                const urlParams = new URLSearchParams(window.location.search);
                formData.append('search', urlParams.get('search') || '');
                formData.append('kecamatan', urlParams.get('kecamatan') || '');
                formData.append('kelurahan', urlParams.get('kelurahan') || '');
                formData.append('show_all', urlParams.get('show_all') || 'false');

                fetch("{{ route('kolektor.report.pdf') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Gagal memproses laporan PDF.');
                            });
                        }
                        return response.blob().then(blob => ({
                            blob,
                            headers: response.headers
                        }));
                    })
                    .then(({
                        blob,
                        headers
                    }) => {
                        const filename = headers.get('Content-Disposition')?.match(/filename="(.+)"/)?.[1] || 'Laporan.pdf';
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);

                        // Tampilkan notifikasi sukses
                        // Swal.fire({
                        //     title: 'Sukses',
                        //     text: 'File PDF berhasil diunduh!',
                        //     icon: 'success',
                        //     timer: 2000,
                        //     showConfirmButton: false
                        // });

                        // Reset tombol
                        button.disabled = false;
                        button.innerHTML = '<i class="fa-solid fa-file-pdf"></i> Ekspor PDF';
                    })
                // .catch(error => {
                //     console.error('Error:', error.message);
                //     Swal.fire({
                //         title: 'Error',
                //         text: error.message,
                //         icon: 'error',
                //         timer: 2000,
                //         showConfirmButton: false
                //     });
                //     button.disabled = false;
                //     button.innerHTML = '<i class="fa-solid fa-file-pdf"></i> Ekspor PDF';
                // });
            }

            function checkFileAvailability(filename, button, type) {
                if (!filename) {
                    console.error('Filename is undefined or null');
                    Swal.fire({
                        title: 'Error',
                        text: 'Nama file tidak valid.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    button.disabled = false;
                    button.innerHTML = type === 'excel' ?
                        '<i class="fa-solid fa-file-excel"></i> Download Excel' :
                        '<i class="fa-solid fa-file-pdf"></i> Download PDF';
                    clearTimeout(pollingTimeout);
                    return;
                }

                const endpoint = type === 'excel' ?
                    "{{ route('kolektor.report.excel', ['filename' => ':filename']) }}".replace(':filename',
                        encodeURIComponent(filename)) :
                    "{{ route('kolektor.report.pdf', ['filename' => ':filename']) }}".replace(':filename', encodeURIComponent(
                        filename));

                fetch(endpoint, {
                        method: 'HEAD'
                    })
                    .then(response => {
                        if (response.ok) {
                            // File tersedia, mulai unduhan
                            const link = document.createElement('a');
                            link.href = endpoint;
                            link.setAttribute('download', filename);
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                title: 'Sukses',
                                text: `File ${filename} berhasil diunduh!`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Hentikan polling dan reset tombol
                            clearTimeout(pollingTimeout);
                            button.disabled = false;
                            button.innerHTML = type === 'excel' ?
                                '<i class="fa-solid fa-file-excel"></i> Ekspor Excel' :
                                '<i class="fa-solid fa-file-pdf"></i> Ekspor PDF';
                        } else {
                            console.log('File not ready, retrying in 5 seconds');
                            pollingTimeout = setTimeout(() => checkFileAvailability(filename, button, type), 5000);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking file:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal memeriksa ketersediaan file.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        clearTimeout(pollingTimeout);
                        button.disabled = false;
                        button.innerHTML = type === 'excel' ?
                            '<i class="fa-solid fa-file-excel"></i> Ekspor Excel' :
                            '<i class="fa-solid fa-file-pdf"></i> Ekspor PDF';
                    });
            }

            $(document).ready(function() {
                // Tampilkan/sembunyikan input periode berdasarkan pilihan
                $('#periode').on('change', function() {
                    var periode = $(this).val();
                    $('#custom-date').hide();
                    $('#monthly').hide();
                    $('#yearly').hide();
                    $('#custom-date input, #monthly select, #yearly select').prop('required', false);
                    $('#filterPeriodBtn').prop('disabled', true);

                    if (periode === 'custom') {
                        $('#custom-date').show();
                        $('#custom-date input').prop('required', true);
                    } else if (periode === 'monthly') {
                        $('#monthly').show();
                        $('#monthly select').prop('required', true);
                    } else if (periode === 'quarterly' || periode === 'semiannual' || periode === 'yearly') {
                        $('#yearly').show();
                        $('#yearly select').prop('required', true);
                    }
                });

                // Validasi input periode sebelum submit
                function validatePeriodInputs() {
                    var periode = $('#periode').val();
                    var isValid = false;

                    if (periode === 'custom') {
                        var startDate = $('#custom-date input[name="start_date"]').val();
                        var endDate = $('#custom-date input[name="end_date"]').val();
                        isValid = startDate && endDate;
                    } else if (periode === 'monthly') {
                        var month = $('#monthly select[name="month"]').val();
                        var year = $('#monthly select[name="year"]').val();
                        isValid = month && year;
                    } else if (periode === 'quarterly' || periode === 'semiannual' || periode === 'yearly') {
                        var year = $('#yearly select[name="year"]').val();
                        isValid = year;
                    } else {
                        isValid = true; // Jika tidak ada periode dipilih, izinkan submit
                    }

                    $('#filterPeriodBtn').prop('disabled', !isValid);
                }

                // Panggil validasi saat input berubah
                $('#periode, #custom-date input, #monthly select, #yearly select').on('change', validatePeriodInputs);

                // Validasi saat submit form
                $('#periodFilterForm').on('submit', function(e) {
                    var periode = $('#periode').val();
                    if (periode === 'monthly' && (!$('#monthly select[name="month"]').val() || !$(
                            '#monthly select[name="year"]').val())) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Error',
                            text: 'Pilih bulan dan tahun terlebih dahulu.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (periode === 'custom' && (!$('#custom-date input[name="start_date"]').val() || !$(
                            '#custom-date input[name="end_date"]').val())) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Error',
                            text: 'Pilih tanggal awal dan akhir terlebih dahulu.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else if (['quarterly', 'semiannual', 'yearly'].includes(periode) && !$(
                            '#yearly select[name="year"]').val()) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Error',
                            text: 'Pilih tahun terlebih dahulu.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });

                // Trigger change saat halaman dimuat
                $('#periode').trigger('change');
                validatePeriodInputs();

                // AJAX untuk kelurahan
                $('#kecamatan').on('change', function() {
                    var kecamatanId = $(this).val();
                    var kelurahanSelect = $('#kelurahan');
                    kelurahanSelect.html('<option value="">-- Pilih Kelurahan --</option>');
                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('kolektor.export.getKelurahan') }}',
                            type: 'GET',
                            data: {
                                id_kecamatan: kecamatanId
                            },
                            success: function(data) {
                                $.each(data, function(index, kelurahan) {
                                    kelurahanSelect.append(
                                        '<option value="' + kelurahan.id + '">' +
                                        kelurahan.nama_kelurahan + '</option>'
                                    );
                                });
                                var selectedKelurahan = '{{ request('kelurahan') }}';
                                if (selectedKelurahan) {
                                    kelurahanSelect.val(selectedKelurahan);
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Gagal memuat data kelurahan.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });

                if ($('#kecamatan').val()) {
                    $('#kecamatan').trigger('change');
                }

                // Aktifkan tombol ekspor saat halaman dimuat jika data sudah difilter
                @if ($hasil->isNotEmpty())
                    $('.export-btn').prop('disabled', false);
                    $('.export-excel-btn').prop('disabled', false);
                @endif
            });
        </script>
    @endpush
</x-utama.layout.main>
