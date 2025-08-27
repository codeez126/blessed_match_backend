<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$user->clientAbout->full_name}}</title>
    <meta name="keywords" content="@yield('meta_keywords', 'Online Packaging Store')">
    <meta name="description" content="@yield('meta_description', 'Online Packaging Store')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/icon.png')}}"/>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="robots" content="{{ isset($is_index)&&$is_index==1?'index, follow':'noindex,nofollow' }}">
    <meta name="author" content="OPS">
    <meta property="og:image" content="{{ isset($fb_image)?asset($fb_image): asset('') }}"/>
    <meta property="og:title" content="@yield('meta_keywords', 'Online Packaging Store')"/>
    <meta property="og:url" content="{{str_replace('www.','',url()->current())}}"/>
    <meta property="og:site_name" content="Online Packaging Store"/>
    <meta property="og:type" content="Company"/>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{str_replace('www.','',url()->current())}}" />
    <meta name="twitter:title" content="@yield('meta_title', 'Online Packaging Store')" />
    <meta name="twitter:description" content="@yield('meta_description', 'Online Packaging Store')" />
    <meta name="twitter:image" content="{{ isset($tw_image)?asset($tw_image): asset('') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script></body>
</html>
