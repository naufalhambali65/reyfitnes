@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user-shield text-primary me-2"></i>
                        Profil {{ ucwords($user->name) }}
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEFT PROFILE -->
        <div class="col-md-5">
            <div class="card shadow-sm p-3 mb-3">
                <div class="text-center">

                    <img src="{{ $user->image ? asset('storage/app/public/' . $user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width:160px; height:auto; object-fit:cover;">

                    <h4 class="fw-bold mb-0">{{ ucwords($user->name) }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <span
                        class="badge @if ($user->role == 'super_admin') bg-danger @elseif($user->role == 'admin') bg-primary @else bg-secondary @endif">
                        @if ($user->role == 'super_admin')
                            SUPER ADMIN
                        @elseif($user->role == 'admin')
                            ADMIN
                        @else
                            GUEST
                        @endif
                    </span>
                </div>
            </div>
        </div>


        <!-- RIGHT -->
        <div class="col-md-7">

            <div class="card shadow-sm p-3 mb-3">
                <h6 class="fw-semibold mb-2"><i class="fas fa-info-circle me-1"></i> Informasi Lainnya</h6>

                <div class="row g-1">
                    @if ($user->gender)
                        <div class="col-5 text-muted">Gender</div>
                        <div class="col-7">: {{ $user->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}</div>
                    @endif

                    @if ($user->phone)
                        <div class="col-5 text-muted">WhatsApp</div>
                        <div class="col-7">: {{ $user->phone }}</div>
                    @endif

                    @if ($user->address)
                        <div class="col-5 text-muted">Alamat</div>
                        <div class="col-7">: {{ $user->address }}</div>
                    @endif

                    @if ($user->birth_date)
                        <div class="col-5 text-muted">Tanggal Lahir</div>
                        <div class="col-7">: {{ $user->birth_date->translatedFormat('d M Y') }}</div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-md-5">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <form action="{{ route('profile.change-password') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold"><i class="fas fa-user-lock me-1"></i> Ubah Password</h5>

                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                        <div class="card-body p-0">
                            <div class="row">

                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Password Lama</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            placeholder="Password Lama" aria-label="Old Password"
                                            aria-describedby="button-addon1" id="old_password" name="old_password" required
                                            autofocus>
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">
                                            <i class="fa fa-eye" id="togglePassword1"></i>
                                        </button>
                                        @error('old_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password baru</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            placeholder="Password Baru" aria-describedby="button-addon2" id="new_password"
                                            name="new_password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                            <i class="fa fa-eye" id="togglePassword2"></i>
                                        </button>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                            placeholder="Konfirmasi Password Baru" aria-label="Repeat New Password"
                                            aria-describedby="button-addon3" id="new_password_confirmation"
                                            name="new_password_confirmation" required>
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon3">
                                            <i class="fa fa-eye" id="togglePassword3"></i>
                                        </button>
                                        @error('new_password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        document.getElementById('button-addon1').addEventListener('click', function() {
            const passwordField = document.getElementById('old_password');
            const toggleIcon = document.getElementById('togglePassword1');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('button-addon2').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password');
            const toggleIcon = document.getElementById('togglePassword2');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('button-addon3').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password_confirmation');
            const toggleIcon = document.getElementById('togglePassword3');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
