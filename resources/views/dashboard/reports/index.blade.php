@extends('dashboard.layouts.main')

@section('container')
    <div class="container-fluid">

        <h3 class="mb-4">📊 Laporan & Statistik Gym</h3>

        <div class="row">

            <div class="col-md-3">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h6>Membership Aktif</h6>
                        <h3>{{ $totalMembersActive }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h6>Membership Kadaluarsa</h6>
                        <h3>{{ $totalMembersExpired }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h6>Pemasukan Bulan ini</h6>
                        <h3>Rp. {{ $incomeThisMonth }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        <h6>Produk Low Stock</h6>
                        <h3>{{ $lowStockProducts }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-5">

            <div class="col-md-6">
                <h5>📌 Membership Per Bulan</h5>
                <canvas id="membershipChart"></canvas>
            </div>

            <div class="col-md-6">
                <h5>📌 Pendapatan Per Bulan</h5>
                <canvas id="incomeChart"></canvas>
            </div>

            {{-- <div class="col-md-12 mt-4">
                <h5>📌 Booking Kelas Per Hari</h5>
                <canvas id="bookingChart"></canvas>
            </div> --}}


        </div>
        <hr class="my-5">

        <div class="row">
            <div class="col-md-6">
                <h5>📌 Penjualan Produk Per Bulan</h5>
                <canvas id="productSalesChart"></canvas>
            </div>

            <div class="col-md-6">
                <h5>📌 Pendapatan Membership Per Bulan</h5>
                <canvas id="membershipIncomeChart"></canvas>
            </div>
        </div>


    </div>
@endsection
{{-- @section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // product
        const productSalesCtx = document.getElementById('productSalesChart');
        new Chart(productSalesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($productSalesPerMonth->keys()) !!},
                datasets: [{
                    label: 'Penjualan Produk',
                    data: {!! json_encode($productSalesPerMonth->values()) !!},
                    backgroundColor: 'purple'
                }]
            }
        });

        // Membership penjualan
        const membershipIncomeCtx = document.getElementById('membershipIncomeChart');
        new Chart(membershipIncomeCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($membershipIncomePerMonth->keys()) !!},
                datasets: [{
                    label: 'Pendapatan Membership',
                    data: {!! json_encode($membershipIncomePerMonth->values()) !!},
                    borderColor: 'red',
                    borderWidth: 2
                }]
            }
        });


        // === Membership ===
        const membershipCtx = document.getElementById('membershipChart');
        new Chart(membershipCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($membershipPerMonth->keys()) !!},
                datasets: [{
                    label: 'Membership Baru',
                    data: {!! json_encode($membershipPerMonth->values()) !!},
                    borderWidth: 2,
                    borderColor: 'blue'
                }]
            }
        });

        // === Pendapatan ===
        const incomeCtx = document.getElementById('incomeChart');
        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($incomePerMonth->keys()) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($incomePerMonth->values()) !!},
                    backgroundColor: 'green'
                }]
            }
        });

        // === Booking kelas ===
        const bookingCtx = document.getElementById('bookingChart');
        new Chart(bookingCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($bookingPerDay->keys()) !!},
                datasets: [{
                    label: 'Booking',
                    data: {!! json_encode($bookingPerDay->values()) !!},
                    borderColor: 'orange',
                    borderWidth: 2
                }]
            }
        });
    </script>
@endsection --}}

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // helper: ubah array keys (bisa number atau string) jadi "Mon YYYY"
        function formatMonthLabels(rawLabels) {
            const currentYear = new Date().getFullYear();

            return rawLabels.map((l) => {
                // jika sudah berisi spasi (mis. "Jan 2025" atau "Jan-2025"), kembalikan apa adanya
                if (typeof l === 'string' && l.match(/[a-zA-Z]/)) {
                    return l;
                }

                // jika label berbentuk "YYYY-MM" atau "YYYY-M" -> parse tahun dan bulan
                if (typeof l === 'string' && l.match(/^\d{4}[-/]\d{1,2}$/)) {
                    const parts = l.split(/[-/]/);
                    const year = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    return new Date(year, month, 1).toLocaleString('default', {
                        month: 'short',
                        year: 'numeric'
                    });
                }

                // jika numeric (1..12), gunakan bulan itu di tahun sekarang
                const monthNumber = parseInt(l, 10);
                if (!isNaN(monthNumber)) {
                    return new Date(currentYear, monthNumber - 1, 1).toLocaleString('default', {
                        month: 'short',
                        year: 'numeric'
                    });
                }

                // fallback: kembalikan apa adanya
                return String(l);
            });
        }

        // === Product Sales Per Month (bar) ===
        const rawProductSalesLabels = {!! json_encode($productSalesPerMonth->keys()) !!};
        const productSalesLabels = formatMonthLabels(rawProductSalesLabels);

        const productSalesCtx = document.getElementById('productSalesChart');
        new Chart(productSalesCtx, {
            type: 'bar',
            data: {
                labels: productSalesLabels,
                datasets: [{
                    label: 'Penjualan Produk',
                    data: {!! json_encode($productSalesPerMonth->values()) !!},
                    backgroundColor: 'purple'
                }]
            }
        });

        // === Membership Income Per Month (line) ===
        const rawMembershipIncomeLabels = {!! json_encode($membershipIncomePerMonth->keys()) !!};
        const membershipIncomeLabels = formatMonthLabels(rawMembershipIncomeLabels);

        const membershipIncomeCtx = document.getElementById('membershipIncomeChart');
        new Chart(membershipIncomeCtx, {
            type: 'line',
            data: {
                labels: membershipIncomeLabels,
                datasets: [{
                    label: 'Pendapatan Membership',
                    data: {!! json_encode($membershipIncomePerMonth->values()) !!},
                    borderColor: 'red',
                    borderWidth: 2
                }]
            }
        });

        // === Membership Per Month (line) ===
        const rawMembershipLabels = {!! json_encode($membershipPerMonth->keys()) !!};
        const membershipLabels = formatMonthLabels(rawMembershipLabels);

        const membershipCtx = document.getElementById('membershipChart');
        new Chart(membershipCtx, {
            type: 'line',
            data: {
                labels: membershipLabels,
                datasets: [{
                    label: 'Membership Baru',
                    data: {!! json_encode($membershipPerMonth->values()) !!},
                    borderWidth: 2,
                    borderColor: 'blue'
                }]
            }
        });

        // === Income Per Month (bar) ===
        const rawIncomeLabels = {!! json_encode($incomePerMonth->keys()) !!};
        const incomeLabels = formatMonthLabels(rawIncomeLabels);

        const incomeCtx = document.getElementById('incomeChart');
        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: incomeLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($incomePerMonth->values()) !!},
                    backgroundColor: 'green'
                }]
            }
        });

        // === Booking kelas ===
        // bookingPerDay likely contains dates (YYYY-MM-DD) so we keep it as-is
        const bookingCtx = document.getElementById('bookingChart');
        if (bookingCtx) {
            new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bookingPerDay->keys()) !!},
                    datasets: [{
                        label: 'Booking',
                        data: {!! json_encode($bookingPerDay->values()) !!},
                        borderColor: 'orange',
                        borderWidth: 2
                    }]
                }
            });
        }
    </script>
@endsection
