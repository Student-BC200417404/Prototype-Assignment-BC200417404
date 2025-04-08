<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>EatzAI - Admin Dashboard</title>
  <link rel="icon" type="image/png" href="{{ asset('admin/images/favicon.png') }}" sizes="16x16">
  <!-- remix icon font css  -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('admin/css/remixicon.css') }}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/bootstrap.min.css') }}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/apexcharts.css') }}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/dataTables.min.css') }}">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/editor-katex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/lib/editor.atom-one-dark.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/lib/editor.quill.snow.css') }}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/flatpickr.min.css') }}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/full-calendar.css') }}">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/jquery-jvectormap-2.0.5.css') }}">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/magnific-popup.css') }}">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/slick.css') }}">
  <!-- prism css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/prism.css') }}">
  <!-- file upload css -->
  <link rel="stylesheet" href="{{ asset('admin/css/lib/file-upload.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin/css/lib/audioplayer.css') }}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</head>
  <body>

  <!-- sidebar starts  -->
  @include('admin.template.sidebar')
  <!-- sidebar ends  -->

<main class="dashboard-main">

   <!-- navbar start  -->

@include('admin.template.nav')

   <!-- navbar ends  -->

  <div class="dashboard-main-body">

   @yield('content')

  </div>

 @include('admin.template.footer')
</main>

@include('admin.template.script')

@stack('custom-scripts')

<form method="POST" action="{{ route('admin.logout') }}" class="d-none" id="logout-form">
    @csrf
</form>

<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <iconify-icon icon="solar:logout-2-outline" class="menu-icon"></iconify-icon>
    <span>Logout</span>
</a>

</body>

</html>
