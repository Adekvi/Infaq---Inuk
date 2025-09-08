<x-utama.layout.main title="Superadmin | Master Data Penerimaan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Penerimaan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Penerimaan</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/penerimaan/tambah-data') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">No. Alat</label>
                                    <input type="text" name="no_alat" id="no_alat" class="form-control mt-2 mb-2"
                                        placeholder="N01234">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Nama Donatur</label>
                                    <input type="text" name="nama_donatur" id="nama_donatur"
                                        class="form-control mt-2 mb-2" placeholder="Nama">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Jenis</label>
                                    <input type="text" name="jenis" id="jenis" class="form-control mt-2 mb-2"
                                        placeholder="INUK">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Nominal</label>
                                    <div class="input-group mt-2 mb-2">
                                        <span class="input-group-text bg-light"><b>Rp.</b></span>
                                        <input type="number" name="nominal" id="nominal" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tgl" id="tgl" class="form-control mt-2 mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control mt-2 mb-2" cols="5" rows="5"></textarea>
                                </div>
                            </div>
                            <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                            <a href="{{ url('superadmin/master-data/penerimaan/tambah-data') }}"
                                data-bs-toggle="tooltip" title="Reset" class="btn btn-info mt-3 mr-2">
                                <i class="fa-solid fa-arrows-rotate"></i> Reset
                            </a>
                            <a href="{{ url('superadmin/master-data/penerimaan') }}" data-bs-toggle="tooltip"
                                title="Kembali" class="btn btn-secondary mt-3">
                                <i class="fa-solid fa-arrows-rotate"></i> Kembali</a>
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
