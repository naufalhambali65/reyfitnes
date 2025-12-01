@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>
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

        <!-- LEFT COLUMN (Profile) -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-user me-1"></i> Profil Anggota</h5>
                <div class="text-center">

                    <img src="{{ $user->image ? asset('storage/app/public/' . $user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width: 180px; height: auto; object-fit: cover;">

                    <h4 class="fw-bold mb-0">{{ ucwords($user->name) }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <span class="badge {{ $member->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($member->status == 'active' ? 'Aktif' : 'Nonaktif') }}
                    </span>
                </div>
                <hr>
                <h6 class="fw-semibold mb-2"><i class="fas fa-info-circle me-1"></i> Detail Lainnya</h6>

                <div class="row g-1">
                    @if (isset($user->gender))
                        <div class="col-5 col-md-4 text-muted">Jenis Kelamin</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}
                        </div>
                    @endif

                    @if (isset($user->phone))
                        <div class="col-5 col-md-4 text-muted">No. WhatsApp</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->phone }}</div>
                    @endif

                    @if (isset($user->address))
                        <div class="col-5 col-md-4 text-muted">Alamat</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->address }}</div>
                    @endif

                    @if (isset($user->birth_date))
                        <div class="col-5 col-md-4 text-muted">Tanggal Lahir</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->birth_date->translatedFormat('d M Y') }}</div>
                    @endif
                </div>

            </div>

            <!-- Active Membership -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-id-card me-1"></i> Membership Aktif</h5>

                @if ($activeMembership)
                    <p class="mb-1 fw-bold">{{ $activeMembership->membership->name }}</p>
                    <p class="mb-0 text-muted">
                        {{ $activeMembership->start_date->translatedFormat('d M Y') }}
                        —
                        {{ $activeMembership->end_date->translatedFormat('d M Y') }}
                    </p>
                @else
                    <p class="text-muted">Tidak ada membership aktif</p>
                @endif
            </div>
            <!-- QR CODE -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-qrcode me-1"></i>QR Code Anggota</h5>

                @if ($activeMembership && $activeMembership->qr_code)
                    <div class="text-center">
                        <img src="{{ asset('storage/app/public/' . $activeMembership->qr_code) }}" alt="QR Code Member"
                            class="img-fluid mb-2" style="max-width: 180px; height: auto;">

                        <p class="small text-muted mb-0 mt-2">
                            Scan QR ini untuk check-in di pintu masuk
                        </p>
                        <!-- Tombol Download QR -->
                        <a href="{{ asset('storage/app/public/' . $activeMembership->qr_code) }}"
                            download="qr-member-{{ $member->id }}.png" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-download me-1"></i> Download QR
                        </a>
                    </div>
                @else
                    <p class="text-muted">QR Code tidak tersedia</p>
                @endif
            </div>

            <div class="card shadow-sm  mt-3">
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


        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <!-- History Membership -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-history me-1"></i> Riwayat Membership
                        </h5>
                    </div>


                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>Paket</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyMemberships as $item)
                                    <tr class="text-center align-middle">
                                        <td>{{ $item->membership->name }}</td>
                                        <td>{{ $item->start_date ? $item->start_date->translatedFormat('d M Y') : '-' }}
                                        </td>
                                        <td>{{ $item->end_date ? $item->end_date->translatedFormat('d M Y') : '-' }}</td>
                                        <td>
                                            @if ($item->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($item->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($item->status == 'expired')
                                                <span class="badge bg-secondary">Kadaluarsa</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Attendance History -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-calendar-check me-1"></i> Riwayat Kehadiran</h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $att)
                                    <tr class="text-center align-middle">
                                        <td>{{ $att->check_in_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $att->check_in_at->format('H:i') }}</td>
                                        <td><span
                                                class="badge {{ $att->status = 'present' ? 'bg-success' : 'secondary' }}">{{ ucfirst($att->status = 'present' ? 'Hadir' : 'Tidak Hadir') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Payment History -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-wallet me-1"></i> Riwayat Pembayaran Membership</h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>Tanggal</th>
                                    <th>Membership</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyMemberships as $item)
                                    <tr class="text-center align-middle">
                                        <td>{{ $item->payment->created_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $item->membership->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($item->payment->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($item->payment->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @else
                                                <span class="badge bg-danger">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- Booking Class History -->
            @if ($activeMembership && $activeMembership->membership->gymClasses->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-3"><i class="fas fa-dumbbell me-1"></i> Riwayat Booking Kelas</h5>
                        </div>
                        <div class="table-responsive" style="max-height: 300px">
                            <table class="table table-head-fixed table-bordered align-middle">
                                <thead class="table-light">
                                    <tr class="text-center align-middle">
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Pelatih</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classBookings as $booking)
                                        <tr class="text-center align-middle">
                                            <td>
                                                <span class="text-capitalize">
                                                    {{ $booking->class->name }}
                                                </span>
                                                <span class="text-lowercase text-muted">
                                                    {{ $booking->class->category->name }}
                                                </span>
                                            </td>

                                            <td class="text-center align-middle">
                                                {{ ucwords($booking->day) ?? '' }}
                                            </td>

                                            <td class="text-center align-middle">
                                                {{ ucwords($booking->class->trainer->user->name) }}
                                            </td>

                                            <td class="text-center align-middle">
                                                @if ($booking->status == 'active')
                                                    <span class="badge bg-success text-white">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary text-white">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection
@section('js')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('addMembership'));
                myModal.show();
            });
        </script>
    @endif

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
