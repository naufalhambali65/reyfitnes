@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalPayments }}</h3>
                    <p>Total Transaksi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-paper"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning text-white">
                <div class="inner">
                    <h3>{{ $waitingPayments }}</h3>
                    <p>Pembayaran Menunggu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-end"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $successPayments }}</h3>
                    <p>Pembayaran Berhasil</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-cyan">
                <div class="inner">
                    <h3>{{ $totalAmountPayments }}</h3>
                    <p>Total Pembayaran</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-usd"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-credit-card me-2 text-primary"></i> Semua Riwayat Pembayaran
                    </h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">{{ $loop->iteration }}</td>

                                        <td class="align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $payment->user->name }} </span>
                                            <br>
                                            <span class="text-lowercase fw-semibold">{{ $payment->user->email }}</span>
                                        </td>

                                        <td class="text-center align-middle fw-bold text-success">
                                            Rp {{ number_format($payment->amount, 2, ',', '.') }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <span
                                                class="badge px-3 py-2 {{ $payment->payment_method == 'transfer' ? 'bg-primary text-white' : 'bg-cyan text-white' }} ">
                                                {{ $payment->payment_method == 'transfer' ? 'Transfer Bank' : 'Qris' }}
                                            </span>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($payment->status == 'pending')
                                                <span class="badge px-3 py-2 bg-warning text-white">Tertunda</span>
                                            @elseif ($payment->status == 'completed')
                                                <span class="badge  px-3 py-2 bg-success text-white">Selesai</span>
                                            @else
                                                <span class="badge px-3 py-2 bg-danger text-white">Gagal</span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                                            {{ $payment->updated_at->translatedFormat('d M Y') }}
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <a href="{{ route('payments.show', $payment->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
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
@endsection
@section('js')
    <script>
        $(function() {
            const exportButtons = ["copy", "csv", "excel", "pdf", "print"];

            $("#dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki riwayat pembayaran.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Daftar Rekening Bank | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
