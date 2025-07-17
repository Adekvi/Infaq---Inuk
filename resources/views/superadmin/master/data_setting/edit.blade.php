<x-utama.layout.main title="Superadmin | Master Jabatan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Jabatan</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data Jabatan</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/setting/edit/' . $setting->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Jabatan</label>
                                        <select name="namasetting" id="namasetting" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="Ketua"
                                                {{ $setting->namasetting == 'Ketua' ? 'selected' : '' }}>Ketua
                                            </option>
                                            <option value="Sekretaris"
                                                {{ $setting->namasetting == 'Sekretaris' ? 'selected' : '' }}>Sekretaris
                                            </option>
                                            <option value="Bendahara"
                                                {{ $setting->namasetting == 'Bendahara' ? 'selected' : '' }}>Bendahara
                                            </option>
                                            <option value="Kolektor"
                                                {{ $setting->namasetting == 'Kolektor' ? 'selected' : '' }}>Kolektor
                                            </option>
                                        </select>
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
