<x-utama.layout.main title="Superadmin | Struktur Pengurus">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Tambah Struktur Pengurus</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Pengurus</code>
                    </div>
                </div>
                <form action="{{ url('superadmin/landing/struktur-pengurus/tambah') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Judul Landing</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tag</label>
                                        <input type="text" name="tag" id="tag"
                                            class="form-control mt-2 mb-2" placeholder="Susunan Pengurus">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Judul</label>
                                        <input type="text" name="judul" id="judul"
                                            class="form-control mt-2 mb-2" placeholder="Kenali Sosok di Balik INUK">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Ringkasan</label>
                                        <textarea name="kalimat" id="kalimat" class="form-control mt-2 mb-2" cols="10" rows="5"
                                            placeholder="Tim INUK terdiri dari pengurus profesional dan relawan yang berkomitmen tinggi dalam mengelola dan menyalurkan infaq secara amanah, transparan, dan tepat sasaran."></textarea>
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
                                        <div id="preview-logo" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Sub Judul</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="subjudul"
                                            id="subjudul"
                                            placeholder="PENGURUS CABANG NAHDLATUL ULAMA KABUPATEN KUDUS">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="alamat"
                                            id="alamat" placeholder="Jl. Pramuka No. 20 Wergu Wetan Kota Kudus">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. Telepon</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="no_telpon"
                                            id="no_telpon" placeholder="0291 430201 - 439448">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control mt-2 mb-2" name="email"
                                            id="email" placeholder="pcnukudusjateng@gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alamat WEB</label>
                                        <input type="text" class="form-control mt-2 mb-2" name="alamatweb"
                                            id="alamatweb" placeholder="www.nukudus.or.id">
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Lampiran Surat Keputusan</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Judul</label>
                                        <input type="text" name="judulsk" id="judulsk"
                                            class="form-control mt-2 mb-2"
                                            placeholder="Lampiran SK Pengurus Cabang Nahdlatul Ulama Kudus">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor">Nomor</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('nomor') is-invalid @enderror"
                                            name="nomor" id="nomor" placeholder="0102/PC.H.07/SK/III/2025"
                                            value="{{ old('nomor') }}">
                                        @error('nomor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="masehiDate">Tanggal (Masehi)</label>
                                        <div class="input-group">
                                            <input type="date" id="masehiDate" class="form-control mt-2 mb-2"
                                                placeholder="Pilih tanggal Masehi">
                                        </div>
                                        @error('tanggal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Hasil Konversi (Hijriyah):</label>
                                        <p id="convertedDate" class="fw-bold"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tentang</label>
                                        <input type="text" name="tentang" id="tentang"
                                            class="form-control mt-2 mb-2" placeholder="-">
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Masa Khidmat Pengurus</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_year">Masa Khidmat (Tahun Mulai)</label>
                                        <select name="start_year" id="start_year" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($year = $startYearRange; $year <= $endYearRange; $year++)
                                                <option value="{{ $year }}"
                                                    {{ old('start_year', $selectedStartYear) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_year">Tahun (Tahun Selesai)</label>
                                        <select name="end_year" id="end_year" class="form-control mt-2 mb-2"
                                            disabled>
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($year = $startYearRange + 5; $year <= $endYearRange + 5; $year++)
                                                <option value="{{ $year }}"
                                                    {{ old('end_year', $selectedEndYear) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Judul Pengurus</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('pengurus') is-invalid @enderror"
                                            name="pengurus" id="pengurus" placeholder="SUSUNAN PENGURUS">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('judulpengurus') is-invalid @enderror"
                                            name="judulpengurus" id="judulpengurus"
                                            placeholder="LEMBAGA AMIL ZAKAT, INFAQ DAN SHADAQAH NAHDLATUL ULAMA (LAZISNU)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kabupaten</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('kabupaten') is-invalid @enderror"
                                            name="kabupaten" id="kabupaten" placeholder="PCNU KABUPATEN KUDUS">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Masa Khidmat Pengurus</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('masapengurus') is-invalid @enderror"
                                            name="masapengurus" id="masapengurus"
                                            placeholder="MASA KHIDMAT 2024 - 2029 M.">
                                    </div>
                                </div>

                                <h5 class="mt-3 mb-2">
                                    <li>Pengurus</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Ketua</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('ketua') is-invalid @enderror"
                                            name="ketua" id="ketua" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Wakil Ketua 1</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua1') is-invalid @enderror"
                                            name="wakilketua1" id="wakilketua1" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Wakil Ketua 2</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua2') is-invalid @enderror"
                                            name="wakilketua2" id="wakilketua2" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Wakil Ketua 3</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilketua3') is-invalid @enderror"
                                            name="wakilketua3" id="wakilketua3" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Sekretaris</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('sekretaris') is-invalid @enderror"
                                            name="sekretaris" id="sekretaris" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Wakil Sekretaris</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilsekretaris') is-invalid @enderror"
                                            name="wakilsekretaris" id="wakilsekretaris"
                                            placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Bendahara</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('bendahara') is-invalid @enderror"
                                            name="bendahara" id="bendahara" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Wakil Bendahara</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('wakilbendahara') is-invalid @enderror"
                                            name="wakilbendahara" id="wakilbendahara"
                                            placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-2">
                                    <li>Bidang-bidang :</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group penghimpunan-group">
                                        <label>Divisi Penghimpunan</label>
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="penghimpunan[]"
                                                placeholder="Nama Lengkap dan Gelar">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".penghimpunan-group">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group pendistribusian-group">
                                        <label>Divisi Pendistribusian</label>
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="pendistribusian[]"
                                                placeholder="Nama Lengkap dan Gelar">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".pendistribusian-group">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group keuangan-group">
                                        <label>Divisi Keuangan & Pelaporan</label>
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="keuangan[]"
                                                placeholder="Nama Lengkap dan Gelar">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".keuangan-group">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group humas-group">
                                        <label>Divisi Humas & Publikasi</label>
                                        <div class="input-group mt-2 mb-2">
                                            <input type="text" class="form-control" name="humas[]"
                                                placeholder="Nama Lengkap dan Gelar">
                                            <button type="button" class="btn btn-success add-btn"
                                                data-target=".humas-group">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/landing/struktur-pengurus') }}"
                                class="btn btn-secondary mt-3 mr-2">
                                <i class="fa-solid fa-arrows-rotate"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </form>
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

            // MASA KHIDMAT PENGURUS
            function setupYearSelector(startId, endId, offset = 5) {
                const startSelect = document.getElementById(startId);
                const endSelect = document.getElementById(endId);

                function updateEndYear() {
                    const startYear = parseInt(startSelect.value);
                    if (!isNaN(startYear)) {
                        const endYear = startYear + offset;

                        // Reset opsi endSelect kecuali placeholder
                        endSelect.innerHTML = '<option value="">-- Pilih Tahun --</option>';

                        // Tambah opsi endYear yang sudah dihitung
                        const option = document.createElement('option');
                        option.value = endYear;
                        option.text = endYear;
                        option.selected = true;
                        endSelect.appendChild(option);

                        endSelect.disabled = false;
                    } else {
                        endSelect.innerHTML = '<option value="">-- Pilih Tahun --</option>';
                        endSelect.disabled = true;
                    }
                }

                startSelect.addEventListener('change', updateEndYear);

                // Set initial value saat load page
                window.addEventListener('DOMContentLoaded', () => {
                    updateEndYear();
                });
            }

            // Pasang untuk kedua pasangan start/end year
            setupYearSelector('start_year', 'end_year', 5);

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
                "Thul-Qi'dah": "Dzul Qo'dah", // Diperbarui sesuai output moment-hijri
                "Thul-Hijjah": "Dzul Hijjah" // Diperbarui sesuai output moment-hijri
            };

            document.getElementById('masehiDate').addEventListener('change', function() {
                const masehiDate = this.value;

                if (masehiDate) {
                    const hijriMoment = moment(masehiDate, 'YYYY-MM-DD');
                    const day = hijriMoment.format('iD');
                    const monthEnglish = hijriMoment.format('iMMMM');
                    const year = hijriMoment.format('iYYYY');

                    // Debugging: Log nama bulan untuk memastikan
                    console.log('Bulan dari moment-hijri:', monthEnglish);

                    const monthIndonesia = bulanHijriyah[monthEnglish] || monthEnglish;

                    const fullHijriDate = `${day} ${monthIndonesia} ${year} H`;

                    document.getElementById('convertedDate').innerText = fullHijriDate;
                }
            });

            // Trigger input when calendar icon clicked
            document.getElementById('calendarTrigger').addEventListener('click', function() {
                document.getElementById('masehiDate').showPicker?.();
            });
        </script>
    @endpush

</x-utama.layout.main>
