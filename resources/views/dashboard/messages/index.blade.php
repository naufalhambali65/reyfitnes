@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-envelope me-2 text-primary"></i> Semua Pesan
                    </h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center align-middle">
                                <th style="width: 50px;">No</th>
                                <th style="width: 200px;">Nama &lt;Email&gt;
                                </th>
                                <th style="width: 200px;">Subjek</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $message->name }}
                                        {{ '<' . e($message->email) . '>' }}
                                    </td>
                                    <td class="text-center align-middle">{{ $message->subject }}</td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('messages.updateStatus', $message->id) }}" method="post"
                                            class="d-inline ">
                                            @method('put')
                                            @csrf
                                            <button type="submit"
                                                class="badge {{ $message->is_read == 0 ? 'badge-warning' : 'badge-success' }} border-0">
                                                {{ $message->is_read == 0 ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('messages.show', $message->id) }}">
                                            <button class="btn btn-success">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('messages.destroy', $message->id) }}" method="post"
                                            class="d-inline ">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger border-0 btn-hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- Bootstrap Js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script>
        $(function() {
            const exportButtons = ["copy", "csv", "excel", "pdf", "print"];

            $("#dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki pesan.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        title: 'Daftar Pesan | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
