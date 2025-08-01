<x-utama.layout.main title="Superadmin | Master Kelurahan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Data Kelurahan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Kelurahan</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/wilayah-kelurahan/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kecamatan</label>
                                        <select name="id_kecamatan" id="id_kecamatan" class="form-control mt-2 mb-2">
                                            <option value="">-- Kecamatan --</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Kelurahan</label>
                                        <input type="text" name="nama_kelurahan" id="nama_kelurahan"
                                            class="form-control mt-2 mb-2" placeholder="Nama Kelurahan" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save</button>
                            <a href="{{ url('superadmin/master-data/wilayah-kelurahan') }}"
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

    </x-utama.layout.ma>
