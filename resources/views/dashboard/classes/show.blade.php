@extends('dashboard.layouts.main')

@section('container')
    <div class="row">

        <!-- Header -->
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-dumbbell text-primary me-2"></i>
                        Detail Kelas: {{ $class->name }}
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('classes.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- LEFT COLUMN -->
        <div class="col-md-4 mb-3">

            <!-- Trainer -->
            <div class="card shadow-sm p-3 position-relative">

                <a href="{{ route('trainers.show', $class->trainer->id) }}" class="btn btn-sm btn-primary position-absolute"
                    style="top: 12px; right: 12px;">
                    Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-user-tie me-1"></i> Instruktur
                </h5>

                <div class="text-center">
                    <img src="{{ $class->trainer->user->image ? asset('storage/' . $class->trainer->user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width: 220px; object-fit: cover;">

                    <h4 class="fw-bold mb-0">{{ ucwords($class->trainer->user->name) }}</h4>

                    <div class="mt-2">
                        <span class="badge bg-primary">
                            Spesialis: {{ ucfirst($class->trainer->specialty) }}
                        </span>
                    </div>
                </div>
            </div>


            <!-- Membership -->
            <div class="card shadow-sm p-3 mt-3 position-relative">

                <a href="{{ route('memberships.show', $class->membership->slug) }}"
                    class="btn btn-sm btn-primary position-absolute" style="top: 12px; right: 12px;">
                    Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-id-card me-1"></i> Paket Membership
                </h5>

                <p class="fw-bold mb-0">{{ $class->membership->name }}</p>
                <p class="text-muted mb-0">
                    Harga: Rp {{ number_format($class->membership->price, 0, ',', '.') }}
                </p>
            </div>



        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-8">
            <!-- Kelas -->
            {{-- <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-image me-1"></i> Foto Kelas</h5>

                <div class="d-flex align-items-center">
                    <div class="text-center">
                        <img src="{{ $class->image ? asset('storage/' . $class->image) : '/homepage_assets/img/default-profil.png' }}"
                            class="img-fluid rounded mb-3" style="max-width: 220px; object-fit: cover;">
                    </div>
                </div>
            </div> --}}

            <!-- Detail Kelas -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">

                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Detail Kelas</h5>

                    <div class="row g-2">

                        <div class="col-5 text-muted">Nama Kelas</div>
                        <div class="col-7 text-muted">: {{ $class->name }}</div>

                        <div class="col-5 text-muted">Kategori</div>
                        <div class="col-7 text-muted">: {{ $class->category->name }}</div>

                        <div class="col-5 text-muted">Level Kesulitan</div>
                        <div class="col-7 text-muted">:
                            @if ($class->difficulty == 'beginner')
                                Mudah
                            @elseif ($class->difficulty == 'intermediate')
                                Menengah
                            @else
                                Sulit
                            @endif
                        </div>

                        <div class="col-5 text-muted">Status</div>
                        <div class="col-7 text-muted">
                            : {{ ucfirst($class->status == 'active' ? 'Aktif' : 'Nonaktif') }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- Description -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="fw-bold mb-3"><i class="fas fa-align-left me-1"></i> Deskripsi Kelas</h5>

                    @if ($class->description)
                        <p class="text-muted">{!! $class->description !!}</p>
                    @else
                        <p class="text-muted">Tidak ada deskripsi.</p>
                    @endif

                </div>
            </div>

        </div>

    </div>
@endsection
