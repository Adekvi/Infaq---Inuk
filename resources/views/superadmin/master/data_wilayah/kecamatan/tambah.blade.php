<x-utama.layout.main title="Superadmin | Master Kecamatan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Data Kecamatan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Kecamatan</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/wilayah-kecamatan/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kabupaten</label>
                                        <select name="id_kabupaten" id="id_kabupaten" class="form-control mt-2 mb-2">
                                            <option value="">-- Kabupaten --</option>
                                            @foreach ($kabupaten as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kabupaten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kecamatan</label>
                                        <input type="text" name="nama_kecamatan" id="nama_kecamatan"
                                            class="form-control mt-2 mb-2" placeholder="Nama Kecamatan" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/master-data/wilayah-kecamatan') }}"
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
