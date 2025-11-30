@extends('homepage.layouts.main')
@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/homepage_assets/img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Kontak Kami</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Beranda</a>
                            <span>Kontak Kami</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title contact-title">
                        <span>Kontak Kami</span>
                        <h2>Hubungi Kami</h2>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-text">
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
                        <div class="cw-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li><a href="https://api.whatsapp.com/send?phone=6282394880007&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                    "
                                        target="_blank" style="text-decoration: none" class="text-white">+62 823 9488
                                        0007</a></li>
                            </ul>
                        </div>
                        <div class="cw-text email">
                            <i class="fa fa-envelope"></i>
                            <p>
                                <a href="mailto:reyfitnes.cs@gmail.com" style="text-decoration: none"
                                    class="text-white">reyfitnes.cs@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="leave-comment">
                        <form action="{{ route('messages.store') }}" method="post">
                            @csrf
                            <input type="text" placeholder="Nama" name="name">
                            <input type="email" placeholder="Email" name="email">
                            <input type="text" placeholder="Subjek" name="subject">
                            <textarea placeholder="Pesan" name="message"></textarea>
                            <button type="submit">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2966528910465!2d119.86130871175028!3d-0.9265367990605978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d8bf3005002529b%3A0x7c2dbfd0c3c81def!2sRey%20Fitnes!5e0!3m2!1sid!2sid!4v1764477002603!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

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
