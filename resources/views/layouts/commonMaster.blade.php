<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>SK STEELS TECH</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('logo.webp') }}" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Optional: Bootstrap CSS for form-control styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">



  <!-- Include Styles -->
  @include('layouts/sections/styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>


  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->



  <!-- Include Scripts -->
  @include('layouts/sections/scripts')
  @stack('scripts')
  <!-- SweetAlert2 Script CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
  <script>
    @if(session('success'))
    Swal.fire({
      toast: true,
      position: 'bottom-end',
      icon: 'success',
      title: `{!! session('success') !!}`,
      background: '#d4edda',
      color: '#155724',
      showConfirmButton: false,
      timer: 4000,
      timerProgressBar: true
    });
    @elseif(session('error'))
    Swal.fire({
      toast: true,
      position: 'bottom-end',
      icon: 'error',
      title: `{!! session('error') !!}`,
      background: '#f8d7da',
      color: '#721c24',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
    @elseif(session('info'))
    Swal.fire({
      toast: true,
      position: 'bottom-end',
      icon: 'info',
      title: `{!! session('info') !!}`,
      background: '#d1ecf1',
      color: '#0c5460',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
    @elseif(session('warning'))
    Swal.fire({
      toast: true,
      position: 'bottom-end',
      icon: 'warning',
      title: `{!! session('warning') !!}`,
      background: '#fff3cd',
      color: '#856404',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
    @endif
  </script>


</body>

</html>