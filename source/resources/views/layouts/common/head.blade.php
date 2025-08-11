<?php
$header=\App\Models\HeaderInfo::select('*')->first();
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<link rel="shortcut icon" type="image/png" href="{{asset('assets/logo/icon.png')}}"/>
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
{{--<meta name="robots" content="{{ isset($is_index)&&$is_index==1?'index, follow':'noindex,nofollow' }}">--}}
<meta name="robots" content="{{ 'noindex,nofollow' }}">
<meta name="keywords" content="{{ $meta_keywords??'' }}">
<meta name="description" content="{{ $meta_description??'' }}">
<meta name="author" content="{{$header->siteName}}">

<meta property="og:image" content="{{ asset('https://m2logix.com/assets/pages/1.webp')}}"/>
<meta property="og:title" content="{{ $meta_title??'' }}"/>
<meta property="og:url" content="{{str_replace('www.','',url()->current())}}"/>
<meta property="og:site_name" content="{{$header->siteName}}"/>
<meta property="og:type" content="Company"/>
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{str_replace('www.','',url()->current())}}" />
<meta name="twitter:title" content="{{ $meta_title??'' }}" />
<meta name="twitter:description" content="{{ $meta_description??'' }}" />
<meta name="twitter:image" content="{{ asset('https://m2logix.com/assets/pages/1.webp')}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="canonical" href="{{str_replace('www.','',url()->current())}}" />
{{--swal fire buttons--}}
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/swal_fire_custom_css/styles.css')}}">
{{--Theme css--}}
<link rel="stylesheet" href="{{asset('assets/front')}}/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/animate.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/all.min.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/swiper.min.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/lightcase.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/style.css">
<link rel="stylesheet" href="{{asset('assets/front')}}/css/custom.css">
