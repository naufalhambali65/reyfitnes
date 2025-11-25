@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-university me-2 text-primary"></i> Semua Rekening Bank
                    </h2>
                    <div class="ms-auto">
                        <a href="{{ route('banks.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Rekening
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
                                    <th>Nama Bank</th>
                                    <th>No. Rekening</th>
                                    <th>Nama Pemilik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $bank)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">{{ $loop->iteration }}</td>
                                        <td class="align-middle fw-semibold text-capitalize">{{ $bank->name }}</td>
                                        <td class="text-center align-middle fw-semibold text-primary">
                                            {{ $bank->account_number }}</td>
                                        <td class="text-center align-middle fw-semibold text-capitalize text-success">
                                            {{ $bank->account_holder_name }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <span
                                                class="badge px-3 py-2 {{ $bank->status == 'active' ? 'bg-success text-white' : 'bg-cyan text-white' }} ">
                                                {{ $bank->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td
                                            class="text-center align-middle fw-semibold d-flex justify-content-center gap-2">
                                            <a href="{{ route('banks.show', $bank->slug) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('banks.edit', $bank->slug) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt "></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('banks.destroy', $bank->slug) }}" method="post"
                                                class="d-inline ">
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki rekening bank.'
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
