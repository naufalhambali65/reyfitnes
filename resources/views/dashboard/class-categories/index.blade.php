@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2 text-primary"></i> Semua Kategori Kelas
                    </h2>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-primary" id="btnAddCategory">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Kategori
                        </button>
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
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classCategories as $category)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $category->name }}</span>
                                        </td>

                                        <td class=" align-middle fw-semibold">
                                            {!! $category->description ?? '' !!}
                                        </td>


                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <button class="btn btn-primary btn-edit-category"
                                                data-slug="{{ $category->slug }}" data-name="{{ $category->name }}"
                                                data-description="{{ $category->description }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>


                                            <form action="{{ route('class-categories.destroy', $category->slug) }}"
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

    <!-- Modal Add/Edit Category -->
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="categoryForm" method="POST">
                    @csrf
                    <div id="formMethod"></div>

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalTitle">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" id="categoryName" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" id="categoryDescription" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki Kategori.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        title: 'Daftar Kategori Kelas | Rey Fitnes',
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(function() {

            // OPEN MODAL FOR CREATE
            $('#btnAddCategory').click(function() {
                $('#modalTitle').text('Tambah Kategori');
                $('#categoryForm').attr('action', "{{ route('class-categories.store') }}");
                $('#formMethod').html('');
                $('#categoryName').val('');
                $('#categoryDescription').val('');
                $('#categoryModal').modal('show');
            });

            // OPEN MODAL FOR EDIT
            $('.btn-edit-category').click(function() {
                let slug = $(this).data('slug');
                let name = $(this).data('name');
                let description = $(this).data('description');

                $('#modalTitle').text('Edit Kategori');
                $('#categoryForm').attr('action', '/dashboard/class-categories/' + slug);
                $('#formMethod').html('@method('PUT')');

                $('#categoryName').val(name);
                $('#categoryDescription').val(description);

                $('#categoryModal').modal('show');
            });

        });
    </script>
@endsection
