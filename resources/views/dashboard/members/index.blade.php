@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2 text-primary"></i> Semua Anggota
                    </h2>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addNewUser">
                            <i class="fas fa-plus-circle me-1"></i> Tambah User
                        </button>
                        <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Anggota
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Paket</th>
                                    <th>Status Membership</th>
                                    <th>Status Anggota</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $member->user->name }}</span>
                                            <br>
                                            <span class="text-lowercase text-muted">{{ $member->user->email }}</span>
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ $member->user->phone }}
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ $member->latestMembership->membership->name ?? '' }}
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($member->latestMembership && $member->latestMembership->status == 'active')
                                                <span class="badge px-3 py-2 bg-success text-white">
                                                    Aktif
                                                </span>
                                            @elseif ($member->latestMembership && $member->latestMembership->status == 'expired')
                                                <span class="badge px-3 py-2 bg-danger text-white">
                                                    Kadaluarsa
                                                </span>
                                            @else
                                                <span class="badge px-3 py-2 bg-secondary text-white">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($member->status == 'active')
                                                <span class="badge px-3 py-2 bg-success text-white">
                                                    Aktif
                                                </span>
                                            @elseif ($member->status == 'inactive')
                                                <span class="badge px-3 py-2 bg-secondary text-white">
                                                    Nonaktif
                                                </span>
                                            @else
                                                <span class="badge px-3 py-2 bg-danger text-white">
                                                    Diblokir
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                                            {{ $member->created_at->translatedFormat('d M Y') }}
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <a href="{{ route('members.show', $member->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('members.toggleStatus', $member->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-warning">
                                                    @if ($member->status == 'active')
                                                        <i class="fas fa-toggle-off"></i>
                                                    @else
                                                        <i class="fas fa-toggle-on"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <!-- Modal Add User-->
    <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewUserLabel">
                            <i class="fas fa-plus-circle me-1"></i> Tambah User
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email') }}" required />
                                    <input type="hidden" value="member" name="member">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama" name="name" value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">No WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="No WhatsApp" name="phone" value="{{ old('phone') }}" required />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                        required>
                                        <option value="">-- Jenis Kelamin --</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki - Laki
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Foto Wajah</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-md-6">
                                <!-- Birth Date -->
                                <div class="form-group mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                        name="birth_date" value="{{ old('birth_date') }}" required />
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                        placeholder="Alamat" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password" id="password" required>

                                        <button class="btn" style="background: white; border:1px solid #ccc"
                                            type="button" id="togglePasswordBtn1">
                                            <i class="fa fa-eye" id="togglePassword1"></i>
                                        </button>

                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Konfirmasi Password" name="password_confirmation"
                                            id="password_confirmation" required>
                                        <button class="btn" style="background: white; border:1px solid #ccc"
                                            type="button" id="togglePasswordBtn2">
                                            <i class="fa fa-eye" id="togglePassword2"></i>
                                        </button>
                                    </div>

                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('addNewUser'));
                myModal.show();
            });
        </script>
    @endif

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function setupToggle(passwordInputId, iconId) {
            const input = document.getElementById(passwordInputId);
            const icon = document.getElementById(iconId);

            icon.parentElement.addEventListener("click", () => {
                const isPassword = input.type === "password";

                input.type = isPassword ? "text" : "password";
                icon.classList.toggle("fa-eye");
                icon.classList.toggle("fa-eye-slash");
            });
        }

        setupToggle("password", "togglePassword1");
        setupToggle("password_confirmation", "togglePassword2");
    </script>
    <script>
        $(function() {
            const exportButtons = ["copy", "csv", "excel", "pdf", "print"];

            $("#dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki anggota.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Daftar Anggota | Rey Fitnes',
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
