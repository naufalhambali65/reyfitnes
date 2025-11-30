<!-- Offcanvas Menu Section Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
        <i class="fa fa-close"></i>
    </div>

    <!-- Logo -->
    <div class="offcanvas-logo text-center mb-3">
        <a href="{{ route('home') }}">
            <img src="/homepage_assets/img/logo/logo.png" style="width: 160px; border-radius:6px" alt="ReyFitnes Logo">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="canvas-menu mobile-menu">
        <ul>
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href={{ route('about') }}>Tentang Kami</a></li>
            <li><a href="{{ route('bmi') }}">Kalkulator BMI</a></li>
            <li><a href="./contact.html">Kontak</a></li>
            <li><a href="{{ route('login') }}">Masuk</a></li>
        </ul>
    </nav>

    <div id="mobile-menu-wrap"></div>

    <!-- Social Icons -->
    <div class="canvas-social mt-3">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-youtube-play"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
</div>
<!-- Offcanvas Menu Section End -->
