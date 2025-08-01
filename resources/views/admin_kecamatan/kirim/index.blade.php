<x-utama.layout.main title="Admin Kecamatan | Laporan Pengiriman">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Laporan Pengiriman</strong></h5>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <form method="GET" action="{{ route('admin_kecamatan.info-kirim') }}"
                                    class="d-flex flex-wrap align-items-end gap-2 w-100" id="filterForm">
                                    @csrf

                                    <!-- Pilihan jumlah entri -->
                                    <div>
                                        <label class="form-label">Tampilkan:</label>
                                        <select name="entries" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            @foreach ([10, 25, 50, 100] as $entry)
                                                <option value="{{ $entry }}"
                                                    {{ $entries == $entry ? 'selected' : '' }}>{{ $entry }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Option dan Filter Fields dalam satu container -->
                                    <div class="filter-container">
                                        <!-- Filter Option -->
                                        <div class="filter-option">
                                            <label class="form-label">Filter:</label>
                                            <select name="filter_option" id="filterOption"
                                                class="form-select form-select-sm" onchange="toggleFilterFields()">
                                                <option value="all" {{ $filterOption == 'all' ? 'selected' : '' }}>
                                                    Semua Data</option>
                                                <option value="day" {{ $filterOption == 'day' ? 'selected' : '' }}>
                                                    Hari</option>
                                                <option value="month" {{ $filterOption == 'month' ? 'selected' : '' }}>
                                                    Bulan</option>
                                                <option value="year" {{ $filterOption == 'year' ? 'selected' : '' }}>
                                                    Tahun</option>
                                                <option value="week" {{ $filterOption == 'week' ? 'selected' : '' }}>
                                                    Minggu</option>
                                            </select>
                                        </div>

                                        <!-- Filter Fields -->
                                        <div class="filter-fields">
                                            <div id="day-filter" class="{{ $filterOption == 'day' ? 'active' : '' }}">
                                                <div>
                                                    <label class="form-label">Tanggal:</label>
                                                    <input type="date" name="tanggal"
                                                        class="form-control form-control-sm"
                                                        value="{{ $tanggal ? $tanggal->toDateString() : '' }}">
                                                </div>
                                            </div>

                                            <div id="month-filter"
                                                class="{{ $filterOption == 'month' ? 'active' : '' }}">
                                                <div>
                                                    <label class="form-label">Bulan:</label>
                                                    <select name="month" class="form-select form-select-sm">
                                                        <option value="">Pilih Bulan</option>
                                                        @foreach ($months as $key => $name)
                                                            <option value="{{ $key }}"
                                                                {{ $month == $key ? 'selected' : '' }}>
                                                                {{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="form-label">Tahun:</label>
                                                    <select name="tahun" class="form-select form-select-sm">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ $tahun == $year ? 'selected' : '' }}>
                                                                {{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="year-filter"
                                                class="{{ $filterOption == 'year' ? 'active' : '' }}">
                                                <div>
                                                    <label class="form-label">Tahun:</label>
                                                    <select name="tahun" class="form-select form-select-sm">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ $tahun == $year ? 'selected' : '' }}>
                                                                {{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="week-filter"
                                                class="{{ $filterOption == 'week' ? 'active' : '' }}">
                                                <div>
                                                    <label class="form-label">Minggu Ke-:</label>
                                                    <select name="week" class="form-select form-select-sm">
                                                        <option value="">Pilih Minggu</option>
                                                        @foreach ($weeks as $w)
                                                            <option value="{{ $w }}"
                                                                {{ $week == $w ? 'selected' : '' }}>
                                                                {{ $w }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="form-label">Tahun:</label>
                                                    <select name="tahun" class="form-select form-select-sm">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ $tahun == $year ? 'selected' : '' }}>
                                                                {{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" id="filterBtn" class="btn btn-sm btn-primary" disabled
                                            data-bs-toggle="tooltip" title="Filter Data">
                                            <i class="fa-solid fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('admin_kecamatan.info-kirim') }}"
                                            class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                            title="Reset Filter">
                                            <i class="fa-solid fa-arrow-rotate-right"></i> Reset
                                        </a>
                                        <a href="{{ route('admin_kecamatan.info-kirim', ['filter_option' => 'all']) }}"
                                            class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                            title="Tampilkan Semua Data">
                                            <i class="fa-solid fa-file-lines"></i> Semua
                                        </a>
                                    </div>

                                    <!-- Pencarian -->
                                    <div class="ms-auto search-container d-flex align-items-end gap-2">
                                        <div>
                                            <label class="form-label">Cari Nama File:</label>
                                            <input type="text" name="search" id="searchInput"
                                                class="form-control form-control-sm" style="width: 200px;"
                                                value="{{ $search ?? '' }}" placeholder="........">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                            title="<i class='bx bxs-pencil'></i> <span>Cari Data</span>">
                                            <i class="fa-solid fa-search"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Pesan jika data kosong -->
                            {{-- <div class="mt-3">
                                @if ($laporan->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fa fa-circle-info"></i> Tidak ada laporan ditemukan untuk filter yang
                                        dipilih.
                                        @if ($filterOption != 'all')
                                            <a
                                                href="{{ route('admin_kecamatan.info-kirim', ['filter_option' => 'all']) }}">
                                                <button type="button" class="btn btn-sm btn-warning">
                                                    Tampilkan semua data.
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div> --}}

                            <div class="row">
                                <?php
                                if (!function_exists('Rupiah')) {
                                    function Rupiah($angka)
                                    {
                                        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                    }
                                }
                                ?>
                                @forelse ($laporan as $index => $file)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card shadow rounded-4">
                                            <div class="card-body">
                                                <h5 class="card-title mb-2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="no">
                                                            #{{ $laporan->firstItem() + $index }}
                                                        </div>
                                                        <div class="text-end">
                                                            <span
                                                                class="badge
                                                        @if ($file->status == 'Pending') bg-warning 
                                                        @elseif($file->status == 'Terkirim') bg-success 
                                                        @else bg-secondary @endif">
                                                                <i class="fas fa-circle-check me-1"></i>
                                                                {{ $file->status ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </h5>
                                                <hr>

                                                <div class="mb-1 d-flex">
                                                    <div style="width: 120px;"><strong>Tanggal Kirim</strong>
                                                    </div>
                                                    <span class="me-1">:</span>
                                                    <div>
                                                        {{ $file->tglKirim ? \Carbon\Carbon::parse($file->tglKirim)->format('d-m-Y') : '-' }}
                                                    </div>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <div style="width: 120px;"><strong>Nama Penerima</strong>
                                                    </div>
                                                    <span class="me-1">:</span>
                                                    <div>
                                                        {{ $file->namaPenerima ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <div style="width: 120px;"><strong>Dokumen</strong>
                                                    </div>
                                                    <span class="me-1">:</span>
                                                    <div>
                                                        @php
                                                            $filePaths = json_decode($file->file_kirim, true);
                                                        @endphp

                                                        @if (!empty($filePaths[0]))
                                                            <a href="{{ Storage::url($filePaths[0]) }}"
                                                                class="btn btn-sm btn-primary mt-1" target="_blank">
                                                                <i class="fas fa-eye"></i> Lihat File
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Tidak ada file</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-end mt-2" style="font-size: 10px">
                                                    <i class="fa-solid fa-lock"></i>
                                                    <i class="fab fa-whatsapp"
                                                        style="color: #25D366; font-size: 12px;"></i>
                                                    {{ $file->no_hp ?? '-' }}
                                                </div>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <button type="button" class="btn btn-sm btn-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit{{ $index }}">
                                                        <i class="fas fa-circle-info"></i> Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal Detail --}}
                                    <div class="modal fade" id="edit{{ $index }}" tabindex="-1"
                                        aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Detail Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                {{-- <div class="col-md-6">
                                                                    <table>
                                                                        <tr>
                                                                            <th>Kecamatan</th>
                                                                            <th>:</th>
                                                                            <th>{{ $file->nama_kecamatan }}</th>
                                                                        </tr>
                                                                    </table>
                                                                </div> --}}
                                                                <div class="col-md-12">
                                                                    <textarea name="" id="" readonly cols="10" rows="8" class="form-control mt-w mb-2">
                                                                        {{ $file->pesan ?? '-' }}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="hapus{{ $index }}" tabindex="-1"
                                        aria-labelledby="hapusLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ url('admin-kecamatan/laporan/' . $file->filename) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusLabel{{ $index }}">
                                                            Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin ingin menghapus file
                                                        <strong>{{ $file->filename }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-circle-info"></i> Tidak ada data laporan.
                                        </div>
                                    </div>
                                @endforelse
                                <div class="col-12">
                                    <div class="card mt-2 border-0 bg-light text-center">
                                        <div
                                            class="card-body d-flex flex-column justify-content-start align-items-start">
                                            <i class="fa-solid fa-sack-dollar fa-2x mb-2 text-success"></i>
                                            Total Nominal :
                                            <span class="fs-5 fw-bold">
                                                {{ Rupiah($totalDonasi) ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Paginasi -->
                            <div class="mt-3">
                                {{ $laporan->links() }}
                            </div>


                            {{-- <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Kirim</th>
                                            <th>Nama Penerima</th>
                                            <th>Dokumen File</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($laporan as $index => $file)
                                            <tr>
                                                <td>{{ $laporan->firstItem() + $index }}</td>
                                                <td>{{ $file->tglKirim ? \Carbon\Carbon::parse($file->tglKirim)->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ $file->namaPenerima ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $filePaths = json_decode($file->file_kirim, true);
                                                    @endphp

                                                    @if (!empty($filePaths[0]))
                                                        <a href="{{ Storage::url($filePaths[0]) }}"
                                                            class="btn btn-primary btn-sm" target="_blank">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    @else
                                                        <p>Tidak ada file</p>
                                                    @endif

                                                </td>
                                                <td>{{ $file->status ?? '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapus{{ $index }}">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div class="modal fade" id="hapus{{ $index }}"
                                                        tabindex="-1"
                                                        aria-labelledby="hapusLabel{{ $index }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="{{ url('admin-kecamatan/laporan/' . $file->filename) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="hapusLabel{{ $index }}">
                                                                            Konfirmasi Hapus
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menghapus file
                                                                        <strong>{{ $file->filename }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Hapus</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    Tidak ada data laporan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $laporan->links() }}
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
            /* CSS untuk mengatur filter fields di sebelah kanan dropdown filter */
            .filter-container {
                display: flex;
                align-items: end;
                gap: 10px;
            }

            .filter-option {
                flex: 0 0 auto;
            }

            .filter-fields {
                display: flex;
                gap: 10px;
                align-items: end;
            }

            .filter-fields>div {
                display: none;
                /* Sembunyikan semua filter fields secara default */
            }

            .filter-fields>div.active {
                display: flex;
                gap: 10px;
                align-items: end;
            }

            /* Pastikan kolom pencarian tetap di kanan */
            .search-container {
                flex: 0 0 auto;
            }

            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script>
            // FILTER DATA
            document.addEventListener('DOMContentLoaded', () => {
                const filterOption = document.getElementById('filterOption');
                const filterBtn = document.getElementById('filterBtn');
                const form = document.getElementById('filterForm');
                const dayFilter = document.getElementById('day-filter');
                const monthFilter = document.getElementById('month-filter');
                const yearFilter = document.getElementById('year-filter');
                const weekFilter = document.getElementById('week-filter');

                // Toggle filter fields berdasarkan opsi
                function toggleFilterFields() {
                    const value = filterOption.value;
                    dayFilter.classList.toggle('active', value === 'day');
                    monthFilter.classList.toggle('active', value === 'month');
                    yearFilter.classList.toggle('active', value === 'year');
                    weekFilter.classList.toggle('active', value === 'week');
                    validateFilter();
                }

                // Validasi filter untuk mengaktifkan tombol
                function validateFilter() {
                    const value = filterOption.value;
                    let isValid = false;

                    if (value === 'all') {
                        isValid = true;
                    } else if (value === 'day') {
                        isValid = !!dayFilter.querySelector('input[name="tanggal"]').value;
                    } else if (value === 'month') {
                        isValid = !!monthFilter.querySelector('select[name="month"]').value &&
                            !!monthFilter.querySelector('select[name="tahun"]').value;
                    } else if (value === 'year') {
                        isValid = !!yearFilter.querySelector('select[name="tahun"]').value;
                    } else if (value === 'week') {
                        isValid = !!weekFilter.querySelector('select[name="week"]').value &&
                            !!weekFilter.querySelector('select[name="tahun"]').value;
                    }

                    filterBtn.disabled = !isValid;
                }

                // Event listeners
                filterOption.addEventListener('change', toggleFilterFields);
                form.querySelectorAll('input, select').forEach(input => {
                    input.addEventListener('change', validateFilter);
                    input.addEventListener('input', validateFilter);
                });

                // Inisialisasi
                toggleFilterFields();
            });

            // KIRIM DATA
            $(document).ready(function() {
                // Inisialisasi DataTables
                $('#example').DataTable({
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    }
                });

                $('#laporanTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    }
                });

                // Checkbox select all
                $('.check-all').on('change', function() {
                    $('.user-checkbox').prop('checked', this.checked);
                    updateSelectedButton();
                });

                // Checkbox individual
                $('.user-checkbox').on('change', function() {
                    updateSelectedButton();
                });

                // Update tombol "Kirim ke Terpilih"
                function updateSelectedButton() {
                    const checkedCount = $('.user-checkbox:checked').length;
                    $('#sendSelectedBtn').prop('disabled', checkedCount === 0);
                }

                // Isi daftar pengguna terpilih di modal
                $('#sendWhatsAppModal').on('show.bs.modal', function() {
                    const selectedUsers = $('.user-checkbox:checked').map(function() {
                        const row = $(this).closest('tr');
                        const username = row.find('td:eq(2)').text().trim();
                        return `<li class="list-group-item">${username}</li>`;
                    }).get().join('');

                    const userIds = $('.user-checkbox:checked').map(function() {
                        return this.value;
                    }).get();

                    $('#selectedUsers').html(selectedUsers ||
                        '<li class="list-group-item">Tidak ada pengguna terpilih</li>');
                    $('#userIdsInput').val(userIds);
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
