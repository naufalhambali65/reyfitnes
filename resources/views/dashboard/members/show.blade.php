@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">

                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>
                        Detail Anggota: {{ ucwords($user->name) }}
                    </h4>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEFT COLUMN (Profile) -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-user me-1"></i> Profil Anggota</h5>
                <div class="text-center">

                    <img src="{{ $user->image ? asset('public/storage/' . $user->image) : '/homepage_assets/img/default-profil.png' }}"
                        class="img-fluid rounded mb-3" style="max-width: 180px; height: auto; object-fit: cover;">

                    <h4 class="fw-bold mb-0">{{ ucwords($user->name) }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <span class="badge {{ $member->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($member->status == 'active' ? 'Aktif' : 'Nonaktif') }}
                    </span>
                </div>
                <hr>
                <h6 class="fw-semibold mb-2"><i class="fas fa-info-circle me-1"></i> Detail Lainnya</h6>

                <div class="row g-1">
                    @if (isset($user->gender))
                        <div class="col-5 col-md-4 text-muted">Jenis Kelamin</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}
                        </div>
                    @endif

                    @if (isset($user->phone))
                        <div class="col-5 col-md-4 text-muted">No. WhatsApp</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->phone }}</div>
                    @endif

                    @if (isset($user->address))
                        <div class="col-5 col-md-4 text-muted">Alamat</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->address }}</div>
                    @endif

                    @if (isset($user->birth_date))
                        <div class="col-5 col-md-4 text-muted">Tanggal Lahir</div>
                        <div class="col-7 col-md-8 text-muted">: {{ $user->birth_date->translatedFormat('d M Y') }}</div>
                    @endif
                </div>

            </div>

            <!-- Active Membership -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-id-card me-1"></i> Membership Aktif</h5>

                @if ($activeMembership)
                    <p class="mb-1 fw-bold">{{ $activeMembership->membership->name }}</p>
                    <p class="mb-0 text-muted">
                        {{ $activeMembership->start_date->translatedFormat('d M Y') }}
                        —
                        {{ $activeMembership->end_date->translatedFormat('d M Y') }}
                    </p>
                @else
                    <p class="text-muted">Tidak ada membership aktif</p>
                @endif
            </div>
            <!-- QR CODE -->
            <div class="card shadow-sm p-3 mt-3">
                <h5 class="fw-bold mb-3"><i class="fas fa-qrcode me-1"></i>QR Code Anggota</h5>

                @if ($activeMembership && $activeMembership->qr_code)
                    <div class="text-center">
                        <img src="{{ asset('public/storage/' . $activeMembership->qr_code) }}" alt="QR Code Member"
                            class="img-fluid mb-2" style="max-width: 180px; height: auto;">

                        <p class="small text-muted mb-0 mt-2">
                            Scan QR ini untuk check-in di pintu masuk
                        </p>
                        <!-- Tombol Download QR -->
                        <a href="{{ asset('public/storage/' . $activeMembership->qr_code) }}"
                            download="qr-member-{{ $member->id }}.png" class="btn btn-primary btn-sm mt-3">
                            <i class="fas fa-download me-1"></i> Download QR
                        </a>
                    </div>
                @else
                    <p class="text-muted">QR Code tidak tersedia</p>
                @endif
            </div>
        </div>


        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <!-- History Membership -->
            @if ($historyMemberships->count() > 0)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-history me-1"></i> Riwayat Membership
                            </h5>
                            @if ($historyMemberships->first()->status != 'pending')
                                @if (!$activeMembership)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addMembership">
                                        <i class="fas fa-plus-circle me-1"></i> Tambah Membership
                                    </button>
                                @endif
                            @endif
                        </div>


                        <div class="table-responsive" style="max-height: 300px">
                            <table class="table table-head-fixed table-bordered align-middle">
                                <thead class="table-light">
                                    <tr class="text-center align-middle">
                                        <th>Paket</th>
                                        <th>Mulai</th>
                                        <th>Berakhir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historyMemberships as $item)
                                        <tr class="text-center align-middle">
                                            <td>{{ $item->membership->name }}</td>
                                            <td>{{ $item->start_date ? $item->start_date->translatedFormat('d M Y') : '-' }}
                                            </td>
                                            <td>{{ $item->end_date ? $item->end_date->translatedFormat('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @elseif($item->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif($item->status == 'expired')
                                                    <span class="badge bg-secondary">Kadaluarsa</span>
                                                @else
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('memberships.show', $item->membership->slug) }}">
                                                    <button class="btn btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endif

            <!-- Attendance History -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-calendar-check me-1"></i> Riwayat Kehadiran</h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $att)
                                    <tr class="text-center align-middle">
                                        <td>{{ $att->check_in_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $att->check_in_at->format('H:i') }}</td>
                                        <td><span
                                                class="badge {{ $att->status = 'present' ? 'bg-success' : 'secondary' }}">{{ ucfirst($att->status = 'present' ? 'Hadir' : 'Tidak Hadir') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Payment History -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-wallet me-1"></i> Riwayat Pembayaran Membership</h5>

                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-head-fixed table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>Tanggal</th>
                                    <th>Membership</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyMemberships as $item)
                                    <tr class="text-center align-middle">
                                        <td>{{ $item->payment->created_at->translatedFormat('d M Y') }}</td>
                                        <td>{{ $item->membership->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($item->payment->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($item->payment->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @else
                                                <span class="badge bg-danger">Gagal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('payments.show', $item->payment->id) }}">
                                                <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- Booking Class History -->
            @if ($activeMembership && $activeMembership->membership->gymClasses->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-3"><i class="fas fa-dumbbell me-1"></i> Riwayat Booking Kelas</h5>
                            <button class="btn btn-sm btn-primary" onclick="openCreateModal()">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Booking Kelas
                            </button>
                        </div>
                        <div class="table-responsive" style="max-height: 300px">
                            <table class="table table-head-fixed table-bordered align-middle">
                                <thead class="table-light">
                                    <tr class="text-center align-middle">
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Pelatih</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classBookings as $booking)
                                        <tr class="text-center align-middle">
                                            <td>
                                                <span class="text-capitalize">
                                                    {{ $booking->class->name }}
                                                </span>
                                                <span class="text-lowercase text-muted">
                                                    {{ $booking->class->category->name }}
                                                </span>
                                            </td>

                                            <td class="text-center align-middle">
                                                {{ ucwords($booking->day) ?? '' }}
                                            </td>

                                            <td class="text-center align-middle">
                                                {{ ucwords($booking->class->trainer->user->name) }}
                                            </td>

                                            <td class="text-center align-middle">
                                                @if ($booking->status == 'active')
                                                    <span class="badge bg-success text-white">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary text-white">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-center align-middle d-flex justify-content-center gap-2">

                                                {{-- <a href="{{ route('class-bookings.edit', $booking->id) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                </a> --}}

                                                <button class="btn btn-primary"
                                                    onclick="openEditModal({{ $booking->id }}, '{{ $booking->day }}', {{ $booking->gym_class_id }})">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>


                                                <form action="{{ route('class-bookings.destroy', $booking->id) }}"
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
                </div>
            @endif

        </div>

    </div>

    <!-- Modal Add Membership-->
    <div class="modal fade" id="addMembership" tabindex="-1" aria-labelledby="addMembershipLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('members.addPayment', $member->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Pembayaran Membership
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">

                                <!-- Membership -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Pilih Membership</label>
                                    <select id="membershipSelect" name="membership_slug" class="form-control" required>
                                        <option value="">-- Pilih Membership --</option>
                                        @foreach ($memberships as $m)
                                            <option value="{{ $m->slug }}" data-price="{{ $m->price }}">
                                                {{ $m->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Amount (otomatis) -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Nominal Pembayaran</label>
                                    <input type="number" id="amountInput" class="form-control" name="amount"
                                        placeholder="Harga akan muncul otomatis" required readonly>
                                </div>

                                <!-- Metode Pembayaran -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select name="payment_method" id="paymentMethod" class="form-control" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="qris">QRIS</option>
                                        <option value="cash">Tunai</option>
                                    </select>
                                </div>

                                <!-- Select Bank (muncul hanya saat transfer) -->
                                <div class="form-group mb-3 d-none" id="bankWrapper">
                                    <label class="form-label">Pilih Bank</label>
                                    <select name="bank_id" class="form-control">
                                        <option value="">-- Pilih Bank --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-md-6">

                                <!-- Notes -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Catatan (Opsional)</label>
                                    <textarea name="notes" class="form-control" rows="6" placeholder="Catatan tambahan (opsional)"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @if ($activeMembership && $activeMembership->membership->gymClasses->count() > 0)
        <!-- Modal Booking Kelas -->
        <div class="modal fade" id="classBookingModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form id="classBookingForm" method="POST">
                        @csrf
                        <input type="hidden" id="methodField">
                        <input type="hidden" name="member_id" id="memberInput" value="{{ $member->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Tambah Booking Kelas</h5>
                        </div>

                        <div class="modal-body">

                            <!-- Pilih Hari -->
                            <div class="mb-3">
                                <label class="form-label">Hari</label>
                                <select name="day" id="dayInput" class="form-control" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="monday">Senin</option>
                                    <option value="tuesday">Selasa</option>
                                    <option value="wednesday">Rabu</option>
                                    <option value="thursday">Kamis</option>
                                    <option value="friday">Jumat</option>
                                    <option value="saturday">Sabtu</option>
                                    <option value="sunday">Minggu</option>
                                </select>
                            </div>

                            <!-- Pilih Kelas -->
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="gym_class_id" id="classInput" class="form-control" required>
                                    <option value="">Pilih Kelas</option>

                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->name }} — {{ $class->category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

@endsection
@section('js')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('addMembership'));
                myModal.show();
            });
        </script>
    @endif
    <script>
        // Update harga otomatis
        document.getElementById('membershipSelect').addEventListener('change', function() {
            let price = this.options[this.selectedIndex].getAttribute('data-price');
            document.getElementById('amountInput').value = price ?? '';
        });

        // Tampilkan / sembunyikan select bank
        document.getElementById('paymentMethod').addEventListener('change', function() {
            let bankWrapper = document.getElementById('bankWrapper');

            if (this.value === 'transfer') {
                bankWrapper.classList.remove('d-none');
            } else {
                bankWrapper.classList.add('d-none');
            }
        });
    </script>
    {{-- Script Modal Booking Kelas --}}
    {{-- <script>
        function openCreateModal() {
            $("#modalTitle").text("Tambah Booking Kelas");
            $("#saveBtn").text("Simpan");

            $("#classBookingForm").attr("action", "{{ route('class-bookings.store') }}");
            $("#methodField").remove();

            $("#dayInput").val("");
            $("#classInput").val("");

            $("#classBookingModal").modal("show");
        }

        function openEditModal(booking) {
            $("#modalTitle").text("Edit Booking Kelas");
            $("#saveBtn").text("Update");

            $("#classBookingForm").attr("action", "/class-bookings/" + booking.id);

            $("#methodField").remove();
            $("#classBookingForm").prepend('<input type="hidden" name="_method" value="PUT" id="methodField">');

            $("#dayInput").val(booking.day);
            $("#classInput").val(booking.gym_class_id);

            $("#classBookingModal").modal("show");
        }
    </script> --}}

    <script>
        // === CREATE ===
        function openCreateModal() {
            // Set title
            document.getElementById('modalTitle').innerText = "Tambah Booking Kelas";

            // Set form action
            document.getElementById('classBookingForm').action = "{{ route('class-bookings.store') }}";

            // Remove method PUT
            document.getElementById('methodField').value = "";

            // Clear inputs
            document.getElementById('dayInput').value = "";
            document.getElementById('classInput').value = "";

            // Set button text
            document.getElementById('saveBtn').innerText = "Simpan";

            // Open modal
            new bootstrap.Modal(document.getElementById('classBookingModal')).show();
        }

        // === EDIT ===
        function openEditModal(id, day, classId) {
            // Set title
            document.getElementById('modalTitle').innerText = "Edit Booking Kelas";

            // Form action route
            document.getElementById('classBookingForm').action = "/dashboard/class-bookings/" + id;

            // Add PUT method
            document.getElementById('methodField').outerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            // Fill inputs
            document.getElementById('dayInput').value = day;
            document.getElementById('classInput').value = classId;

            // Set button text
            document.getElementById('saveBtn').innerText = "Update";

            // Open modal
            new bootstrap.Modal(document.getElementById('classBookingModal')).show();
        }
    </script>
@endsection
