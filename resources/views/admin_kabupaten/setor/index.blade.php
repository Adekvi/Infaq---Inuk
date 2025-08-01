<x-utama.layout.main title="Admin Kabupaten | Nottifikasi">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Notifikasi Setoran Infaq</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="page mb-3">
                                <h6>
                                    <li><strong>Sortir Data</strong></li>
                                </h6>
                                <hr>
                                <div class="row g-3 align-items-end justify-content-between">
                                    {{-- Filter Wilayah --}}
                                    <div class="col-lg-9">
                                        <form method="GET" action="{{ route('admin_kabupaten.data-setor') }}"
                                            class="row gx-2 gy-2 align-items-end" id="filterForm">
                                            <input type="hidden" name="page" value="1">

                                            <div class="col-md-auto">
                                                <label for="entries" class="form-label">Tampilkan:</label>
                                                <select name="entries" id="entries" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="10"
                                                        {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                                                    <option value="25"
                                                        {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                                                    <option value="50"
                                                        {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100"
                                                        {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                                                </select>
                                            </div>

                                            <div class="col-md-auto">
                                                <label for="kecamatan" class="form-label">Kecamatan:</label>
                                                <select name="kecamatan" id="kecamatan"
                                                    class="form-select form-select-sm">
                                                    <option value="">-- Pilih Kecamatan --</option>
                                                    @foreach ($kecamatans as $kec)
                                                        <option value="{{ $kec->nama_kecamatan }}"
                                                            {{ request('kecamatan') == $kec->nama_kecamatan ? 'selected' : '' }}>
                                                            {{ $kec->nama_kecamatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-auto d-flex gap-2 align-items-end">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="tooltip" title="Filter">
                                                    <i class="bx bxs-filter-alt"></i>
                                                </button>
                                                <a href="{{ route('admin_kabupaten.data-setor') }}"
                                                    class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                    title="Reset">
                                                    <i class='bx bx-reset'></i>
                                                </a>
                                                <button type="submit" name="show_all"
                                                    value="{{ $showAll ? '0' : '1' }}" class="btn btn-sm btn-info"
                                                    data-bs-toggle="tooltip" title="Semua Data">
                                                    <i class="fas fa-file-lines"></i>
                                                    {{ $showAll ? 'Hari Ini' : 'Semua' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Pencarian --}}
                                    <div class="col-lg-3">
                                        <form method="GET" action="{{ route('admin_kabupaten.data-setor') }}"
                                            class="d-flex align-items-end gap-2">
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm" placeholder="Cari...">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-toggle="tooltip" title="Cari">
                                                <i class='bx bx-search-alt-2'></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if ($setor->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    <?php
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                        }
                                    }
                                    ?>
                                    @foreach ($setor as $index => $item)
                                        @if ($item->status == 'Terkirim')
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card shadow-sm border-1 h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-primary">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="no">
                                                                    #{{ ($setor->currentPage() - 1) * $setor->perPage() + $index + 1 }}
                                                                    - <i class="fas fa-user"></i>
                                                                </div>
                                                                <div class="text-end">
                                                                    @if ($item->status == 'Terkirim')
                                                                        <form
                                                                            action="{{ route('admin_kecamatan.updateStatus') }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            <input type="hidden" name="id"
                                                                                value="{{ $item->id }}">
                                                                            <input type="hidden" name="status"
                                                                                value="Validasi">
                                                                            <button type="submit"
                                                                                class="badge bg-warning border-0"
                                                                                style="cursor:pointer;">
                                                                                <i
                                                                                    class="fa-solid fa-hourglass-start"></i>
                                                                                Validasi
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <span class="badge bg-success">
                                                                            <i class="fas fa-check-circle"></i>
                                                                            Verifikasi
                                                                        </span>
                                                                    @endif
                                                                    <span class="badge bg-success" id="verifikasiBadge">
                                                                        <i class="fas fa-check-circle"></i> Verifikasi
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </h6>
                                                        <hr>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 120px;"><strong>Total Donasi</strong>
                                                            </div>
                                                            <span class="me-1">:</span>
                                                            <div>
                                                                <strong>{{ Rupiah($total_donasi_kecamatan ?? '-') }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 120px;"><strong>Nama Pengirim</strong>
                                                            </div>
                                                            <span class="me-1">:</span>
                                                            <div>{{ $item->user->username ?? '-' }}</div>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 120px;"><strong>Kecamatan</strong></div>
                                                            <span class="me-1">:</span>
                                                            <div>{{ $item->nama_kecamatan ?? '-' }}</div>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <div style="width: 120px;"><strong>Tanggal Setor</strong>
                                                            </div>
                                                            <span class="me-1">:</span>
                                                            <div>
                                                                {{ \Carbon\Carbon::parse($item->tglKirim ?? '-')->format('d-m-Y') }}
                                                            </div>
                                                        </div>

                                                        <div class="text-end mt-4" style="font-size: 10px">
                                                            <i class="fa-solid fa-lock"></i>
                                                            <i class="fab fa-whatsapp"
                                                                style="color: #25D366; font-size: 12px;"></i>
                                                            {{ $noHp ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <!-- Modal untuk preview media -->
                            <div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pratinjau Bukti Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body text-center" id="mediaContent"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end mt-3">
                                {{ $setor->appends([
                                        'entries' => $entries,
                                        'show_all' => $showAll,
                                    ])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('admin_kecamatan.rekap.modal.detail') --}}

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.view-media').forEach(button => {
                button.addEventListener('click', function() {
                    const src = this.getAttribute('data-src');
                    const type = this.getAttribute('data-type');
                    const content = type === 'image' ?
                        `<img src="${src}" class="img-fluid" alt="Bukti Transfer">` :
                        `<a href="${src}" target="_blank">Lihat File</a>`;

                    document.getElementById('mediaContent').innerHTML = content;
                });
            });
        </script>
    @endpush
</x-utama.layout.main>
