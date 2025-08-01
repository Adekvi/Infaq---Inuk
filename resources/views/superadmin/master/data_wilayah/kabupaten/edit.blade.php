<x-utama.layout.main title="Superadmin | Master Kabupaten">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Data Kabupaten</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data Kabupaten</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/wilayah-kabupaten/edit/' . $kabupaten->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kabupaten</label>
                                        <input type="text" name="nama_kabupaten" id="nama_kabupaten"
                                            value="{{ $kabupaten->nama_kabupaten }}" class="form-control mt-2 mb-2"
                                            placeholder="Nama Kabupaten" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/master-data/wilayah-kabupaten') }}"
                                class="btn btn-secondary mt-2 mr-2">
                                <i class="fa-solid fa-rotate-right"></i> Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
