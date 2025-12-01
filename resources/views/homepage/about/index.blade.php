@extends('homepage.layouts.main')
@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/homepage_assets/img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Tentang Kami</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Beranda</a>
                            <span>Tentang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
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

    <!-- About US Section Begin -->
    <section class="aboutus-section ">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-4 p-0">
                    <div class="about-video set-bg" data-setbg="/homepage_assets/img/reyfitnes/15.jpg">
                    </div>
                </div>

                <!-- Kolom kanan — tetap sama -->
                <div class="col-lg-8 p-0">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Tentang Kami</span>
                            <h2>Tentang Rey Fitnes</h2>
                        </div>

                        <div class="at-desc">
                            <p style="font-size: 16px; line-height: 1.8; text-align: justify;">
                                Rey Fitness hadir sebagai ruang bagi siapa saja yang ingin membangun versi terbaik dari
                                dirinya.
                                Kami percaya bahwa kebugaran bukan hanya tentang bentuk tubuh, tetapi tentang kesehatan,
                                kepercayaan diri, dan gaya hidup yang lebih baik. Dengan fasilitas yang nyaman, lingkungan
                                yang
                                bersahabat, serta instruktur profesional, Rey Fitness dirancang agar setiap member—baik
                                pemula
                                maupun atlet berpengalaman—dapat berkembang sesuai ritme dan tujuan masing-masing.
                            </p>

                            <p style="font-size: 16px; line-height: 1.8; text-align: justify;">
                                Kami menyediakan berbagai program latihan seperti strength training, kelas kebugaran, hingga
                                pelatihan pribadi yang disesuaikan dengan kebutuhan individu. Setiap sesi dan fasilitas
                                dirancang untuk memberikan pengalaman olahraga yang menyenangkan, aman, dan penuh motivasi.
                                Rey Fitness mengutamakan pendekatan menyeluruh: fokus pada fisik, mental, dan konsistensi
                                jangka panjang, sehingga setiap member dapat merasakan perubahan nyata yang berarti.
                            </p>

                            <p style="font-size: 16px; line-height: 1.8; text-align: justify;">
                                Komitmen kami adalah membantu masyarakat untuk menjalani hidup yang lebih aktif dan sehat.
                                Dengan komunitas yang hangat dan penuh dukungan, Rey Fitness bukan hanya tempat berlatih,
                                tetapi rumah bagi mereka yang ingin memulai perjalanan kebugarannya dengan semangat baru.
                                Bergabunglah bersama kami dan rasakan pengalaman fitness yang berbeda—lebih nyaman,
                                lebih personal, dan lebih berfokus pada hasil.
                            </p>
                        </div>

                        <!-- Bar persentase telah dihapus -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- About US Section End -->



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
                        <a href="https://api.whatsapp.com/send?phone=6282394880007&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                            "
                            class="primary-btn btn-normal appoinment-btn">BUAT JANJI</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ts-slider owl-carousel center">
                    @foreach ($trainers as $trainer)
                        <div class="col-lg-4">
                            <div class="ts-item set-bg"
                                data-setbg="{{ asset('storage/app/public/' . $trainer->user->image) }}">
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

    <!-- Banner Section Begin -->
    <section class="banner-section set-bg" data-setbg="/homepage_assets/img/banner-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text">
                        <h2>Registrasi Sekarang!</h2>
                        <div class="bt-tips">Dimana kesehatan, keindahan, dan kebugaran bertemu.</div>
                        <a href="https://api.whatsapp.com/send?phone=6282394880007&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                "
                            class="primary-btn btn-normal" target="_blank">Buat Janji</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
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
                            <li><a href="https://api.whatsapp.com/send?phone=6282394880007&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                    "
                                    target="_blank" style="text-decoration: none" class="text-white">+62 823 9488 0007</a>
                            </li>
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
