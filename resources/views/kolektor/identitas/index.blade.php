<x-utama.layout.main title="Kartu Identitas Kolektor">

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akun /</span> Kartu Identitas</h4>

            <div class="row">
                <div class="col-md-9">
                    <div class="card mb-6 shadow-sm"
                        style="border-radius: 15px; background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                        <div class="card-header bg-secondary text-center" style="border-radius: 12px 12px 0 0;">
                            <h5 class="mb-0 text-white">Kartu Identitas Kolektor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mt-2">
                                    @php
                                        $fotoPath =
                                            $datadiri->foto && Storage::disk('public')->exists($datadiri->foto)
                                                ? Storage::url($datadiri->foto)
                                                : asset('admin/img/user.webp');
                                    @endphp


                                    <img src="{{ $fotoPath }}" alt="Foto Kolektor" class="img-fluid rounded"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 2px;">

                                </div>
                                <div class="col-md-10">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Username</strong></td>
                                            <td>: {{ $datadiri->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Hp</strong></td>
                                            <td>: {{ $datadiri->user->no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Lengkap</strong></td>
                                            <td>: {{ $datadiri->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Kelamin</strong></td>
                                            <td>: {{ $datadiri->jenis_kelamin }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tempat, Tanggal Lahir</strong></td>
                                            <td>: {{ $datadiri->tempat }},
                                                {{ \Carbon\Carbon::parse($datadiri->tgllahir)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>: {{ $datadiri->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kecamatan</strong></td>
                                            <td>: {{ $datadiri->kecamatan->nama_kecamatan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelurahan</strong></td>
                                            <td>: {{ $datadiri->kelurahan->nama_kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>RT/RW</strong></td>
                                            <td>: {{ $datadiri->Rt }}/{{ $datadiri->Rw }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-start">
                        <a href="{{ route('kolektor.dashboard') }}" class="btn btn-primary me-1">
                            <i class="fa-solid fa-arrow-left"></i> Kembali</a>
                        <a href="{{ url('kolektor/identitas/edit/' . $datadiri->id) }}"
                            class="btn btn-outline-secondary">
                            <i class="fas fa-pencil"></i> Edit
                            Data Diri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- <script>
            // SweetAlert2 sudah ditangani di app.blade.php
        </script> --}}
    @endsection
</x-utama.layout.main>
