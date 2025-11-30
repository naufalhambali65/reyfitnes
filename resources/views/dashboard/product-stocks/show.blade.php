@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">

            {{-- Header --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-box text-primary me-2"></i> {{ $product->name }}
                        </h4>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('product-stocks.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('product-stocks.edit', $product->slug) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            {{-- Price card + Chart --}}
            <div class="row mb-3">
                {{-- Price & Stock card --}}
                <div class="col-lg-4 col-md-5 col-12 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">

                            <div class="mb-2 text-muted small">Harga</div>
                            <h2 class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

                            {{-- Stock --}}
                            <div class="row mt-3">
                                <div class="col-6 border-end">
                                    <div class="small text-muted">Stok</div>
                                    <div class="fw-semibold">{{ $product->stock }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Minimal Stok</div>
                                    <div class="fw-semibold text-danger">{{ $product->min_stock }}</div>
                                </div>
                            </div>

                            {{-- Stock Status --}}
                            <div class="mt-3">
                                <div class="small text-muted">Status Produk</div>
                                <span class="badge {{ $product->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Stock movement chart --}}
                <div class="col-lg-8 col-md-7 col-12 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-chart-line me-1"></i> Pergerakan Stok (12 Bulan)
                            </h6>
                            <canvas id="stockChart" style="width:100%;max-height:260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Produk --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Produk</h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Kategori</div>
                            <div class="fw-semibold">{{ $product->category->name }}</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Satuan</div>
                            <div class="fw-semibold">{{ $product->unit->name }}</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Dibuat Pada</div>
                            <div class="fw-semibold">{{ $product->created_at->translatedFormat('d M Y') }}</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Terakhir diupdate</div>
                            <div class="fw-semibold">{{ $product->updated_at->translatedFormat('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-file-alt me-1"></i> Deskripsi</h5>
                    <div class="bg-light p-3 rounded">
                        {!! $product->description ?? '<span class="text-muted">Tidak ada deskripsi.</span>' !!}
                    </div>
                </div>
            </div>

            {{-- Stock Logs --}}
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-history me-2"></i> Riwayat Pergerakan Stok
                    </h2>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockLogs as $log)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">
                                            <span class="badge {{ $log->type == 'in' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $log->type == 'in' ? 'Masuk' : 'Keluar' }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">{{ $log->quantity }}</td>
                                        <td class="align-middle">{{ $log->note ?? '-' }}</td>
                                        <td class="text-center align-middle">
                                            {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y') }}
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

@section('js')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart stok bulanan
        (function() {
            const ctx = document.getElementById('stockChart').getContext('2d');
            const labels = @json($months);
            const data = @json($monthlyProfits);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Keuntungan',
                        data: data,
                        fill: true,
                        tension: 0.3,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54,162,235,0.12)',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })();

        // DataTable
        $(function() {
            const exportButtons = ["copy", "csv", "excel", "pdf", "print"];

            $("#dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Tidak ada pergerakan stok.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Riwayat Stok - {{ $product->name }}'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@section('css')
    <style>
        @media (max-width: 767.98px) {
            #stockChart {
                max-height: 220px !important;
            }
        }
    </style>
@endsection
