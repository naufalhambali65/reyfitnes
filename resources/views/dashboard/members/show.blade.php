@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>
                        Detail Anggota
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
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

                    <img src="{{ $user->image ? asset('storage/' . $user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width: 180px; height: auto; object-fit: cover;">

                    <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <span class="badge {{ $member->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($member->status == 'active' ? 'Aktif' : 'Tidak Aktif') }}
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
                        <img src="{{ asset('storage/' . $activeMembership->qr_code) }}" alt="QR Code Member"
                            class="img-fluid mb-2" style="max-width: 180px; height: auto;">

                        <p class="small text-muted mb-0 mt-2">
                            Scan QR ini untuk check-in di pintu masuk
                        </p>
                        <!-- Tombol Download QR -->
                        <a href="{{ asset('storage/' . $activeMembership->qr_code) }}"
                            download="qr-member-{{ $member->id }}.png" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-download me-1"></i> Download QR
                        </a>
                    </div>
                @else
                    <p class="text-muted">QR Code tidak tersedia</p>
                @endif
            </div>
        </div>


        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <!-- History Membership -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-history me-1"></i> Riwayat Membership</h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Paket</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyMemberships as $item)
                                    <tr>
                                        <td>{{ $item->membership->name }}</td>
                                        <td>{{ $item->start_date ? $item->start_date->translatedFormat('d M Y') : '-' }}
                                        </td>
                                        <td>{{ $item->end_date ? $item->end_date->translatedFormat('d M Y') : '-' }}</td>
                                        <td>
                                            @if ($item->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
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
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $att)
                                    <tr>
                                        <td>{{ $att->check_in_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $att->check_in_at->format('H:i') }}</td>
                                        <td><span
                                                class="badge bg-primary">{{ ucfirst($att->status = 'present' ? 'Hadir' : 'Tidak Hadir') }}</span>
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
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Membership</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyMemberships as $item)
                                    <tr>
                                        <td>{{ $item->payment->created_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $item->membership->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($item->payment->status === 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($item->payment->status === 'pending')
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

        </div>

    </div>
@endsection
