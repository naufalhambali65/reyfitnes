@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2 text-primary"></i> Semua Anggota
                    </h2>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                        <div class="ms-auto">
                            <a href="{{ route('trainers.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Trainer
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
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Spesialis</th>
                                    <th>Status</th>
                                    <th>Pengalaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $trainer->user->name }}</span>
                                            <br>
                                            <span class="text-lowercase text-muted">{{ $trainer->user->email }}</span>
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ $trainer->user->phone ?? '' }}
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ ucwords($trainer->specialty) ?? '' }}
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($trainer->status == 'active')
                                                <span class="badge px-3 py-2 bg-success text-white">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge px-3 py-2 bg-secondary text-white">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ $trainer->years_experience ? $trainer->years_experience . ' Tahun' : '' }}
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <a href="{{ route('trainers.show', $trainer->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                                                <form action="{{ route('trainers.toggleStatus', $trainer->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-warning">
                                                        @if ($trainer->status == 'active')
                                                            <i class="fas fa-toggle-off"></i>
                                                        @else
                                                            <i class="fas fa-toggle-on"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- <a href="{{ route('trainers.status', $trainer->id) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt"></i> Ubah Status
                                                </button>
                                            </a> --}}

                                            {{-- <form action="{{ route('trainers.destroy', $trainer->id) }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-danger border-0 btn-hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form> --}}
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki anggota.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Daftar Instruktur | Rey Fitnes',
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
