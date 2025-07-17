<x-utama.layout.main title="Superadmin | Master Template Pesan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Template Pesan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Template Pesan</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/pesan/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Pesan</label>
                                        <input type="text" name="namapesan" id="namapesan" placeholder="Pesan"
                                            class="form-control mt-2 mb-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Template</label>
                                        <textarea name="template" id="template" class="form-control mt-2 mb-2" cols="10" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                            <a href="{{ route('superadmin.master.pesan') }}" data-bs-toggle="tooltip" title="Kembali"
                                class="btn btn-secondary mt-3">
                                <i class="fa-solid fa-arrows-rotate"></i> Kembali
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
    @endpush

</x-utama.layout.main>
