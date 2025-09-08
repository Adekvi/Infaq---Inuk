<x-utama.layout.main title="Superadmin | Testimoni">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Testimoni</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/landing/testi/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div
                                class="page d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3 flex-wrap">
                                {{-- Form kiri: Tampilkan & Filter --}}
                                <form method="GET" action="{{ route('superadmin.landing.testi') }}"
                                    class="d-flex flex-wrap gap-3 align-items-end">
                                    <input type="hidden" name="page" value="1">

                                    {{-- Tampilkan --}}
                                    <div class="d-flex flex-column">
                                        <label for="entries" class="form-label mb-1">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>
                                                10</option>
                                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2 align-items-end">
                                        <div>
                                            <a href="{{ route('superadmin.landing.testi') }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                title="Reset Filter">
                                                <i class="bx bx-reset"></i> Reset
                                            </a>
                                        </div>
                                        {{-- <div class="d-flex flex-column">
                                            <label for="filter_year_start" class="form-label mb-1">Tahun Mulai</label>
                                            <select name="filter_year_start" id="filter_year_start"
                                                class="form-select form-select-sm" style="width: 120px;">
                                                <option value="">-- Tahun Mulai --</option>
                                                @for ($y = $minYear; $y <= $maxYear; $y++)
                                                    <option value="{{ $y }}"
                                                        {{ isset($filterYearStart) && $filterYearStart == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <label for="filter_year_end" class="form-label mb-1">Tahun Selesai</label>
                                            <select name="filter_year_end" id="filter_year_end"
                                                class="form-select form-select-sm" style="width: 120px;">
                                                <option value="">-- Tahun Selesai --</option>
                                                @for ($y = $minYear; $y <= $maxYear; $y++)
                                                    <option value="{{ $y }}"
                                                        {{ isset($filterYearEnd) && $filterYearEnd == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-toggle="tooltip" title="Filter Data">
                                                <i class="bx bxs-filter-alt"></i> Filter
                                            </button>
                                            <a href="{{ route('superadmin.landing.testi') }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                title="Reset Filter">
                                                <i class="bx bx-reset"></i> Reset
                                            </a>
                                        </div> --}}
                                    </div>
                                </form>

                                {{-- Form kanan: Search --}}
                                <form method="GET" action="{{ route('superadmin.landing.testi') }}"
                                    class="d-flex align-items-end gap-2 flex-wrap">
                                    <div class="d-flex flex-column">
                                        <label for="search" class="form-label mb-1">Cari</label>
                                        <input type="text" name="search" value="{{ $search }}" id="search"
                                            class="form-control form-control-sm" placeholder="Cari........">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1 invisible">Aksi</label>
                                        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                            title="Cari Data">
                                            <i class="bx bx-search-alt-2"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <hr>

                            <div class="row">
                                @if ($testi->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-secondary text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    @foreach ($testi as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card border-1 shadow-sm h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-2">
                                                        <div class="d-flex justify-content-between">
                                                            #{{ $testi->firstItem() + $index }}
                                                            {{-- <span>{{ $item->username }}</span> --}}
                                                            <form method="POST"
                                                                action="{{ url('superadmin/landing/testi-status') }}">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" id="status_{{ $item->id }}"
                                                                        name="status" value="Aktif"
                                                                        onchange="this.form.submit()"
                                                                        style="cursor: pointer"
                                                                        {{ $item->status === 'Aktif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="status_{{ $item->id }}">
                                                                        {{ $item->status === 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                                                                    </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </h6>
                                                    <hr>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 53px;"><strong>Tag</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->tag ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Judul</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->judul ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-start gap-2 mt-3">
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-info-circle' ></i> <span>Detail</span>">
                                                                <button type="button" class="btn btn-sm btn-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#detail{{ $item->id }}">
                                                                    <i class="bx bxs-info-circle"></i> Detail
                                                                </button>
                                                            </span>
                                                            <a href="{{ url('superadmin/landing/testi/edit-data/' . $item->id) }}"
                                                                class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hapus{{ $item->id }}">
                                                                <i class="bx bxs-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Pagination --}}
                                    <div class="col-12 mt-3 d-flex justify-content-end">
                                        {{ $testi->appends(['entries' => $entries])->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.landing.testi.modal.detail')
    @include('superadmin.landing.testi.hapus')

    @push('css')
        <style>
            .status-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                font-family: 'Segoe UI', sans-serif;
            }

            /* Hide the default checkbox */
            .status-wrapper input[type="checkbox"] {
                display: none;
            }

            /* Custom switch style */
            .status-button {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 26px;
                background-color: #ccc;
                border-radius: 50px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .status-button::after {
                content: "";
                position: absolute;
                top: 3px;
                left: 3px;
                width: 20px;
                height: 20px;
                background-color: white;
                border-radius: 50%;
                transition: transform 0.3s;
            }

            /* Checked state */
            .status-wrapper input[type="checkbox"]:checked+.status-button {
                background-color: #696cff;
            }

            .status-wrapper input[type="checkbox"]:checked+.status-button::after {
                transform: translateX(24px);
            }

            .status-text span {
                font-size: 14px;
                font-weight: 500;
                color: #333;
            }
        </style>
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
