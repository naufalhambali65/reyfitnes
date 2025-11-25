@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-check me-2 text-primary"></i> Daftar Kehadiran Hari Ini
                    </h2>
                    <div class="ms-auto">
                        <a href="{{ route('attendances.all') }}" class="btn btn-sm btn-info">
                            <i class="fas fa-list me-1"></i> Daftar Semua Kehadiran
                        </a>
                        <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Kehadiran
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Paket Membership</th>
                                    <th>Waktu Kehadiran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">{{ $loop->iteration }}</td>
                                        <td class="align-middle fw-semibold text-capitalize">
                                            {{ $attendance->membership->user->name }}</td>
                                        <td class="text-center align-middle fw-semibold text-primary">
                                            {{ $attendance->membership->membership->name }}</td>
                                        <td class="text-center align-middle fw-semibold">
                                            <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                                            {{ $attendance->check_in_at?->format('d M Y H:i') }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($attendance->status == 'late')
                                                <span class="badge px-3 py-2 bg-warning text-white">Terlambat</span>
                                            @elseif ($attendance->status == 'present')
                                                <span class="badge  px-3 py-2 bg-success text-white">Hadir</span>
                                            @else
                                                <span class="badge px-3 py-2 bg-danger text-white">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td
                                            class="text-center align-middle fw-semibold d-flex justify-content-center gap-2">
                                            <a href="{{ route('attendances.show', $attendance->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('attendances.edit', $attendance->id) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt "></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                method="post" class="d-inline ">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-danger border-0 btn-hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Tidak ada riwayat kehadiran.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Daftar Kehadiran | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
