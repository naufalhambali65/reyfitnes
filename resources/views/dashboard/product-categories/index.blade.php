@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2 text-primary"></i> Semua Kategori Produk
                    </h2>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-primary" id="btnAddCategory">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Kategori
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $category->name }}</span>
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <button class="btn btn-primary btn-edit-category"
                                                data-slug="{{ $category->slug }}" data-name="{{ $category->name }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>


                                            <form action="{{ route('product-categories.destroy', $category->slug) }}"
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2 text-primary"></i> Semua Satuan Unit Produk
                    </h2>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-primary" id="btnAddUnit">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Satuan
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productUnits as $unit)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $unit->name }}</span>
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <button class="btn btn-primary btn-edit-unit" data-id="{{ $unit->id }}"
                                                data-name="{{ $unit->name }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>


                                            <form action="{{ route('product-units.destroy', $unit->id) }}" method="post"
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
    <!-- Modal Add/Edit Unit -->
    <div class="modal fade" id="unitModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="unitForm" method="POST">
                    @csrf
                    <div id="formUnitMethod"></div>

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalUnitTitle">Tambah Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Unit</label>
                            <input type="text" class="form-control" name="name" id="unitName" required>
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
                            columns: [0, 1]
                        },
                        title: 'Daftar Kategori Produk | Rey Fitnes',
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
                $('#categoryForm').attr('action', "{{ route('product-categories.store') }}");
                $('#formMethod').html('');
                $('#categoryName').val('');
                $('#categoryModal').modal('show');
            });

            // OPEN MODAL FOR EDIT
            $('.btn-edit-category').click(function() {
                let slug = $(this).data('slug');
                let name = $(this).data('name');

                $('#modalTitle').text('Edit Kategori');
                $('#categoryForm').attr('action', '/dashboard/product-categories/' + slug);
                $('#formMethod').html('@method('PUT')');

                $('#categoryName').val(name);

                $('#categoryModal').modal('show');
            });

        });

        $(function() {

            // OPEN MODAL FOR CREATE
            $('#btnAddUnit').click(function() {
                $('#modalTitle').text('Tambah Unit Produk');
                $('#unitForm').attr('action', "{{ route('product-units.store') }}");
                $('#formUnitMethod').html('');
                $('#unitName').val('');
                $('#unitModal').modal('show');
            });

            // OPEN MODAL FOR EDIT
            $('.btn-edit-unit').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#modalUnitTitle').text('Edit Unit');
                $('#unitForm').attr('action', '/dashboard/product-units/' + id);
                $('#formUnitMethod').html('@method('PUT')');

                $('#unitName').val(name);

                $('#unitModal').modal('show');
            });

        });
    </script>
@endsection
