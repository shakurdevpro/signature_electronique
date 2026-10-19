<!DOCTYPE html>
<html lang="fr" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="mfp">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="...">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('img/logo.jpg') }}">
    <!-- Page Title  -->
    <title>@yield('title') - Plateforme de signature electronique E-Sign</title>
    @yield('styles')
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('signature/assets/css/dashlite.css?ver=2.4.0') }} ">
    <link id="skin-default" rel="stylesheet" href="{{ asset('public/signature/assets/css/theme.css?ver=2.4.0') }}">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main -->
        <div class="nk-main ">
            @include('sections.sidebar')
            <!-- wrap -->
            <div class="nk-wrap ">
                @include('sections.header')
                @yield('content')
                @include('sections.footer')
            </div>
            <!-- wrap -->
        </div>
        <!-- main -->
    </div>
    <!-- app-root -->
    @yield('scripts')
    <!-- JavaScript -->
    <script src="{{ asset('signature/assets/js/bundle.js?ver=2.4.0') }}"></script>
    <script src="{{ asset('signature/assets/js/scripts.js?ver=2.4.0') }}"></script>
    <script src="{{ asset('signature/assets/js/charts/chart-ecommerce.js?ver=2.4.0') }}"></script>
</body>

</html>
