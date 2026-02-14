<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{ asset("admin-assets/plugins/fontawesome-free/css/all.min.css") }}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset("admin-assets/css/adminlte.min.css")}}>
    <link rel="stylesheet" href={{ asset("admin-assets/css/custom.css")}}>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.layouts.header')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src={{ asset("admin-assets/img/AdminLTELogo.png") }} alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">LARAVEL SHOP</span>
            </a>
            <!-- Sidebar -->
            @include('admin.layouts.sidebar')
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

            <strong>Copyright &copy; 2014-2022 AmazingShop All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src={{ asset("admin-assets/plugins/jquery/jquery.min.js") }}></script>
    <!-- Bootstrap 4 -->
    <script src={{ asset("admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
    <!-- AdminLTE App -->
    <script src={{ asset("admin-assets/js/adminlte.min.js") }}></script>
    <!-- AdminLTE for demo purposes -->
    <script src={{ asset("admin-assets/js/demo.js") }}></script>
       @yield('customJs')
       <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
       </script>
</body>

</html>