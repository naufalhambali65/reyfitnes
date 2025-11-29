<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rey Fitnes | Dashboard</title>
    {{-- <link rel="icon" type="image/png" href="{{ asset('/homepage_assets/images/logo/favicon.png') }}"> --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/ekko-lightbox/ekko-lightbox.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"> --}}
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="/dashboard_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dashboard_assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/toastr/toastr.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="/dashboard_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/dashboard_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/dashboard_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    {{-- Boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


    {{-- Boostrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Trix --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>

    {{-- FilePond --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        .brand-link {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brand-link .brand-image {
            height: auto !important;
            /* biar ga dipaksa 33px */
            max-height: 120px;
            /* atur sesuai tinggi sidebar */
            width: 100% !important;
            /* biar full lebar */
            object-fit: contain;
            margin: 0 auto;
            /* center */
        }
    </style>


    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @php
        $role = auth()->user()->role;
    @endphp

    <div class="wrapper">

        @include('dashboard.layouts.navbar')
        @include('dashboard.layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('dashboard.layouts.header')
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('container')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>


        <footer class="main-footer">
            <div class="copyright">
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> <strong><span>Rey Fitnes</span></strong>. All Rights Reserved
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/dashboard_assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/dashboard_assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    {{-- <script src="/dashboard_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ChartJS -->
    <script src="/dashboard_assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/dashboard_assets/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/dashboard_assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/dashboard_assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/dashboard_assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/dashboard_assets/plugins/moment/moment.min.js"></script>
    <script src="/dashboard_assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/dashboard_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/dashboard_assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/dashboard_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="/dashboard_assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="/dashboard_assets/dist/js/adminlte.js"></script>
    <!-- Filterizr-->
    <script src="/dashboard_assets/plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/dashboard_assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="/dashboard_assets/plugins/toastr/toastr.min.js"></script>
    {{-- HTML 5 Qr Code --}}
    <script src="/dashboard_assets/dist/js/html5-qrcode.min.js"></script>


    <!-- DataTables  & Plugins -->
    <script src="/dashboard_assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/dashboard_assets/plugins/jszip/jszip.min.js"></script>
    <script src="/dashboard_assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/dashboard_assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/dashboard_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/dashboard_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    {{-- FilePond --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>





    <script>
        @if (session()->has('success'))
            $(document).ready(function() {
                toastr.success('{{ session('success') }}')
            });
        @elseif (session()->has('error'))
            $(document).ready(function() {
                toastr.error('{{ session('error') }}')
            });
        @endif
    </script>
    <script>
        $('.btn-logout').on('click', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Logout?',
                text: "Yakin akan logout?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data ini akan terhapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

    @yield('js')
</body>

</html>
