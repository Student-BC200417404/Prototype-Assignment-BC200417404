<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Awaiken">
    <!-- Page Title -->
    <title>{{ config('app.name') }} -  @yield('title')</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <!-- Google Fonts Css-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&amp;display=swap"
        rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <!-- SlickNav Css -->
    <link href="{{ asset('/css/slicknav.min.css') }}" rel="stylesheet">
    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <!-- Font Awesome Icon Css-->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" media="screen">
    <!-- Animated Css -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <!-- Mouse Cursor Css File -->
    <link rel="stylesheet" href="{{ asset('css/mousecursor.css') }}">
    <!-- Main Custom Css -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<style>
  df-messenger {
   --df-messenger-bot-message: #878fac;
   --df-messenger-button-titlebar-color: #df9b56;
   --df-messenger-chat-background-color: #fafafa;
   --df-messenger-font-color: white;
   --df-messenger-send-icon: #878fac;
   --df-messenger-user-message: #479b3d;
  }
</style>
<body>

    <!-- Preloader Start -->
    <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="{{ asset('images/loader.svg') }}" alt=""></div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Header Start -->
    @include('template.header')
    <!-- Header End -->

    @yield('content')

    <!-- Main Footer Section Start -->
    @include('template.footer')
 
    <!-- Main Footer Section End -->

    <!-- Jquery Library File -->
    @include('template.script')
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>


<df-messenger
  intent="WELCOME"
  chat-title="eatz-ai-agent"
  agent-id="432e62ff-5ba4-43dd-b537-e26d52efc3c0"
  language-code="en"
></df-messenger>

    <!-- Custom js  -->
    @yield('scripts')
</body>


</html>
