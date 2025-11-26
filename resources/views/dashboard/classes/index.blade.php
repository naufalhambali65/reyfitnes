@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-dumbbell me-2 text-primary"></i> Semua Kelas
                    </h2>
                    <div class="ms-auto">
                        <a href="{{ route('classes.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Kelas
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
                                    <th>Nama Kelas</th>
                                    <th>Kategori</th>
                                    <th>Instruktur </th>
                                    <th>Tingkat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gymClasses as $class)
                                    <tr>
                                        {{-- No --}}
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- Nama Kelas --}}
                                        <td class="align-middle fw-semibold">
                                            {{ $class->name }}
                                        </td>

                                        {{-- Kategori --}}
                                        <td class="text-center align-middle text-primary fw-semibold">
                                            {{ $class->category->name }}
                                        </td>

                                        {{-- Instruktur --}}
                                        <td class="text-center align-middle fw-semibold text-success text-">
                                            {{ ucwords($class->trainer->user->name) }}
                                        </td>

                                        {{-- Tingkat --}}
                                        <td class="text-center align-middle fw-semibold ">
                                            @if ($class->difficulty == 'advanced')
                                                Sulit
                                            @elseif($class->difficulty == 'intermediate')
                                                Menengah
                                            @else
                                                Mudah
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td class="text-center align-middle">
                                            <span
                                                class="badge px-3 py-2 {{ $class->status == 'active' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                {{ $class->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        {{-- Action --}}
                                        <td class="text-center d-flex justify-content-center gap-2">
                                            <a href="{{ route('classes.show', $class->slug) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('classes.edit', $class->slug) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt "></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('classes.destroy', $class->slug) }}" method="post"
                                                class="d-inline">
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki kelas.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        title: 'Daftar Kelas | REY FITNES'
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
