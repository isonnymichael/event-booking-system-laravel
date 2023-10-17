<html>
    <head>
        <title>Savinc | @yield('title')</title>

        <link rel="icon" href="/favicon.png" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/adminlte.min.css">

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/js/adminlte.js"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="/plugins/raphael/raphael.min.js"></script>
        <script src="/plugins/jquery-mapael/jquery.mapael.min.js"></script>
        <script src="/plugins/jquery-mapael/maps/usa_states.min.js"></script>
        <!-- ChartJS -->
        <script src="/plugins/chart.js/Chart.min.js"></script>
    </head>

    <body>
        <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
            <div class="wrapper">

                @include('layouts.navbar')
                @include('layouts.sidebar')

                <div class="content-wrapper">
                    @yield('content')
                </div>

                @include('layouts.footer')
            </div>
    </body>
</html>