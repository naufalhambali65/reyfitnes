@extends('dashboard.layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>Buka Profil</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="{{ route('profile.index') }}" class="small-box-footer">Info Lebih Lanjut <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @if (auth()->user()->role != 'trainer')
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-cyan">
                    <div class="inner">
                        <h3>{{ $classCount }}</h3>
                        <p>Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-bookmarks"></i>
                    </div>
                    <a href="{{ route('classes.index') }}" class="small-box-footer">Info Lebih Lanjut <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $trainerCount }}</h3>
                        <p>Instruktur</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="{{ route('trainers.index') }}" class="small-box-footer">Info Lebih Lanjut <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $membershipCount }}</h3>
                        <p>Paket Membership</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-card"></i>
                    </div>
                    <a href="{{ route('memberships.index') }}" class="small-box-footer">Info Lebih Lanjut <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif
    </div>
@endsection
