<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Favicons -->
	<!-- <link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/icon.png"> -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Stylesheets -->
	<!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}">
	<link rel="stylesheet" href="{{asset('frontend/css/style.css') }} ">
	<!-- Modernizer js -->
    <script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }} "></script>
    

</head>
<body>
    <div id="app">
	<div class="wrapper" id="wrapper">
      @include('partial.frontend.header')
    
        <main class="py-4">
		@include('partial.flash')

            @yield('content')
        </main>
      @include('partial.frontend.footer')

</div>
    </div>
    <script src="{{ asset('js/app.js') }}" ></script>

	<!-- JS Files -->
	<!-- <script src="js/vendor/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script> -->
	<script src="{{ asset('frontend/js/plugins.js') }}"></script>
	<script src="{{ asset('frontend/js/active.js') }}"></script>
	<script src="{{ asset('frontend/js/custome.js') }}"></script>
</body>
</html>
