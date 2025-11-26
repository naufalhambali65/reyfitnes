@extends('dashboard.layouts.main')

@section('container')
    <div class="row">

        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Semua Notifikasi
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LIST NOTIFICATIONS -->
        <div class="col-12">

            @forelse ($notifications as $notif)
                <div class="card shadow-sm mb-3">

                    <div class="card-body d-flex gap-3">

                        <!-- ICON -->
                        <div class="d-flex align-items-start">
                            <i class="{{ $notif->icon ?? 'fas fa-info-circle' }} text-{{ $notif->type ?? 'primary' }}"
                                style="font-size: 32px; width: 40px"></i>
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">{{ $notif->title }}</h5>

                            <p class="mb-1 text-muted" style="white-space:pre-line">
                                {{ $notif->message }}
                            </p>

                            <span
                                class="badge
                                {{ $notif->is_read ? 'bg-secondary' : 'bg-warning text-dark' }}">
                                {{ $notif->is_read ? 'Dibaca' : 'Belum Dibaca' }}
                            </span>

                            <p class="text-muted small mt-1 mb-0">
                                {{ $notif->created_at->translatedFormat('d M Y H:i') }}
                            </p>
                        </div>

                        <!-- BUTTON -->
                        <div class="text-end d-flex flex-column justify-content-between">
                            @if ($notif->link)
                                <a href="{{ $notif->link }}" class="btn btn-primary btn-sm">
                                    Detail Notif <i class="fas fa-eye ms-1"></i>
                                </a>
                            @endif
                            @if (!$notif->is_read)
                                <form action="{{ route('notifications.markAsRead', $notif->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Tandai Dibaca <i class="fas fa-book-reader ms-1"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>

                </div>
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                        <p class="fw-semibold">Tidak ada notifikasi saat ini</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection
