<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>




        <!-- Favicon icon-->
        <link rel="icon" href="{{ asset('assets/admin/theme/images/favicon/favicon.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('assets/admin/theme/images/favicon/favicon.png') }}" type="image/x-icon">

        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'}}">

        <!-- Font awesome icon css -->
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/vendors/@fortawesome/fontawesome-free/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/vendors/@fortawesome/fontawesome-free/css/brands.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/vendors/@fortawesome/fontawesome-free/css/solid.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/vendors/@fortawesome/fontawesome-free/css/regular.css') }}">

        <!-- Ico Icon css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/theme/css/vendors/@icon/icofont/icofont.css') }}">

        <!-- Flag Icon css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/theme/css/vendors/flag-icon.css') }}">

        <!-- Themify Icon css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/theme/css/vendors/themify-icons/css/themify.css') }}">

        <!-- Animation css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/theme/css/vendors/animate.css/animate.css') }}">

        <!-- Weather Icon css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/theme/css/vendors/weather-icons/css/weather-icons.min.css') }}">

        <!-- App css-->
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/css/style.css') }}">
        <link id="color" rel="stylesheet" href="{{ asset('assets/admin/theme/css/color-1.css') }}" media="screen">



        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
    <div class="tap-top">
        <svg class="feather">
            <use href="C%3A%5CDownloaded%20Web%20Sites%5Cfurqanadminpanel%5Cadmin.pixelstrap.net%5Cedmin%5Cassets%5Csvg%5Cfeather-icons%5Cdist%5Cfeather-sprite.svg#arrow-up"></use>
        </svg>
    </div>
    <div class="container-fluid">
                {{ $slot }}
        <!-- jQuery -->
        <script src="{{ asset('assets/admin/theme/js/vendors/jquery/dist/jquery.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/admin/theme/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Config JS -->
        <script src="{{ asset('assets/admin/theme/js/config.js') }}"></script>

        <!-- Password JS -->
        <script src="{{ asset('assets/admin/theme/js/password.js') }}"></script>

        <!-- Custom Script -->
        <script src="{{ asset('assets/admin/theme/js/script.js') }}"></script>
    </div>
    </body>
</html>
