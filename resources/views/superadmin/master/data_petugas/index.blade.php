<x-utama.layout.main title="Superadmin | Master Data Petugas">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Master Data Petugas</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/petugas-dataPetugas/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="page d-flex justify-content-between align-items-center mb-3">
                                {{-- Form kiri: Tampilkan & Filter Provinsi --}}
                                <div class="d-flex align-items-center">
                                    <form method="GET" action="{{ route('superadmin.master.dataPetugas') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <label for="entries" class="me-2">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>

                                        {{-- Filter Provinsi --}}
                                        {{-- <select name="filter_wilayah" class="form-select form-select-sm me-2">
                                            <option value="">-- Semua Wilayah --</option>
                                            @foreach ($wilayahList as $wil)
                                                <option value="{{ $wil->id }}"
                                                    {{ request('filter_wilayah') == $wil->id ? 'selected' : '' }}>
                                                    {{ $wil->namaWilayah }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-primary" style="width: 150px;">
                                            <i class="bx bxs-filter-alt"></i> Filter</button> --}}
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div>
                                    <form method="GET" action="{{ route('superadmin.master.dataPetugas') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                        {{-- <input type="hidden" name="filter_wilayah"
                                            value="{{ request('filter_wilayah') }}"> --}}
                                        <input type="hidden" name="page" value="1">

                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control form-control-sm me-2" style="width: 200px;"
                                            placeholder="Cari Petugas">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%; white-space: nowrap">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Wilayah</th>
                                            <th>Nama Petugas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($petugas->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($petugas as $index => $item)
                                                <tr>
                                                    <td>{{ $petugas->firstItem() + $index }}</td>
                                                    <td>
                                                        @if ($item->kelurahans && $item->kelurahans->isNotEmpty())
                                                            @foreach ($item->kelurahans as $wilayah)
                                                                {{ $wilayah->nama_kelurahan }}
                                                                (RW: {{ $wilayah->pivot->RW ?? '-' }}, RT:
                                                                {{ $wilayah->pivot->RT ?? '-' }})
                                                                @if (!$loop->last)
                                                                    -
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            Tidak ada kelurahan terkait
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->nama_petugas }}</td>
                                                    <td>
                                                        <a href="{{ url('superadmin/master-data/petugas-dataPetugas/edit-data/' . $item->id) }}"
                                                            class="btn btn-warning rounded-pill"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                            <i class="bx bxs-pencil"></i> Edit
                                                        </a>
                                                        <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                            <button type="button"class="btn btn-danger rounded-pill"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hapus{{ $item->id }}">
                                                                <i class="bx bxs-trash"></i> Hapus
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end">
                                    {{ $petugas->appends(['entries' => $entries])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_petugas.hapus')

    {{-- @push('css')
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $('#id_provinsi').change(function() {
                let provinsiID = $(this).val();
                $('#id_kabupaten').html('<option>Loading...</option>');
                $('#id_kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
                $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

                $.get('/pelanggan/get-kabupaten/' + provinsiID, function(data) {
                    let options = '<option value="">-- Pilih Kabupaten --</option>';
                    data.forEach(function(kab) {
                        options += `<option value="${kab.id}">${kab.namaKabupaten}</option>`;
                    });
                    $('#id_kabupaten').html(options);
                });
            });

            $('#id_kabupaten').change(function() {
                let kabupatenID = $(this).val();
                $('#id_kecamatan').html('<option>Loading...</option>');
                $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

                $.get('/pelanggan/get-kecamatan/' + kabupatenID, function(data) {
                    let options = '<option value="">-- Pilih Kecamatan --</option>';
                    data.forEach(function(kec) {
                        options += `<option value="${kec.id}">${kec.namaKecamatan}</option>`;
                    });
                    $('#id_kecamatan').html(options);
                });
            });

            $('#id_kecamatan').change(function() {
                let kecamatanID = $(this).val();
                $('#id_kelurahan').html('<option>Loading...</option>');

                $.get('/pelanggan/get-kelurahan/' + kecamatanID, function(data) {
                    let options = '<option value="">-- Pilih Kelurahan --</option>';
                    data.forEach(function(kel) {
                        options += `<option value="${kel.id}">${kel.namaKelurahan}</option>`;
                    });
                    $('#id_kelurahan').html(options);
                });
            });
        </script>
    @endpush --}}

</x-utama.layout.main>
