<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="images/star.png" type="favicon/ico" /> -->
    <meta name="description" content="Reserve Eat All is a hyrbrid reservation application for nepo quad restaurants in angeles city pampanga philippines">
    <meta name="keywords" content="reserve-eatall, Reserve Eat All NepoQuad, reserve, reservation, booking reservation, nepoquad, nepoquadrestaurants, foodreservation, angelescity, thequad, food">


    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pricing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert.css') }}">
    <script src="{{ asset('assets/js/rate.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.flexslider.min.js') }}"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                controlsContainer: ".flexslider-container"
            });
        });
    </script>

</head>
<body data-spy="scroll" data-target="#template-navbar">

@include('includes.navbar')

@yield('content')
<!-- Sweetalert -->
@include('sweetalert::view')

{{--@include('includes.header')--}}

{{--@include('includes.about')--}}

{{--@include('includes.menu')--}}

{{--@include('includes.ribbon')--}}

{{--@include('includes.beer')--}}

{{--@include('includes.breakfastRibbon')--}}

{{--@include('includes.bread')--}}

{{--@include('includes.featuredMenu')--}}

{{--@include('includes.dishSliderRibbon')--}}

@include('includes.footer')

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.mixitup.min.js') }}" ></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.hoverdir.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jQuery.scrollSpeed.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

</body>
</html>