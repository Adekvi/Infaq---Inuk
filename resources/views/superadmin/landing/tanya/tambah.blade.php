<x-utama.layout.main title="Superadmin | Pertanyaan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Tambah Pertanyaan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/tanya/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Pertanyaan</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Tag</label>
                                    <input type="text" name="tag" id="tag" class="form-control mt-2 mb-2"
                                        placeholder="Pertanyaan">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                        placeholder="Pertanyaan yang Sering Diajukan">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Temukan jawaban atas pertanyaan umum seputar layanan, transparansi, dan kemudahan berdonasi melalui INUK. Kami hadir untuk memastikan infaq Anda sampai dan berdampak."></textarea>
                                </div>
                                <h5>
                                    <strong>
                                        <li>Konten</li>
                                    </strong>
                                    <hr>
                                </h5>
                                <div class="col-md-6">
                                    <label for="">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto" class="mt-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Aktif" selected>Aktif</option>
                                            <option value="Nonaktif">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pertanyaan 1</label>
                                    <input type="text" name="pertanyaan1" id="pertanyaan1"
                                        class="form-control mt-2 mb-2" placeholder="Apa itu INUK?">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jawaban 1</label>
                                    <textarea name="jawaban1" id="jawaban1" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="INUK (Infaq untuk Umat dan Kesejahteraan) adalah program infaq yang dikelola oleh LAZISNU, berfokus pada penyaluran dana infaq secara amanah, transparan, dan berdampak bagi umat."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pertanyaan 2</label>
                                    <input type="text" name="pertanyaan2" id="pertanyaan2"
                                        class="form-control mt-2 mb-2"
                                        placeholder="Ke mana dana infaq saya disalurkan?">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jawaban 2</label>
                                    <textarea name="jawaban2" id="jawaban2" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Dana infaq disalurkan untuk program pendidikan, kesehatan, pemberdayaan ekonomi, bantuan bencana, dan santunan yatim dan dhuafa di berbagai wilayah."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pertanyaan 3</label>
                                    <input type="text" name="pertanyaan3" id="pertanyaan3"
                                        class="form-control mt-2 mb-2"
                                        placeholder="Apakah saya akan menerima laporan penggunaan infaq?">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jawaban 3</label>
                                    <textarea name="jawaban3" id="jawaban3" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Ya. Setiap donatur akan mendapatkan laporan bulanan dan dokumentasi penyaluran melalui email, WhatsApp, atau dapat dilihat langsung di situs resmi kami."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pertanyaan 4</label>
                                    <input type="text" name="pertanyaan4" id="pertanyaan4"
                                        class="form-control mt-2 mb-2"
                                        placeholder="Bagaimana cara berdonasi melalui INUK?">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jawaban 4</label>
                                    <textarea name="jawaban4" id="jawaban4" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Anda dapat berdonasi melalui transfer bank, QRIS, atau menggunakan form donasi online di website ini. Proses cepat, mudah, dan bisa dilakukan kapan saja."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pertanyaan 5</label>
                                    <input type="text" name="pertanyaan5" id="pertanyaan5"
                                        class="form-control mt-2 mb-2"
                                        placeholder="Apakah donasi saya bisa atas nama orang lain?">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jawaban 5</label>
                                    <textarea name="jawaban5" id="jawaban5" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Bisa. Anda dapat berdonasi atas nama pribadi, keluarga, almarhum, ataupun lembaga. Cukup cantumkan nama dalam keterangan saat pengisian form donasi."></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/landing/tanya') }}" class="btn btn-secondary mt-3 mr-2">
                                <i class="fa-solid fa-arrows-rotate"></i>
                                Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    @endpush

    @push('js')
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
                        alert('Ukuran foto maksimal 2 MB');
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
                        deleteBtn.className = 'btn btn-danger btn-sm d-block';
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

            handleImagePreview('foto', 'preview-foto');
        </script>
    @endpush

</x-utama.layout.main>
