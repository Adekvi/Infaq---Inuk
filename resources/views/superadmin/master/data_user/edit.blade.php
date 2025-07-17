<x-utama.layout.main title="Superadmin | Master User">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data User</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data User</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/user/edit/' . $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <select name="id_setting" id="id_setting"
                                            class="form-control mt-2 mb-2 @error('id_setting') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            @foreach ($settings as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $pilihSet == $item->id ? 'selected' : '' }}>
                                                    {{ $item->namasetting }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_setting')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('username') is-invalid @enderror"
                                            name="username" id="username" value="{{ $user->username }}"
                                            placeholder="Username">
                                    </div>
                                    @error('username')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password"
                                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                                            name="password" id="password" value="{{ $user->password }}">
                                    </div>
                                    @error('password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email"
                                            class="form-control mt-2 mb-2 @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ $user->email ?? '-' }}"
                                            placeholder="@gmail.com">
                                    </div>
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. Hp</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('no_hp') is-invalid @enderror"
                                            name="no_hp" id="no_hp" value="{{ $user->no_hp }}"
                                            placeholder="Contoh 08123456789" required>
                                    </div>
                                    @error('no_hp')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Role User</label>
                                        <select name="role" id="role"
                                            class="form-control mt-2 mb-2 @error('role') is-invalid @enderror">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin_kabupaten"
                                                {{ $user->role == 'admin_kabupaten' ? 'selected' : '' }}>Admin
                                                Kabupaten
                                            </option>
                                            <option value="admin_kecamatan"
                                                {{ $user->role == 'admin_kecamatan' ? 'selected' : '' }}>Admin
                                                Kecamatan
                                            </option>
                                            <option value="kolektor" {{ $user->role == 'kolektor' ? 'selected' : '' }}
                                                selected>Kolektor</option>
                                        </select>
                                        @error('role')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
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
