<x-utama.layout.main title="Admin Kecamatan | Data Infaq Hasil Disetor">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Infaq Hasil Disetor</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-dark">
                                <li><strong>Tabel Data</strong></li>
                            </h5>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <!-- Form Filter -->
                                <form method="GET" action="#" class="d-flex align-items-end gap-2">
                                    <!-- Tampilkan -->
                                    <div>
                                        <label for="entries" class="form-label">Entri:</label>
                                        {{-- <select name="entries" id="entries" class="form-select form-select-sm"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select> --}}
                                    </div>
                                </form>

                                <!-- Form Search -->
                                <form method="GET" action="#" class="d-flex align-items-end gap-2">
                                    <div>
                                        <label for="search" class="form-label">Cari:</label>
                                        <input type="text" name="search" value=""
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
                                            <th rowspan="2">Nama Petugas</th>
                                            <th rowspan="2">Tanggal Setor</th>
                                            <th colspan="3">Wilayah Infaq</th>
                                            <th rowspan="2">Bukti Foto</th>
                                            <th rowspan="2">Total Infaq</th>
                                            <th rowspan="2">Keterangan</th>
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>RT/RW</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end mt-2">
                                    {{-- {{ $hasilinfaq->appends(['entries' => $entries])->links() }} --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- @include('petugas.setoran.hapus') --}}

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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush

</x-utama.layout.main>
