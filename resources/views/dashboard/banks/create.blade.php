@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form method="post" action="{{ route('banks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Tambah Rekening Bank
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('banks.index') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn"><i
                                    class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" required autofocus value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Nomor Rekening</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                        id="account_number" name="account_number" required autofocus
                                        value="{{ old('account_number') }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="account_holder_name" class="form-label">Nama Pemilik Rekening</label>
                                    <input type="text"
                                        class="form-control @error('account_holder_name') is-invalid @enderror"
                                        id="account_holder_name" name="account_holder_name" required autofocus
                                        value="{{ old('account_holder_name') }}">
                                    @error('account_holder_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" @selected(old('status') == 'active')>
                                            Aktif
                                        </option>
                                        <option value="inactive" @selected(old('status') == 'unavailable')>
                                            Nonaktif
                                        </option>
                                    </select>
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
