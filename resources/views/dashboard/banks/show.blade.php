@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">

            {{-- Header --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-university text-primary me-2"></i>
                        {{ $bank->name }}
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('banks.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('banks.edit', $bank->slug) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bank Card --}}
            <div class="card shadow-sm mb-3 border-0">
                <div class="card-body p-4"
                    style="background: linear-gradient(135deg, #4A90E2, #1C3FAA); border-radius: 14px; color:white;">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase small opacity-75">Bank</h6>
                            <h3 class="fw-bold mb-0">{{ $bank->name }}</h3>
                        </div>

                        <div class="bg-white bg-opacity-25 p-2 rounded">
                            <i class="fas fa-university fa-lg"></i>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="small text-uppercase opacity-75">Nomor Rekening</div>
                        <div class="fs-4 fw-semibold">{{ $bank->account_number }}</div>
                    </div>

                    <div class="mt-3">
                        <div class="small text-uppercase opacity-75">Nama Pemilik</div>
                        <div class="fw-semibold fs-5">{{ $bank->account_holder_name }}</div>
                    </div>

                </div>
            </div>

            {{-- Metadata --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Paket</h5>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="small text-muted">Dibuat Pada</div>
                            <div class="fw-semibold">{{ $bank->created_at->translatedFormat('d M Y') }}</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="small text-muted">Terakhir Diupdate</div>
                            <div class="fw-semibold">{{ $bank->updated_at->translatedFormat('d M Y') }}</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="small text-muted">Status</div>
                            <span class="badge {{ $bank->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $bank->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            @if ($bank->description)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-file-alt me-1"></i> Deskripsi
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {!! $bank->description !!}
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection


@section('css')
    <style>
        @media (max-width: 767.98px) {
            .card .card-body h4 {
                font-size: 1.2rem;
            }

            .card-body .fs-4 {
                font-size: 1.3rem !important;
            }
        }
    </style>
@endsection
