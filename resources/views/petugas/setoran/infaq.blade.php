<x-utama.layout.main title="Petugas | Data Setoran Infaq">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Setoran Infaq</strong></h5>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <div class="mb-1" style="display: flex; justify-content: space-between">
                                    <h5>Tabel Data</h5>
                                    <a href="{{ url('petugas/setoran/input-infaq/tambah-data') }}"
                                        class="btn btn-primary rounded-pill" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                        data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                        <i class="bx bxs-file-plus"></i>
                                    </a>
                                </div>
                                <hr style="height: 2px; border: none">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                    <!-- Form Filter -->
                                    <form method="GET" action="{{ route('petugas.input.infaq') }}"
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

                                        <!-- Filter Kecamatan -->
                                        <div>
                                            <label for="id_kecamatan" class="form-label">Kecamatan:</label>
                                            <select name="id_kecamatan" id="id_kecamatan"
                                                class="form-select form-select-sm" style="width: 200px;">
                                                <option value="">-- Semua Kecamatan --</option>
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}"
                                                        {{ $id_kecamatan == $kecamatan->id ? 'selected' : '' }}>
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filter Kelurahan -->
                                        <div>
                                            <label for="id_kelurahan" class="form-label">Kelurahan:</label>
                                            <select name="id_kelurahan" id="id_kelurahan"
                                                class="form-select form-select-sm" style="width: 200px;">
                                                <option value="">-- Semua Kelurahan --</option>
                                                <!-- Kelurahan diisi melalui AJAX -->
                                            </select>
                                        </div>

                                        <!-- Tombol Filter dan Reset -->
                                        <div>
                                            <button type="submit" class="btn btn-sm btn-primary me-2"
                                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                data-bs-html="true"
                                                title="<i class='bx bxs-pencil'></i> <span>Filter Data</span>">
                                                <i class="fa-solid fa-filter"></i> Filter
                                            </button>
                                            <a href="{{ route('petugas.input.infaq') }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                title="<i class='bx bx-reset'></i> <span>Reset Filter</span>">
                                                Reset
                                            </a>
                                        </div>
                                    </form>

                                    <!-- Form Search -->
                                    <form method="GET" action="{{ route('petugas.input.infaq') }}"
                                        class="d-flex align-items-end gap-2">
                                        <div>
                                            <label for="search" class="form-label">Cari:</label>
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm" style="width: 200px;"
                                                placeholder="Cari Jenis Infaq atau Jumlah">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
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
                                                <th colspan="2">Waktu</th>
                                                <th colspan="3">Wilayah Infaq</th>
                                                <th rowspan="2">Jenis Infaq</th>
                                                <th colspan="4">Nominal Infaq</th>
                                                {{-- <th rowspan="2">Jumlah</th> --}}
                                                <th rowspan="2">Keterangan</th>
                                                <th rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Bulan</th>
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
                                            <?php
                                            if (!function_exists('rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            @if ($infaq->isEmpty())
                                                <tr>
                                                    <td colspan="16" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($infaq as $index => $item)
                                                    @if ($item->status == 'S')
                                                        <tr>
                                                            <td>{{ $infaq->firstItem() + $index }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tgl_infaq ?? '-')->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $item->bulan ? $months[$item->bulan] : '-' }}</td>
                                                            <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                                            <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                                                            <td>
                                                                @if ($item->petugas && $item->petugas->wilayahTugas->isNotEmpty())
                                                                    {{ $item->petugas->wilayahTugas->where('id_kecamatan', $item->id_kecamatan)->where('id_kelurahan', $item->id_kelurahan)->map(function ($wilayah) {
                                                                            return ($wilayah->RT ?? '-') . '/' . ($wilayah->RW ?? '-');
                                                                        })->implode(', ') ?:
                                                                        '-' }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->jenis_infaq }}</td>
                                                            <td>{{ Rupiah($item->minggu1) }}</td>
                                                            <td>{{ Rupiah($item->minggu2) }}</td>
                                                            <td>{{ Rupiah($item->minggu3) }}</td>
                                                            <td>{{ Rupiah($item->minggu4) }}</td>
                                                            {{-- <td>{{ Rupiah($item->jumlah) }}</td> --}}
                                                            <td>{{ $item->keterangan }}</td>
                                                            <td>
                                                                <a href="{{ url('petugas/setoran/input-infaq/edit-data/' . $item->id) }}"
                                                                    class="btn btn-warning rounded-pill"
                                                                    data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                    data-bs-placement="top" data-bs-html="true"
                                                                    data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                    <i class="bx bxs-pencil"></i> Edit
                                                                </a>
                                                                <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                    data-bs-placement="top" data-bs-html="true"
                                                                    data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                    <button
                                                                        type="button"class="btn btn-danger rounded-pill"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#hapus{{ $item->id }}">
                                                                        <i class="bx bxs-trash"></i> Hapus
                                                                    </button>
                                                                </span>
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
                                        {{ $infaq->appends(['entries' => $entries])->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Kirim Batch -->
                    <form id="kirimForm" action="{{ url('petugas/kirim-infaq/index') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Detail Total Infaq</h5>
                                    <hr class="mt-2 mb-0" style="height: 2px; border: none">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center">
                                            <thead class="table-primary align-middle">
                                                <tr>
                                                    <th rowspan="2">Pilih Data <br>
                                                        <input type="checkbox" id="checkAll">
                                                    </th>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Jenis Infaq</th>
                                                    <th colspan="4">Nominal</th>
                                                    <th rowspan="2">Jumlah</th>
                                                </tr>
                                                <tr>
                                                    <th>Minggu I</th>
                                                    <th>Minggu II</th>
                                                    <th>Minggu III</th>
                                                    <th>Minggu IV</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($infaq->isEmpty())
                                                    <tr>
                                                        <td colspan="10" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @else
                                                    @foreach ($infaq as $item)
                                                        <tr>
                                                            <td>
                                                                @if ($item->status == 'S')
                                                                    <input type="checkbox" name="id_setor[]"
                                                                        value="{{ $item->id }}"
                                                                        class="checkItem">
                                                                @endif
                                                            </td>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->jenis_infaq }}</td>
                                                            <td>{{ Rupiah($item->minggu1) }}</td>
                                                            <td>{{ Rupiah($item->minggu2) }}</td>
                                                            <td>{{ Rupiah($item->minggu3) }}</td>
                                                            <td>{{ Rupiah($item->minggu4) }}</td>
                                                            <td>{{ Rupiah($item->jumlah) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="7" class="text-center fw-bold">Jumlah Total
                                                        </td>
                                                        <td class="fw-bold">{{ Rupiah($infaq->sum('jumlah')) }}</td>
                                                        {{-- <td colspan="2"></td> --}}
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($infaq->where('status', 'S')->count() > 0)
                                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                            data-bs-target="#kirimModal">
                                            <i class="fa-solid fa-paper-plane"></i> Kirim Data Terpilih
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @include('petugas.setoran.kirim.modalKirim')

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('petugas.setoran.hapus')

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: '-- Pilih --',
                    allowClear: true,
                    width: '100%'
                });

                // Check/Uncheck all checkboxes
                $('#checkAll').on('change', function() {
                    $('.checkItem').prop('checked', $(this).prop('checked'));
                    updateSelectedItems();
                });

                // Update selected items list in modal
                $('.checkItem').on('change', updateSelectedItems);

                function updateSelectedItems() {
                    const selected = $('.checkItem:checked').map(function() {
                        const row = $(this).closest('tr');
                        const jenis = row.find('td').eq(2).text();
                        const jumlah = row.find('td').eq(7).text();
                        return {
                            html: `<li>${jenis} - ${jumlah}</li>`,
                            jumlah: parseFloat(jumlah.replace(/[^0-9]/g, '')) ||
                                0 // Hapus format Rupiah dan konversi ke number
                        };
                    }).get();

                    // Hitung total jumlah
                    const totalJumlah = selected.reduce((sum, item) => sum + item.jumlah, 0);

                    // Format total ke Rupiah
                    const formattedTotal = 'Rp ' + totalJumlah.toLocaleString('id-ID');

                    // Buat HTML untuk daftar item dan total
                    const htmlContent = selected.length > 0 ?
                        selected.map(item => item.html).join('') +
                        `<li><strong>Total: ${formattedTotal}</strong></li>` :
                        '<li>Tidak ada data terpilih</li>';

                    $('#selectedItems').html(htmlContent);
                }

                // Prevent modal if no items selected
                $('[data-bs-target="#kirimModal"]').on('click', function(e) {
                    if ($('.checkItem:checked').length === 0) {
                        e.preventDefault();
                        alert('Pilih setidaknya satu setoran untuk dikirim.');
                    }
                });

                // Inisialisasi kelurahan saat halaman dimuat jika id_kecamatan sudah dipilih
                const idKecamatan = $('#id_kecamatan').val();
                if (idKecamatan) {
                    updateKelurahan(idKecamatan, '{{ $id_kelurahan }}');
                }

                // Dengarkan perubahan pada dropdown kecamatan
                $('#id_kecamatan').on('change', function() {
                    const kecamatanId = $(this).val();
                    updateKelurahan(kecamatanId);
                });

                function updateKelurahan(kecamatanId, selectedKelurahanId = '') {
                    const $kelurahanSelect = $('#id_kelurahan');
                    $kelurahanSelect.empty().append('<option value="">-- Semua Kelurahan --</option>');

                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('petugas.getKelurahanByWilayahTugas') }}',
                            type: 'POST',
                            data: {
                                id_kecamatan: kecamatanId,
                                id_petugas: {{ $petugas->id }},
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                data.forEach(function(kelurahan) {
                                    const selected = kelurahan.id == selectedKelurahanId ?
                                        'selected' : '';
                                    $kelurahanSelect.append(
                                        `<option value="${kelurahan.id}" ${selected}>${kelurahan.nama_kelurahan}</option>`
                                    );
                                });
                                $kelurahanSelect.trigger('change');
                            },
                            error: function(error) {
                                console.error('Error fetching kelurahan:', error);
                                alert('Gagal mengambil data kelurahan.');
                            }
                        });
                    }
                }
            });
        </script>
    @endpush

</x-utama.layout.main>
