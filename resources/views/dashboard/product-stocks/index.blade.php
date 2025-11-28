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
                                                @if ($product->stock == $product->min_stock) text-warning
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
@endsection
