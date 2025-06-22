<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Portal') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" media="screen">
    @stack('styles')
    <style>
        body { background: #18191a; font-family: 'Hanken Grotesk', Arial, sans-serif; }
    </style>
</head>
<body>
    @yield('content')
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/function.js') }}"></script>
    @stack('scripts')
</body>
</html> 