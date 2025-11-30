@extends('homepage.layouts.main')
@section('container')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="/homepage_assets/img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                                <a href="#" class="primary-btn">Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="/homepage_assets/img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                                <a href="#" class="primary-btn">Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Mengapa memilih kami?</span>
                        <h2>DORONG BATAS DIRIMU LEBIH JAUH</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Peralatan Modern</h4>
                        <p>Kami menyediakan fasilitas terbaik dengan peralatan modern untuk mendukung latihan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Panduan Nutrisi Sehat</h4>
                        <p>Dapatkan rekomendasi nutrisi yang tepat agar hasil latihan Anda lebih maksimal.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Program Latihan Profesional</h4>
                        <p>Latihan dipandu oleh instruktur berpengalaman dengan program yang dirancang efektif.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
                        <h4>Disesuaikan Untuk Anda</h4>
                        <p>Program dirancang sesuai kebutuhan dan tujuan kebugaran setiap anggota.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ChoseUs Section End -->

    <!-- Classes Section Begin -->
    <section class="classes-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Kelas Kami</span>
                        <h2>APA YANG KAMI TAWARKAN</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($gymClasses as $class)
                    <div class="col-lg-4 col-md-6">
                        <div class="class-item">
                            <div class="ci-pic">
                                <img src="{{ asset('storage/' . $class->image) }}" alt="{{ $class->name }}"
                                    style="
                                    width: 100%;
                                    height: 400px;
                                    object-fit: cover;
                                ">
                            </div>
                            <div class="ci-text">
                                <span>{{ $class->category->name }}</span>
                                <h5>{{ $class->name }}</h5>
                                {{-- <a href="#"><i class="fa fa-angle-right"></i></a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Classes Section End -->

    <!-- Banner Section Begin -->
    <section class="banner-section set-bg" data-setbg="/homepage_assets/img/banner-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text">
                        <h2>Registrasi Sekarang!</h2>
                        <div class="bt-tips">Dimana kesehatan, keindahan, dan kebugaran bertemu.</div>
                        <a href="https://api.whatsapp.com/send?phone=6285185471994&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                "
                            class="primary-btn btn-normal" target="_blank">Buat Janji</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Paket Membership</span>
                        <h2>Pilih Paket Membership Anda!</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

                @foreach ($memberships as $membership)
                    <div class="col-lg-4 col-md-8">
                        <div class="ps-item">
                            <h3 class="mb-3">{{ $membership->name }}</h3>

                            <div class=" mb-2">
                                <h3 style="color: rgba(243, 97, 0);">
                                    {{ $membership->price_formatted }}
                                </h3>
                            </div>

                            <div class=" mb-2">
                                {!! $membership->features !!}
                            </div>

                            <a href="https://api.whatsapp.com/send?phone=6285185471994&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
"
                                class="primary-btn pricing-btn w-100 text-center" target="_blank">
                                Daftar Sekarang!
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Gallery Section Begin -->
    <div class="gallery-section">
        <div class="gallery">
            <div class="grid-sizer"></div>
            <div class="gs-item grid-wide set-bg" data-setbg="/homepage_assets/img/reyfitnes/01.jpg">
                <a href="/homepage_assets/img/reyfitnes/01.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="/homepage_assets/img/gallery/gallery-2.jpg">
                <a href="/homepage_assets/img/gallery/gallery-2.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="/homepage_assets/img/gallery/gallery-3.jpg">
                <a href="/homepage_assets/img/gallery/gallery-3.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="/homepage_assets/img/gallery/gallery-4.jpg">
                <a href="/homepage_assets/img/gallery/gallery-4.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="/homepage_assets/img/gallery/gallery-5.jpg">
                <a href="/homepage_assets/img/gallery/gallery-5.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item grid-wide set-bg" data-setbg="/homepage_assets/img/gallery/gallery-6.jpg">
                <a href="/homepage_assets/img/gallery/gallery-6.jpg" class="thumb-icon image-popup"><i
                        class="fa fa-picture-o"></i></a>
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>INSTRUKTUR KAMI</span>
                            <h2>BERLATIH DENGAN INSTRUKTUR PROFESIONAL</h2>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=6285185471994&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                            "
                            class="primary-btn btn-normal appoinment-btn">BUAT JANJI</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ts-slider owl-carousel center">
                    @foreach ($trainers as $trainer)
                        <div class="col-lg-4">
                            <div class="ts-item set-bg" data-setbg="{{ asset('storage/' . $trainer->user->image) }}">
                                <div class="ts_text">
                                    <h4>{{ ucwords($trainer->user->name) }}</h4>
                                    <span style="text-white">Instruktur Gym</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Komplek Bundaran Palupi Permai,
                            <br>
                            Jl. I Gusti Ngurah Rai No.5, RW.6,
                            <br>
                            Pengawu, Kec. Tatanga, Kota Palu,
                            <br>
                            Sulawesi Tengah 94222
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li><a href="https://api.whatsapp.com/send?phone=6285185471994&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                    "
                                    target="_blank" style="text-decoration: none" class="text-white">+62
                                    851-8547-1994</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>
                            <a href="mailto:reyfitnes.cs@gmail.com" style="text-decoration: none"
                                class="text-white">reyfitnes.cs@gmail.com</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->
@endsection
