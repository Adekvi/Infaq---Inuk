<x-utama.layout.main title="Superadmin | Keunggulan Kami">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Edit Keunggulan Kami</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/keunggulan-kami/edit/' . $keunggulan->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row p-4">
                                <h5 class="mb-2">
                                    <li>Keunggulan Kami</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Tag</label>
                                    <input type="text" name="tag" id="tag" class="form-control mt-2 mb-2"
                                        placeholder="Keunggulan Kami" value="{{ old('tag', $keunggulan->tag) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                        placeholder="Manfaat Menunaikan Infaq bersama INUK"
                                        value="{{ old('judul', $keunggulan->judul) }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan</label>
                                    <textarea name="deskrpisi" id="deskrpisi" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="INUK hadir sebagai solusi menyalurkan infaq dengan amanah, transparan, dan berdampak. Kami tidak hanya menyalurkan, tetapi juga memastikan setiap rupiah membawa perubahan nyata bagi umat dan masyarakat yang membutuhkan.">{{ old('deskripsi', $keunggulan->deskripsi) }}</textarea>
                                </div>
                                <h5>
                                    <strong>
                                        <li>Konten</li>
                                    </strong>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Motto 1</label>
                                    <input type="text" name="motto1" id="motto1" class="form-control mt-2 mb-2"
                                        placeholder="Aman dan Transparan"
                                        value="{{ old('motto1', $keunggulan->motto1) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Kalimat 1</label>
                                    <input type="text" name="kalimat1" id="kalimat1" class="form-control mt-2 mb-2"
                                        placeholder="Kami Menjaga Amanah Anda"
                                        value="{{ old('kalimat1', $keunggulan->kalimat1) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 1</label>
                                    <input type="file" name="foto1" id="foto1" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto1" class="mt-2">
                                        @if ($keunggulan->foto1)
                                            <img src="{{ asset('storage/' . $keunggulan->foto1) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 1</label>
                                    <textarea name="ringkasan1" id="ringkasan1" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Setiap dana infaq dikelola secara profesional dan disalurkan dengan penuh tanggung jawab melalui sistem pelaporan yang terbuka dan dapat diakses publik.">{{ old('ringkasan1', $keunggulan->ringkasan1) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Motto 2</label>
                                    <input type="text" name="motto2" id="motto2" class="form-control mt-2 mb-2"
                                        placeholder="Penyaluran Cepat dan Tepat Sasaran"
                                        value="{{ old('motto2', $keunggulan->motto2) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Kalimat 2</label>
                                    <input type="text" name="kalimat2" id="kalimat2" class="form-control mt-2 mb-2"
                                        placeholder="Tepat Sasaran dan Responsif"
                                        value="{{ old('kalimat2', $keunggulan->kalimat2) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 2</label>
                                    <input type="file" name="foto2" id="foto2" class="form-control mt-2 mb-2"
                                        accept="image/*">
                                    <div id="preview-foto2" class="mt-2">
                                        @if ($keunggulan->foto2)
                                            <img src="{{ asset('storage/' . $keunggulan->foto2) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 2</label>
                                    <textarea name="ringkasan2" id="ringkasan2" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="INUK memiliki jaringan distribusi langsung ke masyarakat yang membutuhkan, baik melalui bantuan kemanusiaan, pendidikan, kesehatan, maupun ekonomi.">{{ old('ringkasan2', $keunggulan->ringkasan2) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Motto 3</label>
                                    <input type="text" name="motto3" id="motto3"
                                        class="form-control mt-2 mb-2" placeholder="Kemudahan Donasi Digital"
                                        value="{{ old('motto3', $keunggulan->motto3) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Kalimat 3</label>
                                    <input type="text" name="kalimat3" id="kalimat3"
                                        class="form-control mt-2 mb-2" placeholder="Infaq Kini Lebih Mudah"
                                        value="{{ old('kalimat3', $keunggulan->kalimat3) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 3</label>
                                    <input type="file" name="foto3" id="foto3"
                                        class="form-control mt-2 mb-2" accept="image/*">
                                    <div id="preview-foto3" class="mt-2">
                                        @if ($keunggulan->foto3)
                                            <img src="{{ asset('storage/' . $keunggulan->foto3) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 3</label>
                                    <textarea name="ringkasan3" id="ringkasan3" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Melalui QRIS, transfer bank, dan platform online, kini berdonasi tak perlu repot. Anda bisa menyalurkan kebaikan hanya dengan beberapa klik saja.">{{ old('ringkasan3', $keunggulan->ringkasan3) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Motto 4</label>
                                    <input type="text" name="motto4" id="motto4"
                                        class="form-control mt-2 mb-2" placeholder="Laporan dan Dokumentasi Rutin"
                                        value="{{ old('motto4', $keunggulan->motto4) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Kalimat 4</label>
                                    <input type="text" name="kalimat4" id="kalimat4"
                                        class="form-control mt-2 mb-2" placeholder="Laporan Berkala & Dokumentasi"
                                        value="{{ old('kalimat4', $keunggulan->kalimat4) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Foto 4</label>
                                    <input type="file" name="foto4" id="foto4"
                                        class="form-control mt-2 mb-2" accept="image/*">
                                    <div id="preview-foto4" class="mt-2">
                                        @if ($keunggulan->foto4)
                                            <img src="{{ asset('storage/' . $keunggulan->foto4) }}" alt="Icon 1"
                                                style="max-height: 200px;" class="mb-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Ringkasan 4</label>
                                    <textarea name="ringkasan4" id="ringkasan4" class="form-control mt-2 mb-2" cols="5" rows="5"
                                        placeholder="Kami menyediakan laporan bulanan, dokumentasi penyaluran, serta pelaporan real-time agar para donatur merasa yakin dan puas.">{{ old('ringkasan4', $keunggulan->ringkasan4) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Aktif"
                                                {{ $keunggulan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Nonaktif"
                                                {{ $keunggulan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/landing/keunggulan-kami') }}"
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
            handleImagePreview('foto3', 'preview-foto2');
            handleImagePreview('foto4', 'preview-foto2');
        </script>
    @endpush

</x-utama.layout.main>
