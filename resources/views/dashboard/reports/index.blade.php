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
                        <h6>Membership Expired</h6>
                        <h3>{{ $totalMembersExpired }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <h6>Booking Kelas Hari Ini</h6>
                        <h3>{{ $totalBookingToday }}</h3>
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

            <div class="col-md-12 mt-4">
                <h5>📌 Booking Kelas Per Hari</h5>
                <canvas id="bookingChart"></canvas>
            </div>


        </div>

    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
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
@endsection
