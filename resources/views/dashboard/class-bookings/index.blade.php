@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-check me-2 text-primary"></i> Daftar Booking Kelas
                    </h2>
                    {{-- <div class="ms-auto">
                        <a href="{{ route('class-bookings.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Booking
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Hari</th>
                                    <th>Pelatih</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classBookings as $booking)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="align-middle">
                                            <span
                                                class="text-capitalize fw-semibold">{{ $booking->member->user->name }}</span>
                                            <br>
                                            <span
                                                class="text-lowercase text-muted">{{ $booking->member->user->email }}</span>
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            <span class="text-capitalize fw-semibold">
                                                {{ $booking->class->name }}
                                            </span>
                                            <span class="text-lowercase text-muted">
                                                {{ $booking->class->category->name }}
                                            </span>
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ ucwords($booking->day) ?? '' }}
                                        </td>

                                        <td class="text-center align-middle fw-semibold">
                                            {{ ucwords($booking->class->trainer->user->name) }}
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($booking->status == 'active')
                                                <span class="badge px-3 py-2 bg-success text-white">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge px-3 py-2 bg-secondary text-white">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <a href="{{ route('class-bookings.show', $booking->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>

                                            <a href="{{ route('class-bookings.edit', $booking->id) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </a>

                                            <form action="{{ route('class-bookings.destroy', $booking->id) }}"
                                                method="post" class="d-inline">
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki booking kelas.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Daftar Booking Kelas | Rey Fitnes',
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
