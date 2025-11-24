@extends('dashboard.layouts.main')
@section('css')
    <style>
        .membership-card {
            transition: 0.2s;
            border-radius: 10px;
        }

        .membership-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 1);
        }

        .disabled-card {
            opacity: 0.4;
            pointer-events: none;
            transform: none !important;
        }

        .selected-card {
            border: 2px solid #28a745 !important;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.4) !important;
        }

        .border-dashed {
            border-style: dashed !important;
            border-color: #adb5bd !important;
        }
    </style>
@endsection
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2 text-primary"></i> Semua Anggota
                    </h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Nama</th>
                                    {{-- <th>Kontak</th> --}}
                                    <th>Jenis Kelamin</th>
                                    {{-- <th>Tanggal Akun Dibuat</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">{{ $user->name }}
                                            <br> {{ $user->email }}
                                        </td>
                                        {{-- <td class="text-center align-middle">{{ $user->phone ?? '-' }}
                                        </td> --}}
                                        <td class="text-center align-middle">
                                            {{ $user->gender ? ($user->gender = 'male' ? 'Laki - Laki' : 'Perempuan') : '-' }}
                                        </td>
                                        {{-- <td class="text-center align-middle">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td> --}}
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-success btn-select-user mb-1"
                                                data-user='@json($user)'>
                                                <i class="fas fa-check "></i>
                                            </button>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form action="#" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf
                    @method('PUT')
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus me-2 text-primary"></i> Form Membership
                        </h2>
                        <div class="ms-auto">
                            <a href="{{ route('members.index') }}" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2" id="submitBtn" disabled><i
                                    class="fas fa-credit-card"></i> Bayar</button>
                        </div>
                    </div>
                    <div class="alert alert-primary d-none mb-0" id="selectedUserBox">
                        Pengguna Terpilih: <strong id="selectedUserName"></strong>
                        <button type="button" class="btn btn-sm btn-danger float-end" id="resetSelection">
                            Reset Pilihan
                        </button>
                    </div>
                    <div class="card-body pt-0 mt-0">
                        <div class="row p-3">
                            <h2>Data Anggota :</h2>
                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email') }}" required disabled />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama" name="name" value="{{ old('name') }}" required disabled />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">No WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="No WhatsApp" name="phone" value="{{ old('phone') }}" required
                                        disabled />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                        required disabled>
                                        <option value="">-- Jenis Kelamin --</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki - Laki
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
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
                                        name="birth_date" value="{{ old('birth_date') }}" required disabled />
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Alamat"
                                        required disabled>{{ old('address') }}</textarea>
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
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input type="hidden" name="oldImage">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()" disabled>
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="my-4 border-top border-2 border-dashed"></div>
                        <h2>Paket Membership :</h2>
                        <div class="row p-3">
                            @foreach ($memberships as $membership)
                                <div class="col-md-4 mb-4">
                                    <div class="card membership-card shadow-sm" data-slug="{{ $membership->slug }}">
                                        <div class="card-body">

                                            <h5 class="card-title fw-bold text-primary">{{ $membership->name }}</h5>
                                            <p class="card-text text-muted mb-1">Harga: {{ $membership->price_formatted }}
                                            </p>
                                            <p class="card-text text-muted mb-1">Durasi: {{ $membership->duration_days }}
                                                Hari
                                            </p>
                                            <p class="card-text small">{!! $membership->description !!}</p>

                                            <div class="d-flex justify-content-between mt-3">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#membershipDetailModal"
                                                    onclick="showMembershipDetail({{ $membership->id }})">
                                                    Detail
                                                </button>

                                                <div>
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm choose-package-btn"
                                                        onclick="choosePackage('{{ $membership->slug }}', this)" disabled>
                                                        Pilih
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm btn-cancel d-none"
                                                        onclick="cancelPackage('{{ $membership->slug }}')"
                                                        data-id="{{ $membership->id }}">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- input hidden -->
                            <input type="hidden" name="membership_slug" id="membership_slug">
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="membershipDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Membership</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4 id="detail_name"></h4>
                    <p class="text-muted" id="detail_description"></p>
                    <h6>Harga</h6>
                    <p class="text-muted" id="price"></p>
                    <h6>Durasi</h6>
                    <p class="text-muted" id="duration_days"></p>

                    <h6>Fitur:</h6>
                    <div id="detail_features"></div>

                    <hr>

                    <h6>Kelas Termasuk:</h6>
                    <ul id="detail_classes"></ul>

                </div>
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
                    emptyTable: '<i class="fas fa-info-circle me-1"></i> Anda belum memiliki anggota.'
                },
                buttons: $.map(exportButtons, function(btn) {
                    return {
                        extend: btn,
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        title: 'Daftar Anggota | Rey Fitnes',
                    };
                })
            }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
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

        function previewImageFromUrl(url) {
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block';
            imgPreview.src = url;
        }
    </script>
    <script>
        $('.btn-select-user').on('click', function() {
            const user = $(this).data('user');

            document.querySelectorAll('.form-control').forEach(input => {
                input.disabled = false;
            });
            document.querySelectorAll('.choose-package-btn').forEach(input => {
                input.disabled = false;
            });

            const user_id = user.id;

            const form = document.getElementById('userForm');
            form.setAttribute(
                'action',
                "{{ route('users.update', ':id') }}".replace(':id', user_id)
            );

            // Tampilkan box user terpilih
            $('#selectedUserBox').removeClass('d-none');
            $('#selectedUserName').text(user.name + " / " + user.email);

            // Isi field form
            $('input[name="email"]').val(user.email);
            $('input[name="name"]').val(user.name);
            $('input[name="phone"]').val(user.phone ?? "");
            $('select[name="gender"]').val(user.gender ? (user.gender == 'Laki - Laki' ? 'male' : 'female') : '');
            $('input[name="birth_date"]').val(user.birth_date ?? "");
            $('input[name="oldImage"]').val(user.image ?? "");
            $('textarea[name="address"]').val(user.address ?? "");

            // Jika ada foto → tampilkan
            if (user.image) {
                previewImageFromUrl("/storage/" + user.image);
            } else {
                $('.img-preview').attr("src", "").hide();
            }
        });

        // Tombol Reset Pilihan
        $('#resetSelection').on('click', function() {
            document.querySelectorAll('.form-control').forEach(input => {
                input.disabled = true;
            });
            document.querySelectorAll('.choose-package-btn').forEach(input => {
                input.disabled = true;
            });
            document.getElementById("submitBtn").disabled = true;

            const form = document.getElementById('userForm');
            form.setAttribute('action', '#');
            // Hilangkan box user terpilih
            $('#selectedUserBox').addClass('d-none');
            $('#selectedUserName').text("");

            // Kosongkan form
            $('input[name="email"]').val("");
            $('input[name="name"]').val("");
            $('input[name="phone"]').val("");
            $('select[name="gender"]').val("");
            $('input[name="birth_date"]').val("");
            $('input[name="image"]').val("");
            $('input[name="oldImage"]').val("");
            $('textarea[name="address"]').val("");

            // Hapus foto
            $('.img-preview').attr("src", "").hide();
        });
    </script>
    {{-- Script Paket Membership --}}
    <script>
        const memberships = @json($memberships);

        function formatRupiahWithComma(amount) {
            // ubah ke string dan hilangkan karakter non-digit
            let numberString = amount.toString().replace(/[^,\d]/g, "");

            // buat format ribuan
            let split = numberString.split(",");
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            // tambahkan ,00 jika tidak ada digit desimal
            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah + ",00";

            return "Rp. " + rupiah;
        }


        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }

        function showMembershipDetail(id) {
            const m = memberships.find(item => item.id === id);

            console.log(m);

            document.getElementById('detail_name').textContent = m.name;
            document.getElementById('price').textContent = formatRupiahWithComma(m.price);
            document.getElementById('duration_days').textContent = `${m.duration_days} Hari`;
            document.getElementById('detail_description').innerHTML =
                m.description ? decodeHtml(m.description) : '-';

            const features = m.features ? decodeHtml(m.features).split("\n") : [];
            document.getElementById('detail_features').innerHTML =
                features.map(f => `${f}`).join('');

            document.getElementById('detail_classes').innerHTML =
                m.gym_classes.length ?
                m.gym_classes.map(c => `<li>${c.name} (${c.difficulty})</li>`).join('') :
                '<li>Tidak ada kelas</li>';
        }

        function choosePackage(slug, btn) {
            document.getElementById('membership_slug').value = slug;
            document.getElementById("submitBtn").disabled = false;

            // Disable semua card lain
            document.querySelectorAll('.membership-card').forEach(card => {
                if (card.dataset.slug !== slug) {
                    card.classList.add('disabled-card');
                } else {
                    card.classList.add('selected-card');
                }
            });

            // Toggle tombol pilih
            document.querySelectorAll('.choose-package-btn').forEach(b => {
                b.classList.remove('btn-success');
                b.classList.add('btn-primary');
                b.textContent = "Pilih";
            });

            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            btn.textContent = "Dipilih ✓";

            // Tampilkan tombol cancel di card ini
            btn.closest("div").querySelector(".btn-cancel").classList.remove("d-none");
        }

        function cancelPackage(slug) {
            document.getElementById('membership_slug').value = "";
            document.getElementById("submitBtn").disabled = true;

            // Enable semua card
            document.querySelectorAll('.membership-card').forEach(card => {
                card.classList.remove('disabled-card');
                card.classList.remove('selected-card');
            });

            // Reset tombol pilih
            document.querySelectorAll('.choose-package-btn').forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
                btn.textContent = "Pilih";
            });

            // Semua tombol cancel disembunyikan
            document.querySelectorAll('.btn-cancel').forEach(btn => {
                btn.classList.add("d-none");
            });
        }
    </script>
@endsection
