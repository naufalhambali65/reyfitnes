@extends('dashboard.layouts.main')
@section('css')
    <style>
        /* Membuat scanner full responsive */
        #reader {
            width: 100% !important;
            max-width: 100%;
        }

        /* Membatasi tinggi scanner di HP / Tablet */
        @media (max-width: 768px) {
            #reader video {
                width: 100% !important;
                height: auto !important;
            }
        }
    </style>
@endsection
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-qrcode text-primary me-2"></i> Scan untuk absensi
                        </h4>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Responsive ROW -->
            <div class="row mb-3 g-3">

                <!-- QR SCANNER -->
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center align-center">

                            <!-- Tambah ratio agar scanner responsive -->
                            <div id="reader" style="width:100%;"></div>

                        </div>
                    </div>
                </div>

                <!-- USER CARD -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm h-100" id="userCard" style="display:none;">
                        <div class="card-body text-center">

                            <!-- Kontainer foto responsive -->
                            <div class="mx-auto" style="max-width: 300px;">
                                <img id="userPhoto" class="mb-3 img-fluid"
                                    style="width:100%;height:auto;object-fit:cover;border-radius:10px">
                            </div>

                            <h4 id="userName"></h4>
                            <p id="userEmail" class="text-muted mb-1"></p>
                            <p class="badge bg-primary mb-1" id="userMembership"></p>
                            <p class="text-muted">Tanggal Expired: <span id="expires_at"></span></p>

                            <button class="btn btn-success w-100 mt-3" id="confirmBtn">
                                Konfirmasi Kehadiran
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <form id="attendanceForm" action="{{ route('attendances.store') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="user_id" id="form_user_id">
        <input type="hidden" name="member_id" id="form_member_id">
        <input type="hidden" name="membership_id" id="form_membership_id">
    </form>
@endsection


@section('js')
    <script>
        let userId = null;
        let memberId = null;
        let membershipId = null;

        // Callback ketika QR berhasil discan
        function onScanSuccess(decodedText) {

            fetch("{{ route('attendances.scan') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        qr: decodedText
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        const dateString = data.user.membership_end_date;
                        const date = new Date(dateString);

                        const formatted = date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });

                        // console.log(data.user);
                        userId = data.user.id;
                        memberId = data.user.member_id;
                        membershipId = data.user.membership_id;

                        document.getElementById("userName").innerText = data.user.name;
                        document.getElementById("userEmail").innerText = data.user.email;
                        document.getElementById("userMembership").innerText = data.user.membership;
                        document.getElementById("userPhoto").src = data.user.photo;
                        document.getElementById("expires_at").innerText = formatted;

                        document.getElementById("userCard").style.display = "block";

                    } else {
                        alert(data.message);
                    }
                })
        }

        // Render scanner
        function getQrBoxSize() {
            const width = window.innerWidth;

            if (width <= 480) return 150;
            if (width <= 1024) return 220;
            // if (width <= 1024) return 250;
            return 300; // desktop
        }

        let scanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: getQrBoxSize()
        });

        scanner.render(onScanSuccess);

        document.getElementById("confirmBtn").addEventListener("click", function() {

            // Isi form hidden
            document.getElementById("form_user_id").value = userId;
            document.getElementById("form_member_id").value = memberId;
            document.getElementById("form_membership_id").value = membershipId;

            Swal.fire({
                title: 'Cek Kembali',
                text: "Semua data sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, sudah benar!',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("attendanceForm").submit();
                }
            });
        });
    </script>
@endsection
