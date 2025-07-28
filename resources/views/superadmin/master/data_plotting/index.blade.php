<x-utama.layout.main title="Superadmin | Master Plotting Tempat">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Plotting Tempat</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/plotting/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="container-fluid mb-3">
                                <div class="row gy-3 align-items-end">
                                    <!-- Kolom Kiri: Tampilkan & Filter -->
                                    <div class="col-12 col-md-8">
                                        <form method="GET" action="{{ route('superadmin.master.plotting') }}">
                                            <div class="row gy-2 gx-3 align-items-end">
                                                <!-- Tampilkan -->
                                                <div class="col-auto">
                                                    <label for="entries" class="form-label mb-0">Tampilkan:</label>
                                                    <select name="entries" id="entries"
                                                        class="form-select form-select-sm"
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
                                                <div class="col-auto">
                                                    <label for="kecamatan" class="form-label mb-0">Kecamatan:</label>
                                                    <select name="kecamatan" id="kecamatan"
                                                        class="form-select form-select-sm">
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
                                                <div class="col-auto">
                                                    <label for="kelurahan" class="form-label mb-0">Kelurahan:</label>
                                                    <select name="kelurahan" id="kelurahan"
                                                        class="form-select form-select-sm">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                        <!-- Kelurahan akan diisi melalui JavaScript -->
                                                    </select>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div class="col-auto d-flex gap-2 align-items-end">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bx bxs-filter-alt"></i> Filter
                                                    </button>
                                                    <a href="{{ route('superadmin.master.plotting') }}"
                                                        class="btn btn-sm btn-secondary">
                                                        <i class="bx bx-reset"></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Kolom Kanan: Search -->
                                    <div class="col-12 col-md-4">
                                        <form method="GET" action="{{ route('superadmin.master.plotting') }}">
                                            <div class="row g-2 align-items-end">
                                                <div class="col-8 col-sm-9">
                                                    <input type="text" name="search" value="{{ $search }}"
                                                        class="form-control form-control-sm" placeholder="Cari...">
                                                </div>
                                                <div class="col-4 col-sm-3">
                                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                                        <i class="bx bx-search-alt-2"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="white-space: nowrap">
                                    <thead class="table-primary align-middle">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama User</th>
                                            <th rowspan="2">Nama Lengkap</th>
                                            <th rowspan="2">Jabatan</th>
                                            <th colspan="2">Wilayah</th>
                                            <th rowspan="2">RT</th>
                                            <th rowspan="2">RW</th>
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
                                            <td>Kecamatan</td>
                                            <td>Kelurahan</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($plotting->isEmpty())
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($plotting as $index => $item)
                                                <tr>
                                                    <td>{{ $plotting->firstItem() + $index }}</td>
                                                    <td>{{ $item->user->username ?? '-' }}</td>
                                                    <td>{{ $item->datadiri->nama_lengkap ?? '-' }}</td>
                                                    <td>{{ $item->user->setting->namasetting ?? '-' }}</td>
                                                    <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                                    <td>
                                                        @forelse ($item->kelurahan as $kel)
                                                            <span>{{ $kel->nama_kelurahan }}</span>
                                                        @empty
                                                            <span>-</span>
                                                        @endforelse
                                                    </td>
                                                    <td>{{ $item->Rt }}</td>
                                                    <td>{{ $item->Rw }}</td>
                                                    <td>
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <a href="{{ url('superadmin/master-data/plotting/edit-data/' . $item->id) }}"
                                                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4" data-bs-placement="top"
                                                                data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapus{{ $item->id }}">
                                                                    <i class="bx bxs-trash"></i> Hapus
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end mt-3 mt-3">
                                    {{ $plotting->appends(['entries' => $entries])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_plotting.hapus')

    @push('css')
    @endpush

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
                            url: '{{ route('superadmin.master.getKelurahan') }}',
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
