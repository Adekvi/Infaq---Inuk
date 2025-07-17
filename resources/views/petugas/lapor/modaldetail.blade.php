<div class="modal fade" id="detail{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">
                    Detail Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-primary align-middle">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th colspan="3">Wilayah Infaq</th>
                                    <th colspan="4">Nominal Infaq</th>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>RT/RW</th>
                                    <th>Minggu I</th>
                                    <th>Minggu II</th>
                                    <th>Minggu III</th>
                                    <th>Minggu IV</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $item->setor->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td>{{ $item->setor->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td>
                                        @if ($item->setor->petugas && $item->setor->petugas->wilayahTugas->isNotEmpty())
                                            {{ $item->setor->petugas->wilayahTugas->where('id_kecamatan', $item->setor->id_kecamatan)->where('id_kelurahan', $item->setor->id_kelurahan)->map(function ($wilayah) {
                                                    return ($wilayah->RT ?? '-') . '/' . ($wilayah->RW ?? '-');
                                                })->implode(', ') ?:
                                                '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ Rupiah($item->setor->minggu1) }}</td>
                                    <td>{{ Rupiah($item->setor->minggu2) }}</td>
                                    <td>{{ Rupiah($item->setor->minggu3) }}</td>
                                    <td>{{ Rupiah($item->setor->minggu4) }}</td>
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
