<x-utama.layout.main title="Superadmin | Master Kabupaten">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Kabupaten</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Kabupaten</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/wilayah-kabupaten/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kode Kabupaten</label>
                                        <input type="int" name="id" id="id" class="form-control">
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kabupaten</label>
                                        <input type="text" name="nama_kabupaten" id="nama_kabupaten"
                                            class="form-control mt-2 mb-2" placeholder="Nama Kabupaten" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">Save</button>
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
