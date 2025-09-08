<x-utama.layout.main title="Superadmin | Berita & Blog">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Edit Berita & Blog</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/berita/edit/' . $berita->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Berita & Blog</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Tag</label>
                                    <input type="text" name="tag" id="tag" class="form-control mt-2 mb-2"
                                        placeholder="Berita & Blog" value="{{ old('tag', $berita->tag) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                        placeholder="Cerita Inspiratif dan Info Terkini Seputar INUK"
                                        value="{{ old('judul', $berita->judul) }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="ringkasan" id="ringkasan" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Dapatkan informasi terbaru mengenai kegiatan sosial, edukasi filantropi, serta kisah nyata dari para penerima manfaat infaq Anda. Bersama INUK, setiap infaq adalah jalan keberkahan.">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto Berita</label>
                                    <input type="file" name="foto1" id="foto1" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto1" class="mt-2">
                                        @if ($berita->foto1)
                                            <img src="{{ asset('storage/' . $berita->foto1) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul Berita</label>
                                    <input type="text" name="judul1" id="judul1" class="form-control mt-2 mb-2"
                                        placeholder="Infaq yang Amanah" value="{{ old('judul1', $berita->judul1) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Sub Judul</label>
                                    <input type="text" name="motto1" id="motto1" class="form-control mt-2 mb-2"
                                        placeholder="Infaq yang Amanah" value="{{ old('motto1', $berita->motto1) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto Penulis</label>
                                    <input type="file" name="foto2" id="foto2" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto2" class="mt-2">
                                        @if ($berita->foto2)
                                            <img src="{{ asset('storage/' . $berita->foto2) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="ringkasan1" id="ringkasan1" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Setiap donasi dikelola secara profesional dan disalurkan tepat sasaran.">{{ old('ringkasan1', $berita->ringkasan1) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Penulis Berita</label>
                                    <input type="text" name="penulis" id="penulis" class="form-control mt-2 mb-2"
                                        placeholder="Nama" value="{{ old('penulis', $berita->penulis) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Tanggal Berita</label>
                                    <input type="date" name="tgl_berita" id="tgl_berita"
                                        class="form-control mt-2 mb-2" placeholder="08123456789"
                                        value="{{ old('tgl_berita', $berita->tgl_berita) }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Aktif" {{ $berita->status == 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Nonaktif"
                                                {{ $berita->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/landing/berita') }}" class="btn btn-secondary mt-3 mr-2">
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
        </script>
    @endpush

</x-utama.layout.main>
