@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-receipt text-primary me-2"></i>
                        Detail Pembayaran
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Payment Main Card --}}
            <div class="card shadow-sm mb-3 border-0">
                <div class="card-body p-4"
                    style="
                    @if ($payment->status == 'pending') background: linear-gradient(135deg, #4A90E2, #1C3FAA);
                    @elseif($payment->status == 'completed')
                    background: linear-gradient(135deg, #4CAF50, #2E7D32);
                    @else
                    background: linear-gradient(135deg, #E53935, #B71C1C); @endif
                    border-radius: 14px; color:white;">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase small opacity-75">Jumlah Pembayaran</h6>
                            <h3 class="fw-bold mb-0">
                                Rp {{ number_format($payment->amount, 2, ',', '.') }}
                            </h3>
                        </div>

                        <div class="bg-white bg-opacity-25 p-2 rounded">
                            <i class="fas fa-money-check-alt fa-lg"></i>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mt-3">
                        <div class="small text-uppercase opacity-75">Metode Pembayaran</div>
                        <div class="fs-5 fw-semibold text-capitalize">{{ $payment->payment_method }}</div>
                    </div>

                    {{-- Bank --}}
                    @if ($payment->bank)
                        <div class="mt-3">
                            <div class="small text-uppercase opacity-75">Bank</div>
                            <div class="fw-semibold fs-6">
                                {{ $payment->bank->name }} — {{ $payment->bank->account_number }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    {{-- Metadata --}}
                    <div class="card shadow-sm mb-3 p-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Pembayaran</h5>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="small text-muted">Customer</div>
                                    <div class="fw-semibold text-capitalize">{{ $payment->user->name }} -
                                        <span class="text-lowercase">
                                            {{ $payment->user->email }}
                                        </span>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="small text-muted">Dibuat Pada</div>
                                    <div class="fw-semibold">{{ $payment->created_at->format('d M Y H:i') }}</div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="small text-muted">Terakhir Diupdate</div>
                                    <div class="fw-semibold">{{ $payment->updated_at->format('d M Y H:i') }}</div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="small text-muted">Status</div>
                                    <span
                                        class="badge
                                                @if ($payment->status == 'completed') bg-success
                                                @elseif($payment->status == 'failed') bg-danger
                                                @else bg-warning text-dark @endif
                                            ">
                                        @if ($payment->status == 'pending')
                                            Menunggu
                                        @elseif($payment->status == 'completed')
                                            Selesai
                                        @else
                                            Gagal
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- list item --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="fas fa-list me-1"></i> Daftar Item</h5>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Item</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($payment->items as $item)
                                                <tr>
                                                    <td>{{ $item->item->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>Rp. {{ number_format($item->price) }}</td>
                                                    <td>Rp. {{ number_format($item->quantity * $item->price) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="col-4">
                    {{-- Ganti Status --}}
                    @if ($payment->status == 'pending')
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-sync-alt me-1"></i> Ubah Status Pembayaran
                                </h5>

                                <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="d-flex gap-2 flex-wrap">
                                        {{-- <button name="status" value="pending"
                                        class="btn btn-warning text-dark @if ($payment->status == 'pending') active @endif">
                                        Pending
                                    </button> --}}

                                        <button name="status" value="completed"
                                            class="btn btn-success @if ($payment->status == 'completed') active @endif">
                                            Pembayaran Selesai
                                        </button>

                                        <button name="status" value="failed"
                                            class="btn btn-danger @if ($payment->status == 'failed') active @endif">
                                            Pembayaran Gagal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Bukti Pembayaran --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-image me-1"></i> Bukti Pembayaran
                            </h5>
                            <div class="row">
                                @if ($payment->payment_proof)
                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}"
                                        class="img-preview img-fluid mb-3 col-sm-5 d-block" style="object-fit: cover;">
                                @else
                                    <form action="{{ route('payments.updatePaymentProof', $payment->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group mb-3">
                                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran
                                                (Gambar)</label>
                                            <img class="img-preview img-fluid mb-3 col-sm-5">
                                            <input class="form-control @error('payment_proof') is-invalid @enderror"
                                                type="file" id="payment_proof" name="payment_proof"
                                                onchange="previewImage()" required>
                                            <input type="hidden" value="{{ $payment->payment_proof }}" name="oldProof">
                                            @error('payment_proof')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror


                                            <button class="btn btn-primary btn-sm mt-2" type="submit">
                                                <i class="fas fa-upload"></i> Upload
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if ($payment->notes)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-file-alt me-1"></i> Catatan
                        </h5>

                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($payment->notes)) !!}
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

@section('js')
    <script>
        function previewImage() {
            const image = document.querySelector('#payment_proof');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
