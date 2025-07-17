<x-utama.layout.main title="Admin Kecamatan | Notifikasi Pengiriman">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Notifikasi Pengiriman</strong></h5>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>
                                <li><strong>File Dokumen Pdf</strong></li>
                            </h5>
                            <hr>
                        </div>
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
                            <div class="mt-3">
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
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%; white-space: nowrap">
                                    <thead class="table-primary">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th colspan="2">Nama File</th>
                                            <th rowspan="2">File Pdf</th>
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
                                            <td>File Pdf</td>
                                            <td>File Excel</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $index => $file)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $file['filename'] }}</td>
                                                <td>
                                                    @if ($file['filepath_excel'])
                                                        <a href="{{ asset('storage/' . $file['filepath_excel']) }}"
                                                            target="_blank" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="tooltip" title="Lihat File Excel">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                        <a href="{{ asset('storage/' . $file['filepath_excel']) }}"
                                                            download class="btn btn-success btn-sm"
                                                            data-bs-toggle="tooltip" title="Download File Excel">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $file['filepath_pdf']) }}"
                                                        target="_blank" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="tooltip" title="Lihat File">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    {{-- <a href="{{ asset('storage/' . $file['filepath_pdf']) }}"
                                                        download class="btn btn-success btn-sm"
                                                        data-bs-toggle="tooltip" title="Download File">
                                                        <i class="fas fa-download"></i> Download
                                                    </a> --}}
                                                </td>
                                                <td>
                                                    <span data-bs-toggle="tooltip" title="Hapus Data">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapus{{ $file['filename'] }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </span>

                                                    @include('admin_kecamatan.info.modalhapus')
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($laporan->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada laporan tersedia.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1">
                                <h5>Tabel Data</h5>
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="page d-flex justify-content-between align-items-center mb-3">
                                {{-- Form kiri: Tampilkan & Filter Provinsi --}}
                                <div class="d-flex align-items-center">
                                    <form method="GET" action="{{ route('admin_kecamatan.info-kirim') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <label for="lembar" class="me-2">Tampilkan:</label>
                                        <select name="lembar" id="lembar" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10"
                                                {{ request('lembar', 10) == 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="25" {{ request('lembar') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('lembar') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('lembar') == 100 ? 'selected' : '' }}>
                                                100
                                            </option>
                                        </select>
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div>
                                    <form method="GET" action="{{ route('admin_kecamatan.info-kirim') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="lembar" value="{{ request('lembar', 10) }}">
                                        <input type="hidden" name="halaman" value="1">

                                        <input type="text" name="cari" value="{{ $cari }}"
                                            class="form-control form-control-sm me-2" style="width: 200px;"
                                            placeholder="Cari Username">
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-bs-toggle="tooltip" title="Cari Data">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%; white-space: nowrap">
                                    <thead class="table-primary align-middle">
                                        <tr>
                                            <th>Pilih <br>
                                                <input type="checkbox" class="check-all">
                                            </th>
                                            <th>No</th>
                                            <th>Nama Pengguna</th>
                                            <th>No HP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($useradmin as $index => $item)
                                            <tr>
                                                <td><input type="checkbox" name="user_ids[]"
                                                        value="{{ $item->id }}" class="user-checkbox"></td>
                                                <td>{{ $useradmin->firstItem() + $index }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->no_hp }}</td>
                                                <td>
                                                    <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                        data-bs-placement="top" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bxs-trash'></i> <span>Kirim Data</span>">
                                                        <button type="button"
                                                            class="btn btn-sm btn-info rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kirim{{ $item->id }}">
                                                            <i class="fa-solid fa-paper-plane"></i> Kirim
                                                        </button>
                                                    </span>
                                                    @include('admin_kecamatan.info.modalKirim')
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($useradmin->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada pengguna tersedia.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kirim WhatsApp untuk Satu Pengguna -->
    @foreach ($useradmin as $item)
        <div class="modal fade" id="kirim{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="kirimLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('adminkecamatan.send-whatsapp') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="kirimLabel{{ $item->id }}">Kirim Dokumen ke
                                {{ $item->username }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-dark text-start">
                                <li>Formulir Pengiriman</li>
                            </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor WhatsApp</label>
                                        <input type="text" class="form-control" value="{{ $item->no_hp }}"
                                            readonly>
                                        <input type="hidden" name="user_ids[]" value="{{ $item->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="filename{{ $item->id }}" class="form-label">Pilih Dokumen
                                            PDF</label>
                                        <select name="filename" id="filename{{ $item->id }}" class="form-select"
                                            required>
                                            <option value="">-- Pilih Dokumen --</option>
                                            @foreach ($laporan as $file)
                                                <option value="{{ $file['filename'] }}">{{ $file['filename'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="message{{ $item->id }}" class="form-label">Pesan
                                            Kustom</label>
                                        <textarea name="message" id="message{{ $item->id }}" class="form-control" rows="5" required
                                            placeholder="Masukkan pesan kustom untuk dikirim melalui WhatsApp"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane"></i> Kirim
                            </button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
