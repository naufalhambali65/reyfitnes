<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rey Fitnes | Beranda</title>
    <link rel="icon" type="image/png" href="{{ asset('/homepage_assets/img/logo/logo.png') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/homepage_assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/homepage_assets/css/style.css" type="text/css">

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('homepage.layouts.offCanvas')
    @include('homepage.layouts.header')

    @yield('container')

    @include('homepage.layouts.footer')

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="/homepage_assets/js/jquery-3.3.1.min.js"></script>
    <script src="/homepage_assets/js/bootstrap.min.js"></script>
    <script src="/homepage_assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/homepage_assets/js/masonry.pkgd.min.js"></script>
    <script src="/homepage_assets/js/jquery.barfiller.js"></script>
    <script src="/homepage_assets/js/jquery.slicknav.js"></script>
    <script src="/homepage_assets/js/owl.carousel.min.js"></script>
    <script src="/homepage_assets/js/main.js"></script>

    @yield('js')

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            })
        </script>
    @endif



</body>

</html>
