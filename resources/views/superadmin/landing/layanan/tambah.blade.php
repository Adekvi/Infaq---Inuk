<x-utama.layout.main title="Superadmin | Layanan Kami">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Tambah Layanan Kami</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/layanan-kami/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Layanan Kami</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Tag</label>
                                    <input type="text" name="tag" id="tag" class="form-control mt-2 mb-2"
                                        placeholder="Layanan Kami">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                        placeholder="Infaq untuk Umat & Kesejahteraan">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Melalui INUK dari LAZISNU, kami menghadirkan berbagai layanan sosial dan pemberdayaan untuk menjangkau masyarakat yang membutuhkan secara langsung, transparan, dan penuh keberkahan."></textarea>
                                </div>
                                <h5>
                                    <strong>
                                        <li>Konten</li>
                                    </strong>
                                    <hr>
                                </h5>
                                <div class="col-md-6">
                                    <label for="">Layanan</label>
                                    <input type="text" name="motto1" id="motto1" class="form-control mt-2 mb-2"
                                        placeholder="Infaq yang Amanah">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto" class="mt-2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Ringkasan</label>
                                    <textarea name="ringkasan" id="ringkasan" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Setiap donasi dikelola secara profesional dan disalurkan tepat sasaran."></textarea>
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
                            <a href="{{ url('superadmin/landing/layanan-kami') }}" class="btn btn-secondary mt-3 mr-2">
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
