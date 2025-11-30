@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-tags me-2 text-primary"></i> Semua Paket Membership
                    </h2>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                        <div class="ms-auto">
                            <a href="{{ route('memberships.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Paket
                            </a>
                        </div>
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Durasi</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberships as $membership)
                                    <tr>

                                        {{-- No --}}
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- Nama Membership --}}
                                        <td class="align-middle fw-semibold">
                                            {{ $membership->name }}
                                        </td>

                                        {{-- Durasi --}}
                                        <td class="text-center align-middle text-primary fw-semibold">
                                            {{ $membership->duration_days }} Hari
                                        </td>

                                        {{-- Harga --}}
                                        <td class="text-center align-middle fw-bold text-success">
                                            {{ $membership->price_formatted }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="text-center align-middle">
                                            <span
                                                class="badge px-3 py-2
            {{ $membership->status == 'available' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                {{ $membership->status == 'available' ? 'Tersedia' : 'Tak Tersedia' }}
                                            </span>
                                        </td>

                                        {{-- Action --}}
                                        <td class="text-center d-flex justify-content-center gap-2">
                                            <a href="{{ route('memberships.show', $membership->slug) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                                                <a href="{{ route('memberships.edit', $membership->slug) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-pencil-alt "></i>
                                                    </button>
                                                </a>
                                                <form action="{{ route('memberships.destroy', $membership->slug) }}"
                                                    method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-danger border-0 btn-hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki paket membership.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Daftar Paket Membership | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
