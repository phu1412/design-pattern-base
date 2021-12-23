<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head')
</head>

<body class="style-14 index-2">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<!-- Start Loading -->
<section class="loading-overlay">
	<div class="Loading-Page">
		<h1 class="loader">Loading...</h1>
	</div>
</section>
<!-- End Loading  -->

@include('partials.header')
<!-- start main content -->
<main class="main-container">

@yield('content')


</main>
<!-- end main content -->



<div class="container">

</div>



@include('partials.footer')

<!-- All script -->
<script src="{{asset('js/vendor/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
{{--  <script src="{{asset('js/smoothscroll.js')}}"></script>  --}}
<!-- Scroll up js
============================================ -->
<script src="{{asset('js/jquery.scrollUp.js')}}"></script>
<script src="{{asset('js/menu.js')}}"></script>
<!-- new collection section script -->
<script src="{{asset('js/swiper/idangerous.swiper.min.js')}}"></script>
<script src="{{asset('js/swiper/swiper.custom.js')}}"></script>


<script src="{{asset('js/pluginse209.js?v=1.0.0')}}"></script>

<!-- Magnific Popup -->
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset('js/jquery.countdown.min.js')}}"></script>

<!-- SLIDER REVOLUTION SCRIPTS  -->
<script type="text/javascript" src="{{asset('rs-plugin/js/jquery.themepunch.plugins.min.js')}}"></script>
<script type="text/javascript" src="{{asset('rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
<!-- Owl carousel -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

<script type="text/javascript" src="{{asset('js/slide.js')}}"></script>
@yield('js')

</body>


</html>