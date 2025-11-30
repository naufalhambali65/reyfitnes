@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-bag me-2 text-primary"></i> Semua Produk
                    </h2>
                    <div class="ms-auto">
                        <a href="{{ route('product-stocks.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Produk
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
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga Jual</th>
                                    <th>Harga Modal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center align-middle fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $product->name }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $product->category->name }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span
                                                class="text-capitalize fw-semibold
                                                @if ($product->stock <= $product->min_stock && $product->stock > 0) text-warning
                                                @elseif($product->stock == 0)
                                                text-danger
                                                @else text-success @endif">
                                                {{ $product->stock }}
                                                {{ $product->unit->name }}</span>
                                        </td>
                                        <td
                                            class="text-center
                                                align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $product->price_formatted }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="text-capitalize fw-semibold">{{ $product->cost_formatted }}</span>
                                        </td>

                                        <td class="text-center align-middle d-flex justify-content-center gap-2">
                                            <a href="{{ route('product-stocks.show', $product->slug) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <button type="button" class="btn btn-info btn-stock" data-bs-toggle="modal"
                                                data-bs-target="#stockModal" data-slug="{{ $product->slug }}"
                                                data-name="{{ $product->name }}" data-stock="{{ $product->stock }}"
                                                title="Tambah / Kurangi Stok">
                                                <i class="fas fa-boxes"></i>
                                            </button>
                                            <a href="{{ route('product-stocks.edit', $product->slug) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </a>


                                            <form action="{{ route('product-stocks.destroy', $product->slug) }}"
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

    <!-- Modal: Tambah / Kurangi Stok -->
    <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="stockAdjustForm" method="POST" action="{{ route('product-stocks.adjust') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stockModalLabel">Ubah Stok Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_slug" id="modal_product_slug" value="">

                        <div class="mb-3">
                            <label class="form-label">Produk</label>
                            <input type="text" id="modal_product_name" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" id="modal_product_stock" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindakan</label>
                            <select name="action" id="modal_action" class="form-select" required>
                                <option value="add">Tambah</option>
                                <option value="subtract">Kurangi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" id="modal_quantity" class="form-control" min="1"
                                value="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="note" id="modal_note" class="form-control" rows="2" placeholder="Alasan/nota perubahan stok"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki riwayat pembayaran.'
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
    <script>
        // -----------------------------
        // Stock modal populate handler
        // -----------------------------
        $(document).on('click', '.btn-stock', function() {
            const slug = $(this).data('slug');
            const name = $(this).data('name');
            const stock = $(this).data('stock');

            $('#modal_product_slug').val(slug);
            $('#modal_product_name').val(name);
            $('#modal_product_stock').val(stock);
            $('#modal_quantity').val(1);
            $('#modal_action').val('add');
            $('#modal_note').val('');
        });

        // Optional: you can validate before submit or adjust UI
        $('#stockAdjustForm').on('submit', function(e) {
            // basic client-side validation: ensure quantity > 0
            const qty = parseInt($('#modal_quantity').val() || 0, 10);
            if (qty <= 0) {
                e.preventDefault();
                alert('Masukkan jumlah yang valid (minimal 1).');
                return false;
            }
            // allow normal submit (POST) to backend
            return true;
        });
    </script>
@endsection
