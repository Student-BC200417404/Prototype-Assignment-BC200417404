<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard') - SpicyHunt Restaurant</title>
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

  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
  
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
  
  <!-- DatePicker CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  
  <!-- TimePicker CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" rel="stylesheet">
  
  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  
  @stack('styles')
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DatePicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- TimePicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<!-- Moment.js for datetime -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CRUD Operations JS -->
<script src="{{ asset('admin/js/crud-operations.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/admin/js/app.js') }}"></script>

<script>
    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Cleanup DataTables before page unload to prevent reinitialisation errors
    $(window).on('beforeunload', function() {
        if (typeof clearAllDataTables === 'function') {
            clearAllDataTables();
        }
    });
    
    // Cleanup DataTables when navigating with Turbolinks (if used)
    $(document).on('turbolinks:before-cache', function() {
        if (typeof clearAllDataTables === 'function') {
            clearAllDataTables();
        }
    });
    
    // Prevent DataTable reinitialisation errors
    $(document).on('click', 'a[href]', function() {
        // Only cleanup if it's a navigation link (not AJAX or modal triggers)
        const href = $(this).attr('href');
        if (href && href !== '#' && !href.startsWith('javascript:') && !$(this).data('toggle')) {
            // Small delay to allow navigation to complete
            setTimeout(function() {
                if (typeof clearAllDataTables === 'function') {
                    clearAllDataTables();
                }
            }, 100);
        }
    });
</script>

</body>

</html>
