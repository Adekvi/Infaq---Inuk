<x-utama.layout.main title="Kolektor | Pengiriman Data Infaq">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Pengiriman Data Infaq</strong></h5>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        <li><strong>Detail Pengiriman Infaq</strong></li>
                                    </h5>
                                    <hr>
                                </div>
                                <div class="page mb-3">
                                    <div class="row g-2 align-items-end justify-content-between flex-wrap">
                                        <div class="col-xl-auto col-lg-12">
                                            <form method="GET" action="{{ route('kolektor.pengiriman.index') }}"
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
                                                    <a href="{{ route('kolektor.pengiriman.index') }}"
                                                        class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                        title="Reset Filter">
                                                        <i class='bx bx-reset'></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Pencarian -->
                                        <div class="col-xl-auto col-lg-12 mt-2 mt-xl-0">
                                            <form method="GET" action="{{ route('kolektor.pengiriman.index') }}"
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
                                    <!-- Form Kirim Batch -->
                                    <form id="kirimForm" action="{{ url('kolektor/pengiriman/index-infaq') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <table class="table table-bordered table-striped text-center">
                                            <thead class="table-primary align-middle">
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Pilih Data <br>
                                                        <input type="checkbox" id="checkAll">
                                                    </th>
                                                    <th colspan="3">Wilayah Infaq</th>
                                                    <th rowspan="2">Nominal</th>
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
                                                @if ($kirim->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @else
                                                    @foreach ($kirim as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                @if ($item->status == 'Pending')
                                                                    <input type="checkbox" name="id_penerimaan[]"
                                                                        value="{{ $item->id }}"
                                                                        class="checkItem">
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->plotting->kelurahan->first()->nama_kelurahan ?? '-' }}
                                                            </td>
                                                            <td>{{ $item->Rt }}</td>
                                                            <td>{{ $item->Rw }}</td>
                                                            <td>{{ Rupiah($item->nominal) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5" class="text-center fw-bold">Jumlah Total
                                                        </td>
                                                        <td class="fw-bold">{{ Rupiah($kirim->sum('nominal')) }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <p class="fw-bold text-warning mb-2 mt-2" style="font-style: italic">
                                            *Silahkan centang ✔ salah
                                            satu atau semua data yang ingin di kirim di kolom Pilih</p>
                                        @if ($kirim->where('status', 'Pending')->count() > 0)
                                            <button type="button" class="btn btn-primary mt-3"
                                                data-bs-toggle="modal" data-bs-target="#kirimModal">
                                                <i class="fa-solid fa-paper-plane"></i> Kirim Data Terpilih
                                            </button>
                                        @endif

                                        @include('kolektor.transaksi.pengiriman.modal.kirim')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                    updateTotalNominal();
                });

                // Update total nominal when checkbox changes
                $('.checkItem').on('change', updateTotalNominal);

                function updateTotalNominal() {
                    const selected = $('.checkItem:checked').map(function() {
                        const row = $(this).closest('tr');
                        const nominal = row.find('td').eq(5).text(); // Kolom nominal (indeks 5)
                        return parseFloat(nominal.replace(/[^0-9]/g, '')) ||
                            0; // Hapus format Rupiah dan konversi ke number
                    }).get();

                    // Hitung total nominal
                    const totalNominal = selected.reduce((sum, nominal) => sum + nominal, 0);

                    // Format total ke Rupiah
                    const formattedTotal = 'Rp ' + totalNominal.toLocaleString('id-ID');

                    // Update total di tabel
                    $('#totalNominal').text(formattedTotal);

                    // Update total di modal
                    $('#selectedItems').html(formattedTotal);
                }

                // Prevent modal if no items selected
                $('[data-bs-target="#kirimModal"]').on('click', function(e) {
                    if ($('.checkItem:checked').length === 0) {
                        e.preventDefault();
                        alert('Pilih setidaknya satu setoran untuk dikirim.');
                    } else {
                        updateSelectedItems(); // Pastikan daftar diperbarui saat modal dibuka
                    }
                });

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
