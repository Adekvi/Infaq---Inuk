<x-utama.layout.main title="Superadmin | Setting Navbar">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Setting Navbar</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Navbar</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/landing/halaman-navbar/edit/' . $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- Judul --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Judul 1</label>
                                        <input type="text" name="judul1" class="form-control mb-2 mt-2"
                                            value="{{ old('judul1', $data->judul1) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Judul 2</label>
                                        <input type="text" name="judul2" class="form-control mb-2 mt-2"
                                            value="{{ old('judul2', $data->judul2) }}">
                                    </div>
                                </div>

                                {{-- Kalimat --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kalimat 1</label>
                                        <textarea name="kalimat1" class="form-control mb-2 mt-2" rows="5">{{ old('kalimat1', $data->kalimat1) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kalimat 2</label>
                                        <textarea name="kalimat2" class="form-control mb-2 mt-2" rows="5">{{ old('kalimat2', $data->kalimat2) }}</textarea>
                                    </div>
                                </div>

                                {{-- Ringkasan --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ringkasan 1</label>
                                        <textarea name="ringkas1" class="form-control mb-2 mt-2" rows="5">{{ old('ringkas1', $data->ringkas1) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ringkasan 2</label>
                                        <textarea name="ringkas2" class="form-control mb-2 mt-2" rows="5">{{ old('ringkas2', $data->ringkas2) }}</textarea>
                                    </div>
                                </div>

                                {{-- Foto 1 --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto1">Foto 1</label>
                                        <input type="file" name="foto1" id="foto1"
                                            class="form-control mb-2 mt-2" accept="image/*">
                                        <div id="preview-foto1" class="mt-2">
                                            @if ($data->foto1)
                                                <img src="{{ asset('storage/' . $data->foto1) }}" alt="Foto 1"
                                                    style="max-height: 200px;" class="mb-2">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Foto 2 --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto2">Foto 2</label>
                                        <input type="file" name="foto2" id="foto2"
                                            class="form-control mb-2 mt-2" accept="image/*">
                                        <div id="preview-foto2" class="mt-2">
                                            @if ($data->foto2)
                                                <img src="{{ asset('storage/' . $data->foto2) }}" alt="Foto 2"
                                                    style="max-height: 200px;" class="mb-2">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select name="status" id="status" class="form-select mt-2 mb-2">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif" {{ $data->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="Nonaktif" {{ $data->status == 'Nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                            <a href="{{ route('superadmin.landing.halaman1') }}"
                                class="btn btn-secondary mt-3">Kembali</a>
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
            function handleImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function() {
                    const file = this.files[0];

                    preview.innerHTML = '';

                    if (!file) return;

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran maksimal foto adalah 2MB');
                        input.value = '';
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
