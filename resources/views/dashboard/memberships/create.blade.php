@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form method="post" action="{{ route('memberships.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Tambah Paket membership
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('memberships.index') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn"><i
                                    class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" required autofocus value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="duration_days" class="form-label">Durasi (Hari)</label>
                                    <input type="number" class="form-control @error('duration_days') is-invalid @enderror"
                                        id="duration_days" name="duration_days" required autofocus
                                        value="{{ old('duration_days') }}" min="0">
                                    @error('duration_days')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <input id="description" type="hidden" name="description"
                                        value="{{ old('description') }}" class="@error('description') is-invalid @enderror">
                                    <trix-editor input="description"></trix-editor>
                                    @error('description')
                                        <p class="text-danger">
                                            <small>{{ $message }}</small>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" autofocus value="{{ old('price') }}" min="0">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="available" @selected(old('status') == 'available')>
                                            Tersedia
                                        </option>
                                        <option value="unavailable" @selected(old('status') == 'unavailable')>
                                            Tidak Tersedia
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="features" class="form-label">Benefit / Fitur</label>
                                    <input id="features" type="hidden" name="features" value="{{ old('features') }}"
                                        class="@error('features') is-invalid @enderror">
                                    <trix-editor input="features"></trix-editor>
                                    @error('features')
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
