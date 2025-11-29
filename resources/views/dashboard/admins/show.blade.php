@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user-shield text-primary me-2"></i>
                        Detail Admin: {{ ucwords($user->name) }}
                    </h4>

                    <div class="ms-auto">
                        <a href="{{ route('admins.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEFT PROFILE -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-3">
                <div class="text-center">

                    <img src="{{ $user->image ? asset('storage/' . $user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width:160px; height:auto; object-fit:cover;">

                    <h4 class="fw-bold mb-0">{{ ucwords($user->name) }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <span class="badge {{ $user->role == 'super_admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ strtoupper($user->role == 'admin' ? 'ADMIN' : 'SUPER ADMIN') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-8">

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

                {{-- <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-calendar-alt me-1"></i> Akun dibuat</span>
                        <span>{{ $user->created_at->translatedFormat('d M Y H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-clock me-1"></i> Terakhir update</span>
                        <span>{{ $user->updated_at->translatedFormat('d M Y H:i') }}</span>
                    </li>
                </ul> --}}

            </div>

        </div>
    </div>
@endsection
