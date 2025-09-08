<x-utama.layout.main title="Superadmin | Program Kami">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Tambah Program Kami</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/program-kami/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Progarm Kami</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Tag</label>
                                    <input type="text" name="tag" id="tag" class="form-control mt-2 mb-2"
                                        placeholder="Program Kami">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                        placeholder="Program Unggulan INUK - LAZISNU">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="ringkasan" id="ringkasan" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="INUK (Infaq untuk Umat dan Kesejahteraan) adalah program unggulan dari LAZISNU yang hadir untuk menjembatani kebaikan Anda kepada mereka yang membutuhkan. Dengan semangat gotong royong dan kepedulian, kami mendorong masyarakat untuk berinfaq secara mudah, transparan, dan berdampak nyata."></textarea>
                                </div>
                                <h5 class="mt-2">
                                    <strong>
                                        <li>Konten</li>
                                    </strong>
                                    <hr>
                                </h5>
                                <div class="col-md-6">
                                    <label for="">Program 1</label>
                                    <input type="text" name="program1" id="program1" class="form-control mt-2 mb-2"
                                        placeholder="INUK">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 1</label>
                                    <input type="file" name="foto1" id="foto1" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto1" class="mt-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 1</label>
                                    <textarea name="ringkasan1" id="ringkasan1" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Program donasi infaq yang dikelola oleh NU Kudus untuk mendukung pendidikan, kesehatan, dan kegiatan sosial keumatan."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Program 2</label>
                                    <input type="text" name="program2" id="program2" class="form-control mt-2 mb-2"
                                        placeholder="Mobil Layanan Ummat (MLU)">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 2</label>
                                    <input type="file" name="foto2" id="foto2" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto2" class="mt-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 2</label>
                                    <textarea name="ringkasan2" id="ringkasan2" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Layanan mobil gratis untuk masyarakat yang membutuhkan, mulai dari kesehatan, edukasi, hingga bantuan darurat langsung ke lokasi."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Program 3</label>
                                    <input type="text" name="program3" id="program3" class="form-control mt-2 mb-2"
                                        placeholder="Qurban">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 3</label>
                                    <input type="file" name="foto3" id="foto3" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto3" class="mt-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 3</label>
                                    <textarea name="ringkasan3" id="ringkasan3" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Program Qurban terpercaya yang amanah dan profesional, menyebarkan kebahagiaan hingga pelosok desa yang membutuhkan."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Program 4</label>
                                    <input type="text" name="program4" id="program4"
                                        class="form-control mt-2 mb-2" placeholder="Santunan">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 4</label>
                                    <input type="file" name="foto4" id="foto4"
                                        class="form-control mt-2 mb-2" accept="image/*">
                                    <div id="preview-foto4" class="mt-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 4</label>
                                    <textarea name="ringkasan4" id="ringkasan4" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Santunan untuk anak yatim, kaum dhuafa, dan korban musibah sebagai bentuk kepedulian sosial dan solidaritas ummat."></textarea>
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
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/landing/program-kami') }}"
                                class="btn btn-secondary mt-3 mr-2">
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

            handleImagePreview('foto1', 'preview-foto1');
            handleImagePreview('foto2', 'preview-foto2');
            handleImagePreview('foto3', 'preview-foto3');
            handleImagePreview('foto4', 'preview-foto4');
        </script>
    @endpush

</x-utama.layout.main>
