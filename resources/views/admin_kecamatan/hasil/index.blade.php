<x-utama.layout.main title="Admin Kecamatan | Data Infaq Hasil Disetor">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Infaq Hasil Disetor</strong></h5>
                    </div>

                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Filter Pencarian</h5>
                                <form id="filterForm" method="GET"
                                    action="{{ route('adminkecamatan.hasil-setoran') }}">
                                    <!-- Input tersembunyi untuk show_all -->
                                    <input type="hidden" name="show_all" id="show_all"
                                        value="{{ $showAll ? 'true' : 'false' }}">

                                    <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                        <input class="form-check-input" type="radio" name="filter_option"
                                            value="full_date" id="filter_by_full_date"
                                            {{ $filterOption === 'full_date' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_by_full_date"
                                            style="margin-right: 10px;"></label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                                            style="width: 45%;" value="{{ $tanggal ?? '' }}"
                                            {{ $filterOption !== 'full_date' ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                        <input class="form-check-input" type="radio" name="filter_option"
                                            value="month_year" id="filter_by_month_year"
                                            {{ $filterOption === 'month_year' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filter_by_month_year"
                                            style="margin-right: 10px;"></label>
                                        <div class="month_year" style="display: flex;">
                                            <select name="month" id="month" class="form-control"
                                                style="width: 50%;"
                                                {{ $filterOption !== 'month_year' ? 'disabled' : '' }}>
                                                <option value="">Bulan</option>
                                                @foreach ($months as $key => $monthName)
                                                    <option value="{{ $key }}"
                                                        {{ $month == $key ? 'selected' : '' }}>{{ $monthName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <select name="tahun" id="tahun" class="form-control"
                                                style="width: 50%; margin-left: 5px;"
                                                {{ $filterOption !== 'month_year' ? 'disabled' : '' }}>
                                                <option value="">Tahun</option>
                                                @php
                                                    $currentYear = date('Y');
                                                    for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                                        echo "<option value='$year' " .
                                                            ($tahun == $year ? 'selected' : '') .
                                                            ">$year</option>";
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>

                                    <p style="font-size: 14px; margin-bottom: 0px">
                                        <span style="color: red">*</span>
                                        Pilih salah satu atau cari semua data tanpa filter
                                    </p>
                                    <div class="row g-2">
                                        <!-- Tombol Cari -->
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="submit" id="btnSearch" class="btn btn-info w-100">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </div>

                                        <!-- Tombol Semua Data -->
                                        <div class="col-md-5 d-flex align-items-end">
                                            <a href="javascript:void(0)" onclick="setShowAll(true)"
                                                class="btn btn-primary w-100">
                                                <i class="fa-solid fa-file-lines"></i> Semua Data
                                            </a>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="button-group d-flex justify-content-between">
                                        <div class="reset">
                                            <a href="{{ route('adminkecamatan.hasil-setoran') }}"
                                                class="btn btn-secondary">
                                                <i class="fa-solid fa-arrow-rotate-right"></i> Reset
                                            </a>
                                        </div>
                                        <div class="print">
                                            <button type="button" id="btnCetak" class="btn btn-outline-warning">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </button>
                                        </div>
                                        <div class="export">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-info dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-file-export"></i> Export
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('hasilinfaq.setoran.excel', request()->query()) }}">Export
                                                            to Excel</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            onclick="exportFile('pdf')">Export to PDF</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('adminkecamatan.hasil-setoran.export-word', request()->query()) }}">Export
                                                            to Word</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal Loading -->
                                <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h5>Exporting PDF...</h5>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar" style="width: 0%" id="progressBar">0%
                                                    </div>
                                                </div>
                                                <p class="mt-3">Please wait while the PDF is being generated.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-dark">
                                    <li><strong>Tabel Data</strong></li>
                                </h5>
                                <hr style="height: 2px; border: none">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                    <!-- Form Filter -->
                                    <form method="GET" action="{{ route('adminkecamatan.hasil-setoran') }}"
                                        class="d-flex align-items-end gap-2">
                                        <!-- Tampilkan -->
                                        <div>
                                            <label for="entries" class="form-label">Entri:</label>
                                            <select name="entries" id="entries" class="form-select form-select-sm"
                                                style="width: 80px;" onchange="this.form.submit()">
                                                <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10
                                                </option>
                                                <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25
                                                </option>
                                                <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50
                                                </option>
                                                <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100
                                                </option>
                                            </select>
                                        </div>
                                    </form>

                                    <!-- Form Search -->
                                    <form method="GET" action="{{ route('adminkecamatan.hasil-setoran') }}"
                                        class="d-flex align-items-end gap-2">
                                        <div>
                                            <label for="search" class="form-label">Cari:</label>
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm" style="width: 200px;"
                                                placeholder="Cari Jenis Infaq atau Jumlah">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                            data-bs-html="true"
                                            title="<i class='bx bxs-pencil'></i> <span>Cari Data</span>">
                                            <i class="fa-solid fa-search"></i> Cari
                                        </button>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered text-center"
                                        style="width:100%; white-space: nowrap">
                                        <thead class="table-primary text-center align-middle">
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Tanggal Kirim</th>
                                                <th colspan="3">Wilayah Infaq</th>
                                                <th rowspan="2">Bukti Foto</th>
                                                <th rowspan="2">Total Infaq</th>
                                                <th rowspan="2">Keterangan</th>
                                                <th rowspan="2">Status</th>
                                                <th rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>Kecamatan</th>
                                                <th>Kelurahan</th>
                                                <th>RT/RW</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!function_exists('rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            @if ($hasil->isEmpty())
                                                <tr>
                                                    <td colspan="15" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($hasil as $index => $item)
                                                    @if ($item->status == 'Kirim')
                                                        <tr>
                                                            <td>{{ $hasil->firstItem() + $index }}</td>
                                                            <td>{{ $item->petugas->nama_petugas ?? '-' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tgl_kirim ?? '-')->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $item->setor->kecamatan->nama_kecamatan ?? '-' }}
                                                            </td>
                                                            <td>{{ $item->setor->kelurahan->nama_kelurahan ?? '-' }}
                                                            </td>
                                                            <td>
                                                                @if ($item->setor->petugas && $item->setor->petugas->wilayahTugas->isNotEmpty())
                                                                    {{ $item->setor->petugas->wilayahTugas->where('id_kecamatan', $item->setor->id_kecamatan)->where('id_kelurahan', $item->setor->id_kelurahan)->map(function ($wilayah) {
                                                                            return ($wilayah->RT ?? '-') . '/' . ($wilayah->RW ?? '-');
                                                                        })->implode(', ') ?:
                                                                        '-' }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Tombol atau elemen untuk memicu modal -->
                                                                @if ($item->bukti_foto)
                                                                    @php
                                                                        $fileExtension = pathinfo(
                                                                            Storage::path($item->bukti_foto),
                                                                            PATHINFO_EXTENSION,
                                                                        );
                                                                        $isImage = in_array(
                                                                            strtolower($fileExtension),
                                                                            ['jpg', 'jpeg', 'png'],
                                                                        );
                                                                    @endphp

                                                                    <button type="button"
                                                                        class="btn btn-link view-media"
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

                                                                    <!-- Modal -->
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
                                                                                        <span
                                                                                            aria-hidden="true"></span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div id="mediaContent">
                                                                                        <img src="{{ Storage::url($item->bukti_foto) }}"
                                                                                            width="100%"
                                                                                            height="100%"
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
                                                            <td>{{ Rupiah($item->setor->jumlah ?? '-') }}</td>
                                                            <td>{{ $item->setor->keterangan }}</td>
                                                            <td>
                                                                @if ($item->status == 'Kirim')
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-warning">
                                                                        <i class="fas fa-circle-info"></i> Belum
                                                                        Dikirim
                                                                    </button>
                                                                @else
                                                                    <p>-</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{-- <button type="button" class=""></button> --}}

                                                                <button type="button" class="btn btn-sm btn-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#detail{{ $item->id }}">
                                                                    <i class="fa-solid fa-pen"></i> Detail
                                                                </button>

                                                                @include('admin_kecamatan.hasil.modalDetail')
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="9" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="halaman d-flex justify-content-end mt-2">
                                        {{ $hasil->appends(['entries' => $entries])->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL LOADING --}}
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Exporting PDF...</h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            style="width: 0%" id="progressBar">0%</div>
                    </div>
                    <p class="mt-3">Harap tunggu PDF sedang dibuat!.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('petugas.setoran.hapus') --}}

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            #loadingModal {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px;
                border: 1px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                z-index: 1000;
            }

            #progressBar {
                width: 200px;
                height: 20px;
                background: #f0f0f0;
                border: 1px solid #ccc;
                position: relative;
            }

            #progress {
                height: 100%;
                background: #4caf50;
                width: 0%;
                transition: width 0.5s;
            }

            #progressText {
                text-align: center;
                margin-top: 10px;
            }

            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // EXPORT
            $(document).ready(function() {
                // Fungsi untuk mengatur status input berdasarkan filter_option
                function toggleInputs() {
                    if ($('#filter_by_full_date').is(':checked')) {
                        $('#tanggal').prop('disabled', false);
                        $('#month, #tahun').prop('disabled', true);
                    } else if ($('#filter_by_month_year').is(':checked')) {
                        $('#tanggal').prop('disabled', true);
                        $('#month, #tahun').prop('disabled', false);
                    } else {
                        $('#tanggal, #month, #tahun').prop('disabled', true);
                    }
                }

                // Fungsi untuk mengatur show_all
                window.setShowAll = function(value) {
                    $('#show_all').val(value ? 'true' : 'false');
                    $('#filterForm').submit(); // Submit form untuk menampilkan semua data
                };

                // Panggil fungsi saat halaman dimuat
                toggleInputs();

                // Event listener untuk perubahan radio button
                $('input[name="filter_option"]').on('change', function() {
                    $('#show_all').val('false'); // Reset show_all saat filter berubah
                    toggleInputs();
                });

                // Set nilai default dari server
                var filterOption = '{{ $filterOption ?? '' }}';
                var tanggal = '{{ $tanggal ?? '' }}';
                var month = '{{ $month ?? '' }}';
                var tahun = '{{ $tahun ?? '' }}';
                var showAll = '{{ $showAll ? 'true' : 'false' }}';

                if (showAll === 'true') {
                    $('#show_all').val('true');
                } else if (filterOption === 'full_date' && tanggal) {
                    $('#filter_by_full_date').prop('checked', true);
                    $('#tanggal').val(tanggal);
                } else if (filterOption === 'month_year' && month && tahun) {
                    $('#filter_by_month_year').prop('checked', true);
                    $('#month').val(month);
                    $('#tahun').val(tahun);
                }

                // Validasi sebelum submit
                $('#filterForm').on('submit', function(e) {
                    if ($('#show_all').val() === 'true') {
                        return; // Izinkan submit untuk show_all
                    }
                    if ($('#filter_by_full_date').is(':checked') && !$('#tanggal').val()) {
                        e.preventDefault();
                        alert('Harap pilih tanggal!');
                    } else if ($('#filter_by_month_year').is(':checked') && (!$('#month').val() || !$('#tahun')
                            .val())) {
                        e.preventDefault();
                        alert('Harap pilih bulan dan tahun!');
                    }
                });

                // Handle tombol Cetak
                $('#btnCetak').on('click', function() {
                    window.print();
                });

                // Handle export
                window.exportFile = function(type) {
                    if (type !== 'pdf') {
                        var form = $('#filterForm');
                        var action = type === 'word' ? '{{ route('adminkecamatan.hasil-setoran.export-word') }}' :
                            '';
                        if (!action) {
                            alert('Export to ' + type + ' belum diimplementasikan.');
                            return;
                        }

                        var tempForm = $('<form>', {
                            'method': 'GET',
                            'action': action
                        });

                        form.find('input, select').each(function() {
                            var input = $(this);
                            if (input.val() && !input.is(':disabled')) {
                                tempForm.append($('<input>', {
                                    'type': 'hidden',
                                    'name': input.attr('name'),
                                    'value': input.val()
                                }));
                            }
                        });

                        tempForm.appendTo('body').submit();
                        return;
                    }

                    // Handle export PDF dengan AJAX
                    // Ambil parameter query dari URL
                    var urlParams = new URLSearchParams(window.location.search);
                    var formData = $('#filterForm').serialize();
                    // Gabungkan parameter query dengan formData
                    urlParams.forEach(function(value, key) {
                        if (!formData.includes(key + '=')) {
                            formData += '&' + key + '=' + encodeURIComponent(value);
                        }
                    });

                    var progressUrl = '{{ route('adminkecamatan.hasil-setoran.export-pdf.progres') }}';
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    if (!csrfToken) {
                        alert('CSRF token tidak ditemukan. Silakan muat ulang halaman.');
                        return;
                    }

                    $('#loadingModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#progressBar').css('width', '0%').text('0%');

                    $.ajax({
                        url: '{{ route('adminkecamatan.hasil-setoran.export-pdf.start') }}',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.message) {
                                $('#loadingModal').modal('hide');
                                alert(response.message);
                                return;
                            }

                            var exportId = response.export_id;
                            var fileUrl = response.file_url;
                            var filename = response.filename;

                            var progressInterval = setInterval(function() {
                                $.get(progressUrl, {
                                    export_id: exportId
                                }, function(data) {
                                    var progress = data.progress;
                                    $('#progressBar').css('width', progress + '%').text(
                                        progress + '%');

                                    if (progress >= 100) {
                                        clearInterval(progressInterval);
                                        $('#loadingModal').modal('hide');

                                        var link = document.createElement('a');
                                        link.href = fileUrl;
                                        link.download = filename;
                                        document.body.appendChild(link);
                                        link.click();
                                        document.body.removeChild(link);

                                        $('#filterForm')[0].reset();
                                        $('#show_all').val('false');
                                        toggleInputs();
                                    }
                                }).fail(function(xhr) {
                                    clearInterval(progressInterval);
                                    $('#loadingModal').modal('hide');
                                    alert('Gagal memeriksa progres: ' + (xhr
                                        .responseJSON?.message ||
                                        'Terjadi kesalahan.'));
                                });
                            }, 1000);
                        },
                        error: function(xhr) {
                            $('#loadingModal').modal('hide');
                            alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message ||
                                'Gagal memproses ekspor.'));
                        }
                    });
                };
            });
        </script>
    @endpush

</x-utama.layout.main>
