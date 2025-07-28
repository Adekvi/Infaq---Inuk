<x-utama.layout.main title="Kolektor | Plotting Tempat">

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
                                <a href="{{ url('kolektor/plotting-tempat') }}" class="btn btn-primary rounded-pill"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                    data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="page mb-3">
                                <div class="row g-2 align-items-end">
                                    <!-- Form kiri -->
                                    <div class="col-lg-9 col-md-12">
                                        <form method="GET" action="{{ route('plotting.kolektor.index') }}">
                                            <input type="hidden" name="page" value="1">
                                            <div class="row g-2">
                                                <!-- Tampilkan -->
                                                <div class="col-auto">
                                                    <label for="entries" class="form-label">Tampilkan:</label>
                                                    <select name="entries" id="entries"
                                                        class="form-select form-select-sm" style="width: 80px;"
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
                                                    <label for="kecamatan" class="form-label">Kecamatan:</label>
                                                    <select name="kecamatan" id="kecamatan"
                                                        class="form-select form-select-sm" style="width: 200px;">
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
                                                    <label for="kelurahan" class="form-label">Kelurahan:</label>
                                                    <select name="kelurahan" id="kelurahan"
                                                        class="form-select form-select-sm" style="width: 200px;">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                    </select>
                                                </div>

                                                <!-- Tombol -->
                                                <div class="col-auto d-flex align-items-end" style="gap: 6px;">
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                        data-bs-placement="top" data-bs-html="true"
                                                        title="<i class='bx bxs-filter-alt'></i> <span>Filter</span>">
                                                        <i class="bx bxs-filter-alt"></i> Filter
                                                    </button>
                                                    <a href="{{ route('plotting.kolektor.index') }}"
                                                        class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                        title="<i class='bx bx-reset'></i> <span>Reset Filter</span>">
                                                        <i class='bx bx-reset'></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Form kanan: Search -->
                                    <div class="col-lg-3 col-md-12">
                                        <form method="GET" action="{{ route('plotting.kolektor.index') }}"
                                            class="d-flex align-items-end">
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm me-2" placeholder="Cari........">
                                            <button type="submit" class="btn btn-sm btn-primary flex-shrink-0"
                                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                data-bs-html="true"
                                                title="<i class='bx bx-search-alt-2'></i> <span>Cari</span>">
                                                <i class='bx bx-search-alt-2'></i> Cari
                                            </button>
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
                                            <th rowspan="2">Username</th>
                                            {{-- <th rowspan="2">Jabatan</th> --}}
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
                                                    {{-- <td>{{ $item->user->setting->namasetting ?? '-' }}</td> --}}
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
                                                        <a href="{{ url('kolektor/plotting-tempat/edit/' . $item->id) }}"
                                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                            data-bs-offset="0,4" data-bs-placement="top"
                                                            data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                            <i class="bx bxs-pencil"></i> Edit
                                                        </a>
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
                            url: '{{ route('kolektor.master.getKelurahan') }}',
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
