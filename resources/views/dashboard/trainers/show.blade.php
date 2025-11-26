@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>
                        Detail Trainer: {{ $trainer->user->name }}
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('trainers.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- LEFT COLUMN -->
        <div class="col-md-4 mb-3">

            <!-- PROFILE -->
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-user me-1"></i> Profil Trainer</h5>
                <div class="text-center">

                    <img src="{{ $trainer->user->image ? asset('storage/' . $trainer->user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width: 180px; height: auto; object-fit: cover;">

                    <h4 class="fw-bold mb-0">{{ $trainer->user->name }}</h4>
                    <p class="text-muted mb-1">{{ $trainer->user->email }}</p>

                    <span class="badge {{ $trainer->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($trainer->status == 'active' ? 'Aktif' : 'Nonaktif') }}
                    </span>
                </div>

                <hr>

                <h6 class="fw-semibold mb-2">
                    <i class="fas fa-info-circle me-1"></i> Detail Lainnya
                </h6>

                <div class="row g-1">

                    @if ($trainer->user->gender)
                        <div class="col-5 col-md-4 text-muted">Jenis Kelamin</div>
                        <div class="col-7 col-md-8 text-muted">
                            : {{ $trainer->user->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}
                        </div>
                    @endif

                    @if ($trainer->user->phone)
                        <div class="col-5 col-md-4 text-muted">No. WhatsApp</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $trainer->user->phone }}</div>
                    @endif

                    @if ($trainer->user->address)
                        <div class="col-5 col-md-4 text-muted">Alamat</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $trainer->user->address }}</div>
                    @endif

                    @if ($trainer->user->birth_date)
                        <div class="col-5 col-md-4 text-muted">Tanggal Lahir</div>
                        <div class="col-7 col-md-8 text-muted">
                            : {{ $trainer->user->birth_date->translatedFormat('d M Y') }}
                        </div>
                    @endif

                </div>
            </div>

            <!-- SPECIALTY -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-dumbbell me-1"></i> Keahlian Trainer
                </h5>

                <p class="mb-1 fw-bold">{{ ucwords($trainer->specialty) }}</p>

                @if ($trainer->years_experience)
                    <p class="text-muted mb-0">{{ $trainer->years_experience }} Tahun Pengalaman</p>
                @endif
            </div>

            <!-- BIO -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-file-alt me-1"></i> Tentang Trainer
                </h5>

                <p class="text-muted">{!! $trainer->bio ?? 'Belum ada deskripsi' !!}</p>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <!-- CLASS HISTORY -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-history me-1"></i> Riwayat Kelas yang Pernah Dibawakan
                    </h5>

                    <div class="table-responsive" style="max-height: 500px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($classHistories as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>
                                            <a href="{{ route('classes.show', $class->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada riwayat kelas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- TRAINER SCHEDULE (Optional Section) -->
            {{-- <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-calendar-check me-1"></i> Jadwal Mengajar
                    </h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedules as $sc)
                                    <tr>
                                        <td>{{ $sc->day }}</td>
                                        <td>{{ $sc->time }}</td>
                                        <td>{{ $sc->class->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Jadwal tidak tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div> --}}

        </div>
    </div>
@endsection
