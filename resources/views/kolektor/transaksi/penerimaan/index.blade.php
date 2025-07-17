<x-utama.layout.main title="Kolektor | Penerimaan Infaq">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Penerimaan Infaq</strong></h5>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <div class="mb-1" style="display: flex; justify-content: space-between">
                                    <h5>Tabel Data</h5>
                                    <a href="{{ url('kolektor/penerimaan/input-infaq/tambah-data') }}"
                                        class="btn btn-primary rounded-pill" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                        data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                        <i class="bx bxs-file-plus"></i>
                                    </a>
                                </div>
                                <hr style="height: 2px; border: none">
                            </div>
                            <div class="card-body">
                                <div class="page mb-3">
                                    <div class="row g-2 align-items-end justify-content-between flex-wrap">
                                        <div class="col-xl-auto col-lg-12">
                                            <form method="GET" action="{{ route('kolektor.input.infaq') }}"
                                                class="d-flex align-items-end flex-wrap gap-2">
                                                <input type="hidden" name="page" value="1">

                                                <!-- Jumlah Tampilkan -->
                                                <div>
                                                    <select name="entries" id="entries"
                                                        class="form-select form-select-sm" style="width: 60px;"
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

                                                <!-- Kecamatan -->
                                                <div>
                                                    <label for="kecamatan" class="form-label">Kecamatan:</label>
                                                    <select name="kecamatan" id="kecamatan"
                                                        class="form-select form-select-sm" style="width: 170px;">
                                                        <option value="">-- Pilih Kecamatan --</option>
                                                        @foreach ($kecamatans as $kec)
                                                            <option value="{{ $kec->id }}"
                                                                {{ request('kecamatan') == $kec->id ? 'selected' : '' }}>
                                                                {{ $kec->nama_kecamatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Kelurahan -->
                                                <div>
                                                    <label for="kelurahan" class="form-label">Kelurahan:</label>
                                                    <select name="kelurahan" id="kelurahan"
                                                        class="form-select form-select-sm" style="width: 170px;">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                        <!-- Kelurahan akan diisi melalui JavaScript -->
                                                    </select>
                                                </div>

                                                <!-- RT -->
                                                <div>
                                                    <label for="rt" class="form-label mb-1">RT:</label>
                                                    <select name="rt" id="rt"
                                                        class="form-control form-control-sm" style="width: 90px;">
                                                        <option value="">-- Pilih RT --</option>
                                                        @foreach ($rts as $rtValue)
                                                            <option value="{{ $rtValue }}"
                                                                {{ request('rt') == $rtValue ? 'selected' : '' }}>
                                                                {{ $rtValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- RW -->
                                                <div>
                                                    <label for="rw" class="form-label mb-1">RW:</label>
                                                    <select name="rw" id="rw"
                                                        class="form-control form-control-sm" style="width: 90px;">
                                                        <option value="">-- Pilih RW --</option>
                                                        @foreach ($rws as $rwValue)
                                                            <option value="{{ $rwValue }}"
                                                                {{ request('rw') == $rwValue ? 'selected' : '' }}>
                                                                {{ $rwValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Tombol -->
                                                <div class="d-flex gap-2 align-items-end">
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="tooltip" title="Filter">
                                                        <i class="bx bxs-filter-alt"></i>
                                                    </button>
                                                    <a href="{{ route('kolektor.input.infaq') }}"
                                                        class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                        title="Reset Filter">
                                                        <i class='bx bx-reset'></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Pencarian -->
                                        <div class="col-xl-auto col-lg-12 mt-2 mt-xl-0">
                                            <form method="GET" action="{{ route('kolektor.input.infaq') }}"
                                                class="d-flex align-items-end gap-2">
                                                <input type="text" name="search" value="{{ $search }}"
                                                    class="form-control form-control-sm" style="width: 180px;"
                                                    placeholder="Cari...">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="tooltip" title="Cari">
                                                    <i class='bx bx-search-alt-2'></i> Cari
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered text-center"
                                        style="width:100%; white-space: nowrap">
                                        <thead class="table-primary text-center align-middle">
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Tanggal Penerimaan</th>
                                                <th colspan="3">Wilayah Infaq</th>
                                                <th rowspan="2">Nominal</th>
                                                {{-- <th rowspan="2">Jumlah</th> --}}
                                                <th rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>Kelurahan</th>
                                                <th>RT</th>
                                                <th>RW</th>
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
                                            @if ($terima->isEmpty())
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($terima as $index => $item)
                                                    @if ($item->status == 'Pending')
                                                        <tr>
                                                            <td>{{ $terima->firstItem() + $index }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->created_at ?? '-')->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $item->plotting->kelurahan->first()->nama_kelurahan ?? '-' }}
                                                            </td>
                                                            <td>{{ $item->Rt }}</td>
                                                            <td>{{ $item->Rw }}</td>
                                                            <td>{{ Rupiah($item->nominal) }}</td>
                                                            {{-- <td>{{ Rupiah($item->jumlah) }}</td> --}}
                                                            <td>
                                                                <a href="{{ url('kolektor/penerimaan/input-infaq/edit-data/' . $item->id) }}"
                                                                    class="btn btn-sm btn-warning rounded-pill"
                                                                    data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                                    data-bs-placement="top" data-bs-html="true"
                                                                    data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                    <i class="bx bxs-pencil"></i> Edit
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="9" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" class="text-center fw-bold">Jumlah Total</td>
                                                    <td colspan="2" class="fw-bold">
                                                        {{ Rupiah($terima->sum('nominal')) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="halaman d-flex justify-content-end mt-2">
                                        {{ $terima->appends(['entries' => $entries])->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Ketika dropdown kecamatan berubah
                $('#kecamatan').on('change', function() {
                    var kecamatanId = $(this).val();
                    var kelurahanSelect = $('#kelurahan');

                    // Kosongkan dropdown kelurahan
                    kelurahanSelect.html('<option value="">-- Pilih Kelurahan --</option>');

                    if (kecamatanId) {
                        // Kirim permintaan AJAX untuk mendapatkan kelurahan
                        $.ajax({
                            url: '{{ route('kolektor.penerimaan.getKelurahan') }}',
                            type: 'GET',
                            data: {
                                id_kecamatan: kecamatanId
                            },
                            success: function(data) {
                                // Isi dropdown kelurahan dengan data yang diterima
                                $.each(data, function(index, kelurahan) {
                                    kelurahanSelect.append(
                                        '<option value="' + kelurahan.id + '">' +
                                        kelurahan.nama_kelurahan + '</option>'
                                    );
                                });

                                // Jika ada kelurahan yang sudah dipilih sebelumnya
                                var selectedKelurahan = '{{ request('kelurahan') }}';
                                if (selectedKelurahan) {
                                    kelurahanSelect.val(selectedKelurahan);
                                }
                            },
                            error: function() {
                                alert('Gagal memuat data kelurahan.');
                            }
                        });
                    }
                });

                // Trigger change saat halaman dimuat untuk memastikan kelurahan terisi jika kecamatan sudah dipilih
                if ($('#kecamatan').val()) {
                    $('#kecamatan').trigger('change');
                }
            });
        </script>
    @endpush

</x-utama.layout.main>
