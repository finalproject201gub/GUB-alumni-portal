
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') | {{ config('app.name', 'GUB Alumni Portal') }}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}"> --}}
  <script src="https://kit.fontawesome.com/f16b98bd47.js" crossorigin="anonymous"></script>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('css/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">

 {{-- selec2 cdn --}}
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  @include('skeleton.admin.includes.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('skeleton.admin.includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('body')
  </div>
  <!-- /.content-wrapper -->
  @includeIf('skeleton.admin.includes.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('css/overlayScrollbars/js/OverlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="../../dist/js/demo.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        $('.select2-input').select2();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("input[type=date-time]", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        allowInput: true,
    });

    flatpickr("input[type=date]", {
        allowInput: true
    });
</script>
</body>
</html>
