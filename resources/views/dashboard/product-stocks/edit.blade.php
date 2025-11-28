@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form action="{{ route('product-stocks.update', $product->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Update Produk
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('product-stocks.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>

                    <div class="card-body pt-0 mt-0">
                        <div class="row p-3">

                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">

                                <!-- Nama Produk -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama Produk" name="name" value="{{ old('name', $product->name) }}"
                                        required />

                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Kategori Produk -->
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Kategori Produk</label>
                                    <select name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror" required>

                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Unit Produk -->
                                <div class="form-group mb-3">
                                    <label for="unit_id" class="form-label">Satuan Produk</label>
                                    <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror"
                                        required>

                                        <option value="">-- Pilih Satuan --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('unit_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Harga Jual -->
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Harga" name="price" value="{{ old('price', $product->price) }}"
                                        required step="0.01" min="0" />

                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Harga Modal -->
                                <div class="form-group mb-3">
                                    <label for="cost" class="form-label">Harga Modal</label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                        placeholder="Harga Modal" name="cost" value="{{ old('cost', $product->cost) }}"
                                        step="0.01" min="0" />

                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-md-6">

                                <!-- Stok Produk -->
                                <div class="form-group mb-3">
                                    <label for="stock" class="form-label">Stok Awal</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Stok" name="stock" value="{{ old('stock', $product->stock) }}"
                                        min="0" required />

                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Min Stok -->
                                <div class="form-group mb-3">
                                    <label for="min_stock" class="form-label">Minimal Stok</label>
                                    <input type="number" class="form-control @error('min_stock') is-invalid @enderror"
                                        placeholder="Minimal Stok" name="min_stock"
                                        value="{{ old('min_stock', $product->min_stock) }}" min="0" required />

                                    @error('min_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status Produk -->
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror"
                                        required>

                                        <option value="available"
                                            {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>
                                            Tersedia</option>
                                        <option value="unavailable"
                                            {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>
                                            Tidak Tersedia</option>

                                    </select>

                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gambar Produk -->
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Gambar Produk</label>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/public/' . $product->image) }}"
                                            class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                            style="object-fit: cover;">
                                    @else
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                    @endif
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    <input type="hidden" name="oldImage" value="{{ $product->image }}">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Deskripsi Produk -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Produk</label>

                                    <input id="description" type="hidden" name="description"
                                        value="{{ old('description', $product->description) }}">
                                    <trix-editor input="description"></trix-editor>

                                    @error('description')
                                        <p class="text-danger">
                                            <small>{{ $message }}</small>
                                        </p>
                                    @enderror
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
