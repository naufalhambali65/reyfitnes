@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Edit Profile
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('profile.index') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn"><i
                                    class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    <div class="card-body pt-0 mt-0">
                        <div class="row p-3">
                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">
                                <input type="hidden" value="{{ $user->role }}" name="role">
                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email', $user->email) }}"
                                        required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama" name="name" value="{{ old('name', $user->name) }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">No WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="No WhatsApp" name="phone" value="{{ old('phone', $user->phone) }}"
                                        required />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($user->role == 'trainer')
                                    <!-- Specialty -->
                                    <div class="form-group mb-3">
                                        <label for="specialty" class="form-label">Spesialis</label>
                                        <input type="text" class="form-control @error('specialty') is-invalid @enderror"
                                            placeholder="Spesialis" name="specialty"
                                            value="{{ old('specialty', $user->trainer->specialty) }}" required />
                                        @error('specialty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Years Experience -->
                                    <div class="form-group mb-3">
                                        <label for="years_experience" class="form-label">Pengalaman (Tahun)</label>
                                        <input type="number"
                                            class="form-control @error('years_experience') is-invalid @enderror"
                                            placeholder="Pengalaman" name="years_experience"
                                            value="{{ old('years_experience', $user->trainer->years_experience) }}"
                                            required min="0" max="50" />
                                        @error('years_experience')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                        required>
                                        <option value="">-- Jenis Kelamin --</option>
                                        <option value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki -
                                            Laki
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Birth Date -->
                                <div class="form-group mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                        name="birth_date"
                                        value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}"
                                        required />
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Alamat"
                                        required>{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-md-6">
                                {{-- Image --}}
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Foto Wajah</label>
                                    @if ($user->image)
                                        <img src="{{ asset('public/storage/' . $user->image) }}"
                                            class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                            style="object-fit: cover;">
                                    @else
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                    @endif
                                    <input type="hidden" name="oldImage" value="{{ $user->image }}">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                @if ($user->role == 'trainer')
                                    {{-- Bio --}}
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">Bio</label>
                                        <input id="bio" type="hidden" name="bio"
                                            value="{{ old('bio', $user->trainer->bio) }}"
                                            class="@error('bio') is-invalid @enderror">
                                        <trix-editor input="bio"></trix-editor>
                                        @error('bio')
                                            <p class="text-danger">
                                                <small>{{ $message }}</small>
                                            </p>
                                        @enderror
                                    </div>
                                @endif
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
