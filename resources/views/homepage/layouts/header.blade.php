<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="/homepage_assets/img/logo/logo.png"
                            style="width: 200px; background: rgba(243, 97, 0); border-radius:6px" alt="ReyFitnes Logo">
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <nav class="nav-menu">
                    <ul>
                        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="{{ Request::is('about*') ? 'active' : '' }}"><a href="{{ route('about') }}">Tentang
                                Kami</a></li>
                        <li class="{{ Request::is('bmi*') ? 'active' : '' }}"><a href="{{ route('bmi') }}">Kalkulator
                                BMI</a></li>
                        <li class="{{ Request::is('contact*') ? 'active' : '' }}"><a
                                href="{{ route('contact') }}">Kontak</a>
                        </li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2">
                <div class="top-option">
                    {{-- <div class="to-search search-switch">
                        <i class="fa fa-search"></i>
                    </div> --}}
                    <div class="to-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas-open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header End -->
