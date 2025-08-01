<x-utama.layout.main title="Kolektor | Rekap Pengiriman">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Rekap Pengiriman Infaq</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="page mb-3">
                                <div class="row g-2 align-items-end justify-content-between flex-wrap">
                                    <div class="col-xl-auto col-lg-12">
                                        <form method="GET" action="{{ route('kolektor.hasil-setoran') }}"
                                            class="d-flex align-items-end flex-wrap gap-2">
                                            <input type="hidden" name="page" value="1">

                                            <!-- Jumlah Tampilkan -->
                                            <div>
                                                <select name="entries" id="entries" class="form-select form-select-sm"
                                                    style="width: 60px;" onchange="this.form.submit()">
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
                                            {{-- <div>
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
                                                </div> --}}

                                            <!-- Tombol -->
                                            <div class="d-flex gap-2 align-items-end">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="tooltip" title="Filter">
                                                    <i class="bx bxs-filter-alt"></i>
                                                </button>
                                                <a href="{{ route('kolektor.hasil-setoran') }}"
                                                    class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                    title="Reset Filter">
                                                    <i class='bx bx-reset'></i>
                                                </a>
                                                <!-- Tombol Tampilkan Semua -->
                                                <button type="submit" name="show_all"
                                                    value="{{ $showAll ? '0' : '1' }}" class="btn btn-sm btn-info"
                                                    data-bs-toggle="tooltip" title="Semua Data">
                                                    <i class="fas fa-file-lines"></i>
                                                    {{ $showAll ? 'Data Hari Ini' : 'Semua Data' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Pencarian -->
                                    <div class="col-xl-auto col-lg-12 mt-2 mt-xl-0">
                                        <form method="GET" action="{{ route('kolektor.hasil-setoran') }}"
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

                            <div class="row">
                                @if ($hasil->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    <?php
                                    if (!function_exists('rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                        }
                                    }
                                    ?>
                                    @foreach ($hasil as $index => $item)
                                        @if ($item->status == 'Kirim')
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card shadow-sm border-1 h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">#{{ $hasil->firstItem() + $index }} -
                                                            {{ $item->namaBank ?? '-' }}</h5>
                                                        <p class="mb-1"><strong>Tanggal Setor:</strong>
                                                            {{ \Carbon\Carbon::parse($item->created_at ?? '-')->format('d-m-Y') }}
                                                        </p>
                                                        <p class="mb-1"><strong>Rekening:</strong>
                                                            {{ $item->rekening ?? '-' }}</p>
                                                        <p class="mb-1"><strong>Nominal:</strong>
                                                            {{ Rupiah($item->nominal) }}</p>
                                                        <p class="mb-1"><strong>Jumlah:</strong>
                                                            {{ Rupiah($item->jumlah) }}</p>
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
                                                                    data-bs-toggle="modal" data-bs-target="#mediaModal"
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
                                                    </div>
                                                    <div class="card-footer bg-transparent border-0 text-end">
                                                        @if ($item->status == 'Kirim')
                                                            <span class="badge bg-success"><i
                                                                    class="fas fa-circle-check me-1"></i>
                                                                Terkirim</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark"><i
                                                                    class="fa-solid fa-hourglass-start me-1"></i>
                                                                Pending</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <!-- Modal untuk media (gambar/file) -->
                            <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog"
                                aria-labelledby="mediaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pratinjau Bukti Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body text-center" id="mediaContent">
                                            <!-- Konten dinamis -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                {{ $hasil->appends(['entries' => $entries])->links() }}
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
                                                <th rowspan="2">Nominal</th>
                                                <th rowspan="2">Jumlah</th>
                                                <th rowspan="2">Bukti Foto Transfer</th>
                                                <th>Status</th>
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
                                                            </td>
                                                            <td>{{ $item->rekening ?? '-' }}</td>
                                                            <td>{{ Rupiah($item->nominal) }}</td>
                                                            <td>{{ Rupiah($item->jumlah) }}</td>
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
                                                    <td class="fw-bold">{{ Rupiah($hasil->sum('nominal')) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="halaman d-flex justify-content-end mt-2">
                                        {{ $hasil->appends(['entries' => $entries])->links() }}
                                    </div>
                                </div> --}}
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
                            url: '{{ route('kolektor.setoran.getKelurahan') }}',
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
