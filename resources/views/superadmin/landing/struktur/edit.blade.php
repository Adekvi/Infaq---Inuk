<x-utama.layout.main title="Superadmin | Edit Struktur Pengurus">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Edit Struktur Pengurus</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data Pengurus</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/struktur-pengurus/edit/' . $struktur->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row p-3">
                                <h5 class="mb-2">
                                    <li>Judul Landing</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tag">Tag</label>
                                        <input type="text" name="tag" id="tag"
                                            class="form-control mt-2 mb-2 @error('tag') is-invalid @enderror"
                                            value="{{ old('tag', $struktur->tag) }}" placeholder="Susunan Pengurus">
                                        @error('tag')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" name="judul" id="judul"
                                            class="form-control mt-2 mb-2 @error('judul') is-invalid @enderror"
                                            value="{{ old('judul', $struktur->judul) }}"
                                            placeholder="Kenali Sosok di Balik INUK">
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kalimat">Ringkasan</label>
                                        <textarea name="kalimat" id="kalimat" class="form-control mt-2 mb-2 @error('kalimat') is-invalid @enderror"
                                            cols="10" rows="5" placeholder="Tim INUK terdiri dari pengurus profesional...">{{ old('kalimat', $struktur->kalimat) }}</textarea>
                                        @error('kalimat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Keterangan</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" name="logo" id="logo"
                                            class="form-control mt-2 mb-2" accept="image/*">
                                        <div id="preview-logo" class="mt-2">
                                            @if ($struktur->logo)
                                                <img src="{{ asset('storage/' . $struktur->logo) }}"
                                                    style="max-width: 100%; max-height: 200px;" class="mb-2">
                                                <button type="button" class="btn btn-danger btn-sm d-block mb-2"
                                                    onclick="document.getElementById('preview-logo').innerHTML = ''; document.getElementById('logo').value = '';">
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Sub Judul</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="subjudul"
                                            id="subjudul" value="{{ $struktur->subjudul ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="alamat"
                                            id="alamat" value="{{ $struktur->alamat ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. Telepon</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="no_telpon"
                                            id="no_telpon" value="{{ $struktur->no_telpon ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control mt-2 mb-2" name="email"
                                            id="email" value="{{ $stuktur->no_telepon ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alamat WEB</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="alamatweb"
                                            id="alamatweb" value="{{ $stuktur->alamatweb ?? '-' }}">
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Lampiran Surat Keputusan</li>
                                </h5>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Judul</label>
                                        <input type="text" name="judulsk" id="judulsk"
                                            class="form-control mt-2 mb-2" value="{{ $struktur->judulsk ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor">Nomor</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('nomor') is-invalid @enderror"
                                            name="nomor" id="nomor"
                                            value="{{ old('nomor', $struktur->nomor) }}">
                                        @error('nomor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="masehiDate">Tanggal (Masehi)</label>
                                        <div class="input-group">
                                            <input type="date" id="masehiDate" name="tanggal"
                                                class="form-control mt-2 mb-2 @error('tanggal') is-invalid @enderror"
                                                value="{{ old('tanggal', $struktur->tanggal) }}">
                                        </div>
                                        @error('tanggal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Hasil Konversi (Hijriyah):</label>
                                        <p id="convertedDate" class="fw-bold">
                                            {{ $struktur->tanggal ? \Carbon\Carbon::parse($struktur->tanggal)->format('d F Y') : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tentang</label>
                                        <input type="text" name="tentang" id="tentang"
                                            class="form-control mt-2 mb-2" value="{{ $struktur->tentang ?? '-' }}">
                                    </div>
                                </div>

                                @php
                                    $selectedStartYear = $struktur->start_date
                                        ? \Carbon\Carbon::parse($struktur->start_date)->year
                                        : '';
                                    $selectedEndYear = $struktur->end_date
                                        ? \Carbon\Carbon::parse($struktur->end_date)->year
                                        : '';
                                @endphp

                                <h5 class="mt-3 mb-2">
                                    <li>Masa Khidmat Pengurus</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Masa Khidmat (Tahun Mulai)</label>
                                        <select name="start_date" id="start_date" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($year = $minYear; $year <= $maxYear; $year++)
                                                <option value="{{ $year }}"
                                                    {{ old('start_date', $selectedStartYear) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Tahun (Tahun Selesai)</label>
                                        <select name="end_date" id="end_date" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($year = $minYear + 5; $year <= $maxYear + 5; $year++)
                                                <option value="{{ $year }}"
                                                    {{ old('end_date', $selectedEndYear) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pengurus">Judul Pengurus</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('pengurus') is-invalid @enderror"
                                            name="pengurus" id="pengurus"
                                            value="{{ old('pengurus', $struktur->pengurus) }}">
                                        @error('pengurus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judulpengurus">Keterangan</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('judulpengurus') is-invalid @enderror"
                                            name="judulpengurus" id="judulpengurus"
                                            value="{{ old('judulpengurus', $struktur->judulpengurus) }}">
                                        @error('judulpengurus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('kabupaten') is-invalid @enderror"
                                            name="kabupaten" id="kabupaten"
                                            value="{{ old('kabupaten', $struktur->kabupaten) }}">
                                        @error('kabupaten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="masapengurus">Masa Khidmat Pengurus</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('masapengurus') is-invalid @enderror"
                                            name="masapengurus" id="masapengurus"
                                            value="{{ old('masapengurus', $struktur->masapengurus) }}">
                                        @error('masapengurus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Pengurus</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ketua">Ketua</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('ketua') is-invalid @enderror"
                                            name="ketua" id="ketua"
                                            value="{{ old('ketua', $struktur->ketua) }}">
                                        @error('ketua')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wakilketua1">Wakil Ketua 1</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua1') is-invalid @enderror"
                                            name="wakilketua1" id="wakilketua1"
                                            value="{{ old('wakilketua1', $struktur->wakilketua1) }}">
                                        @error('wakilketua1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wakilketua2">Wakil Ketua 2</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua2') is-invalid @enderror"
                                            name="wakilketua2" id="wakilketua2"
                                            value="{{ old('wakilketua2', $struktur->wakilketua2) }}">
                                        @error('wakilketua2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wakilketua3">Wakil Ketua 3</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua3') is-invalid @enderror"
                                            name="wakilketua3" id="wakilketua3"
                                            value="{{ old('wakilketua3', $struktur->wakilketua3) }}">
                                        @error('wakilketua3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sekretaris">Sekretaris</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('sekretaris') is-invalid @enderror"
                                            name="sekretaris" id="sekretaris"
                                            value="{{ old('sekretaris', $struktur->sekretaris) }}">
                                        @error('sekretaris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wakilsekretaris">Wakil Sekretaris</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilsekretaris') is-invalid @enderror"
                                            name="wakilsekretaris" id="wakilsekretaris"
                                            value="{{ old('wakilsekretaris', $struktur->wakilsekretaris) }}">
                                        @error('wakilsekretaris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bendahara">Bendahara</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('bendahara') is-invalid @enderror"
                                            name="bendahara" id="bendahara"
                                            value="{{ old('bendahara', $struktur->bendahara) }}">
                                        @error('bendahara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wakilbendahara">Wakil Bendahara</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilbendahara') is-invalid @enderror"
                                            name="wakilbendahara" id="wakilbendahara"
                                            value="{{ old('wakilbendahara', $struktur->wakilbendahara) }}">
                                        @error('wakilbendahara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-2">
                                    <li>Bidang-bidang :</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group penghimpunan-group">
                                        <label>Divisi Penghimpunan</label>
                                        @foreach ($struktur->penghimpunan as $item)
                                            <div class="input-group mt-2 mb-2">
                                                <input type="text" class="form-control" name="penghimpunan[]"
                                                    value="{{ old('penghimpunan.' . $loop->index, $item) }}">
                                                <button type="button" class="btn btn-danger remove-btn">-</button>
                                            </div>
                                        @endforeach
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="penghimpunan[]">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".penghimpunan-group">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pendistribusian-group">
                                        <label>Divisi Pendistribusian</label>
                                        @foreach ($struktur->pendistribusian as $item)
                                            <div class="input-group mt-2 mb-2">
                                                <input type="text" class="form-control" name="pendistribusian[]"
                                                    value="{{ old('pendistribusian.' . $loop->index, $item) }}">
                                                <button type="button" class="btn btn-danger remove-btn">-</button>
                                            </div>
                                        @endforeach
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="pendistribusian[]">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".pendistribusian-group">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group keuangan-group">
                                        <label>Divisi Keuangan & Pelaporan</label>
                                        @foreach ($struktur->keuangan as $item)
                                            <div class="input-group mt-2 mb-2">
                                                <input type="text" class="form-control" name="keuangan[]"
                                                    value="{{ old('keuangan.' . $loop->index, $item) }}">
                                                <button type="button" class="btn btn-danger remove-btn">-</button>
                                            </div>
                                        @endforeach
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="keuangan[]">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".keuangan-group">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group humas-group">
                                        <label>Divisi Humas & Publikasi</label>
                                        @foreach ($struktur->humas as $item)
                                            <div class="input-group mt-2 mb-2">
                                                <input type="text" class="form-control" name="humas[]"
                                                    value="{{ old('humas.' . $loop->index, $item) }}">
                                                <button type="button" class="btn btn-danger remove-btn">-</button>
                                            </div>
                                        @endforeach
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="humas[]">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".humas-group">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save
                            </button>
                            <a href="{{ url('superadmin/landing/struktur-pengurus') }}"
                                class="btn btn-secondary mt-3 mr-2">
                                <i class="fa-solid fa-arrows-rotate"></i> Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    @endpush

    @push('js')
        <!-- jQuery (jika belum ada) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- jQuery UI Datepicker -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <!-- Moment Hijri -->
        <script src="https://cdn.jsdelivr.net/npm/moment-hijri@2.1.2/moment-hijri.min.js"></script>

        <!-- Bahasa Indonesia untuk moment.js -->
        <script src="https://cdn.jsdelivr.net/npm/moment/locale/id.js"></script>

        <script>
            // LOGO
            function handleImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function() {
                    const file = this.files[0];

                    // Clear previous preview
                    preview.innerHTML = '';

                    if (!file) return;

                    // Check file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran Logo maksimal 2 MB');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const image = document.createElement('img');
                        image.src = e.target.result;
                        image.style.maxWidth = '100%';
                        image.style.maxHeight = '200px';
                        image.classList.add('mb-2');

                        const deleteBtn = document.createElement('button');
                        deleteBtn.textContent = 'Hapus';
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'btn btn-danger btn-sm d-block mb-2';
                        deleteBtn.onclick = function() {
                            input.value = '';
                            preview.innerHTML = '';
                        };

                        preview.appendChild(image);
                        preview.appendChild(deleteBtn);
                    };

                    reader.readAsDataURL(file);
                });
            }

            handleImagePreview('logo', 'preview-logo');

            // MASA JABATAN
            document.addEventListener('DOMContentLoaded', function() {
                const startYearSelect = document.getElementById('start_date');
                const endYearSelect = document.getElementById('end_date');

                const manajemenStartYearSelect = document.getElementById('manajemen_start_date');
                const manajemenEndYearSelect = document.getElementById('manajemen_end_date');

                function updateEndYear(startSelect, endSelect) {
                    const startYear = parseInt(startSelect.value);
                    if (!isNaN(startYear)) {
                        const newEndYear = startYear + 5;

                        // Jika opsi baru belum ada, tambahkan
                        let optionExists = Array.from(endSelect.options).some(opt => parseInt(opt.value) ===
                            newEndYear);
                        if (!optionExists) {
                            const newOption = document.createElement('option');
                            newOption.value = newEndYear;
                            newOption.text = newEndYear;
                            endSelect.appendChild(newOption);
                        }
                        // Set nilai end_year otomatis
                        endSelect.value = newEndYear;
                    }
                }

                startYearSelect.addEventListener('change', function() {
                    updateEndYear(startYearSelect, endYearSelect);
                });

                manajemenStartYearSelect.addEventListener('change', function() {
                    updateEndYear(manajemenStartYearSelect, manajemenEndYearSelect);
                });

                // Jalankan sekali saat load halaman, tapi jangan overwrite jika user sudah memilih end_date
                if (!endYearSelect.value) {
                    updateEndYear(startYearSelect, endYearSelect);
                }
                if (!manajemenEndYearSelect.value) {
                    updateEndYear(manajemenStartYearSelect, manajemenEndYearSelect);
                }
            });


            // BIDANG-BIDANG
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.add-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const targetGroup = document.querySelector(btn.getAttribute('data-target'));

                        // Buat elemen input baru dengan input-group
                        const newInputGroup = document.createElement('div');
                        newInputGroup.classList.add('input-group', 'mt-2', 'mb-2');
                        newInputGroup.innerHTML = `
                            <input type="text" class="form-control" 
                                name="${targetGroup.querySelector('input').name}" 
                                placeholder="Nama Lengkap dan Gelar">
                            <button type="button" class="btn btn-danger remove-btn">-</button>
                        `;

                        // Tambahkan ke divisi yang dipilih
                        targetGroup.appendChild(newInputGroup);

                        // Event hapus baris
                        newInputGroup.querySelector('.remove-btn').addEventListener('click',
                            function() {
                                newInputGroup.remove();
                            });
                    });
                });

                // Event hapus untuk input yang sudah ada
                document.querySelectorAll('.remove-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        btn.parentElement.remove();
                    });
                });
            });

            // TANGGAL MASEHI DAN HIJRIYAH
            const bulanHijriyah = {
                "Muharram": "Muharram",
                "Safar": "Safar",
                "Rabi al-awwal": "Rabiul Awal",
                "Rabi al-thani": "Rabiul Akhir",
                "Jumada al-awwal": "Jumadil Awal",
                "Jumada al-thani": "Jumadil Akhir",
                "Rajab": "Rajab",
                "Shaʿban": "Sya'ban",
                "Ramadan": "Ramadhan",
                "Shawwal": "Syawal",
                "Thul-Qi'dah": "Dzul Qo'dah",
                "Thul-Hijjah": "Dzul Hijjah"
            };

            document.getElementById('masehiDate').addEventListener('change', function() {
                const masehiDate = this.value;

                if (masehiDate) {
                    const hijriMoment = moment(masehiDate, 'YYYY-MM-DD');
                    const day = hijriMoment.format('iD');
                    const monthEnglish = hijriMoment.format('iMMMM');
                    const year = hijriMoment.format('iYYYY');

                    const monthIndonesia = bulanHijriyah[monthEnglish] || monthEnglish;
                    const fullHijriDate = `${day} ${monthIndonesia} ${year} H`;

                    document.getElementById('convertedDate').innerText = fullHijriDate;
                }
            });

            // Trigger initial Hijriyah conversion if date exists
            @if ($struktur->tanggal)
                const initialDate = "{{ $struktur->tanggal }}";
                if (initialDate) {
                    const hijriMoment = moment(initialDate, 'YYYY-MM-DD');
                    const day = hijriMoment.format('iD');
                    const monthEnglish = hijriMoment.format('iMMMM');
                    const year = hijriMoment.format('iYYYY');
                    const monthIndonesia = bulanHijriyah[monthEnglish] || monthEnglish;
                    document.getElementById('convertedDate').innerText = `${day} ${monthIndonesia} ${year} H`;
                }
            @endif
        </script>
    @endpush
</x-utama.layout.main>
