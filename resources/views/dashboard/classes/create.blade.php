@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form method="post" action="{{ route('classes.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Tambah Kelas
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('classes.index') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn"><i
                                    class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" required autofocus value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori Kelas</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == '{{ $category->id }}')>
                                                {{ ucwords($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="trainer_id" class="form-label">Instruktur</label>
                                    <select class="form-select" id="trainer_id" name="trainer_id" required>
                                        @foreach ($trainers as $trainer)
                                            <option value="{{ $trainer->id }}" @selected(old('trainer_id') == '{{ $trainer->id }}')>
                                                {{ ucwords($trainer->user->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="membership_id" class="form-label">Paket Membership</label>
                                    <select class="form-select" id="membership_id" name="membership_id" required>
                                        @foreach ($memberships as $membership)
                                            <option value="{{ $membership->id }}" @selected(old('membership_id') == '{{ $membership->id }}')>
                                                {{ ucwords($membership->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" @selected(old('status') == 'active')>
                                            Aktif
                                        </option>
                                        <option value="inactive" @selected(old('status') == 'inactive')>
                                            Nonaktif
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="difficulty" class="form-label">Tingkat Kesulitan</label>
                                    <select class="form-select" id="difficulty" name="difficulty" required>
                                        <option value="beginner" @selected(old('difficulty') == 'beginner')>
                                            Pemula
                                        </option>
                                        <option value="intermediate" @selected(old('difficulty') == 'intermediate')>
                                            Menengah
                                        </option>
                                        <option value="advanced" @selected(old('difficulty') == 'advanced')>
                                            Sulit
                                        </option>
                                    </select>
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="image" class="form-label">Foto Sampul</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <input id="description" type="hidden" name="description"
                                        value="{{ old('description') }}"
                                        class="@error('description') is-invalid @enderror">
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
{{-- @section('js')
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
@endsection --}}
