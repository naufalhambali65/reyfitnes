@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-tags text-primary me-2"></i> {{ $membership->name }}
                        </h4>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('memberships.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('memberships.edit', $membership->slug) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            {{-- Top Row: Price card + Chart --}}
            <div class="row mb-3">
                <div class="col-lg-4 col-md-5 col-12 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2 text-muted small">Harga</div>
                            <h2 class="fw-bold text-success">{{ $membership->price_formatted }}</h2>

                            <div class="row mt-3">
                                <div class="col-6 border-end">
                                    <div class="small text-muted">Total Customer</div>
                                    <div class="fw-semibold">{{ $totalCustomer }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Customer Aktif</div>
                                    <div class="fw-semibold text-success">{{ $totalActiveCustomer }}</div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="small text-muted">Active Rate</div>
                                <div class="progress" style="height:10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $progressPercent }}%" aria-valuenow="{{ $progressPercent }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $progressPercent }}% active</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7 col-12 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3"><i class="fas fa-chart-line me-1"></i> Active per Bulan (12 bln)
                            </h6>
                            <canvas id="membersChart" style="width:100%;max-height:260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi paket --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body ">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Paket</h5>
                    <div class="row ">
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Durasi</div>
                            <div class="fw-semibold">{{ $membership->duration_days }} Hari</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Dibuat Pada</div>
                            <div class="fw-semibold">{{ $membership->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Terakhir diupdate</div>
                            <div class="fw-semibold">{{ $membership->updated_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted">Status</div>
                            <div class="fw-semibold">
                                <span class="badge {{ $membership->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $membership->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-file-alt me-1"></i> Deskripsi</h5>
                    <div class="bg-light p-3 rounded">
                        {!! $membership->description !!}
                    </div>
                </div>
            </div>

            {{-- Features & Class --}}
            <div class="card shadow-sm mb-3">
                <div class="row g-0 p-3">

                    {{-- Benefit / Fitur --}}
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-star me-1 text-warning"></i>
                                Benefit / Fitur
                            </h5>

                            <div class="bg-light p-3 rounded">
                                {!! $membership->features !!}
                            </div>
                        </div>
                    </div>

                    {{-- Akses Kelas --}}
                    @if ($classes->count() > 0)
                        <div class="col-md-6">
                            <div class="card-body">

                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-chalkboard-teacher me-2 text-warning"></i>
                                    Akses Kelas
                                </h5>

                                <div class="row g-3">
                                    @foreach ($classes as $class)
                                        <div class="col">
                                            <div class="p-3 border rounded shadow-sm bg-light h-100">

                                                <h6 class="fw-bold mb-1">
                                                    <i class="fas fa-dumbbell text-primary me-1"></i>
                                                    {{ $class->name }}
                                                </h6>

                                                <span class="badge bg-info mb-2">
                                                    <i class="fas fa-tag me-1"></i>
                                                    {{ $class->category->name }}
                                                </span>

                                                <p class="mb-1 text-muted small">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $class->user->name ?? 'Tanpa pelatih' }}
                                                </p>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Table --}}
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-table me-2 text-primary"></i> Daftar Pembeli Paket
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($membersList as $member)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">{{ $member->user->name }}</td>
                                        <td class="text-center align-middle">{{ $member->user->email }}</td>
                                        <td class="text-center align-middle">{{ $member->user->phone ?? '-' }}</td>
                                        <td class="align-middle text-center">
                                            {{ \Carbon\Carbon::parse($member->start_date)->format('d M Y') }}</td>
                                        <td class="align-middle text-center">
                                            {{ \Carbon\Carbon::parse($member->end_date)->format('d M Y') }}</td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge {{ $member->status == 'active' ? 'bg-success' : ($member->status == 'pending' ? 'bg-warning text-dark' : ($member->status == 'expired' ? 'bg-secondary' : 'bg-danger')) }}">
                                                {{ ucfirst($member->status = 'active' ? 'Aktif' : 'Tidak Aktif') }}
                                            </span>
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
    {{-- Load Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart
        (function() {
            const ctx = document.getElementById('membersChart').getContext('2d');
            const labels = @json($months);
            const data = @json($counts);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'New members per month',
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

        $(function() {
            const exportButtons = ["copy", "csv", "excel", "pdf", "print"];

            $("#dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki anggota membership.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Daftar Pembeli Paket - {{ $membership->name }} | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@section('css')
    <style>
        /* small responsive tweaks */
        @media (max-width: 767.98px) {
            #membersChart {
                max-height: 220px !important;
            }

            .card .card-body h2 {
                font-size: 1.25rem;
            }
        }
    </style>
@endsection
