<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userId" content="{{ auth()->check() ? auth()->id() : '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}




    <!--  
    Favicons
    =============================================
    -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('user/assets/images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('user/assets/images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('user/assets/images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('user/assets/images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('user/assets/images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('user/assets/images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('user/assets/images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('user/assets/images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('user/assets/images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('user/assets/images/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('user/assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('user/assets/images/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('user/assets/images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('user/assets/images/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!--  fonts -->

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Volkhov:400i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <!-- Default stylesheets-->
    <link href="{{ asset('user/assets/lib/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('user/assets/lib/animate.css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/components-font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/et-line-font/et-line-font.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/flexslider/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/owl.carousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('user/assets/lib/simple-text-rotator/simpletextrotator.css') }}" rel="stylesheet">
    <!-- Main stylesheet and color file-->
    <link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet">
    <link id="color-scheme" href="{{ asset('user/assets/css/colors/default.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <div id="app">
        <main>
            <div class="main">
                <div class="col-lg-12">
                    @include('partial.flash')
                </div>
                
                @yield('content')
                <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
            </div>
        </main>

    </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <script src="{{ asset('user/assets/lib/jquery/dist/jquery.js') }}" ></script>
        <script src="{{ asset('user/assets/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('user/assets/lib/wow/dist/wow.js') }}"></script>
        <script src="{{ asset('user/assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js') }}"></script>
        <script src="{{ asset('user/assets/lib/isotope/dist/isotope.pkgd.js') }}"></script>
        <script src="{{ asset('user/assets/lib/imagesloaded/imagesloaded.pkgd.js') }}"></script>
        <script src="{{ asset('user/assets/lib/flexslider/jquery.flexslider.js') }}"></script>
        <script src="{{ asset('user/assets/lib/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('user/assets/lib/smoothscroll.js') }}"></script>
        <script src="{{ asset('user/assets/lib/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('user/assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js') }}"></script>
        <script src="{{ asset('user/assets/js/plugins.js') }}"></script>
        <script src="{{ asset('user/assets/js/main.js') }}"></script>
        <script src="{{ asset('user/assets/js/custom.js') }}"></script>
        @yield('script')
</body>
</html>
