@foreach ($hasil as $item)
    <!-- Modal Kirim -->
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-title">
                        <h5>
                            <li>
                                <strong>Detail Data</strong>
                            </li>
                            <hr>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped table-bordered table-responsive">
                                <thead class="text-center table-primary align-middle">
                                    <tr>
                                        <th colspan="3">Wilayah</th>
                                        <th rowspan="2">Bank</th>
                                        <th rowspan="2">Rekening</th>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>RT/RW</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $item->plotting->kecamatan->nama_kecamatan ?? '-' }}</td>
                                        <td>{{ $item->plotting->kelurahan->first()->nama_kelurahan ?? '-' }}</td>
                                        <td>{{ $item->Rt ?? '-' }}/{{ $item->Rw ?? '-' }}</td>
                                        <td>{{ $item->namaBank ?? '-' }}</td>
                                        <td>{{ $item->Rekening ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
