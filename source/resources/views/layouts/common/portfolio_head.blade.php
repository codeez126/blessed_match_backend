<?php
$header=\App\Models\HeaderInfo::select('*')->first();
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<link rel="shortcut icon" type="image/png" href="{{asset('assets/logo/icon.png')}}"/>
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="robots" content="{{ isset($portfolio->is_index)&&$portfolio->is_index==1?'index, follow':'noindex,nofollow' }}">
{{--<meta name="robots" content="{{ 'noindex,nofollow' }}">--}}
<meta name="keywords" content="{{ $portfolio->meta_keywords??'' }}">
<meta name="description" content="{{ $portfolio->meta_description??'' }}">
<meta name="author" content="{{$header->siteName}}">

<meta property="og:image" content="{{ asset($images->first()->image ?? '') }}"/>
<meta property="og:title" content="{{ $portfolio->meta_title??'' }}"/>
<meta property="og:url" content="{{str_replace('www.','',url()->current())}}"/>
<meta property="og:site_name" content="{{$header->siteName}}"/>
<meta property="og:type" content="Company"/>
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{str_replace('www.','',url()->current())}}" />
<meta name="twitter:title" content="{{ $portfolio->meta_title??'' }}" />
<meta name="twitter:description" content="{{ $portfolio->meta_description??'' }}" />
<meta name="twitter:image" content="{{ asset($images->first()->image ?? '') }}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}

<link rel="canonical" href="{{str_replace('www.','',url()->current())}}" />
{{--swal fire buttons--}}
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/swal_fire_custom_css/styles.css')}}">
@if(Request::is('/'))
    <link rel="preload" as="image" href="{{ asset('assets/front/images/hero/m2.webp') }}">
    <link rel="preload" as="image" href="{{ asset('assets/front/images/hero/custom/1.png') }}">
    <link rel="preload" as="image" href="{{ asset('assets/front/images/hero/custom/2.png') }}">
    <link rel="preload" as="image" href="{{ asset('assets/front/images/hero/custom/3.png') }}">
@endif
{{--front--}}
<!-- Fraimwork - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/bootstrap.min.css">

<!-- Icon - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/fontawesome.css">

<!-- Animation - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/animate.min.css">

<!-- Carousel - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/swiper-bundle.min.css">

<!-- Video & Image Popup - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/magnific-popup.min.css">

<!-- Counter - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/odometer.min.css">

<!-- Custom - CSS Include -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/style.css">
<link rel="stylesheet" type="text/css" href="{{asset('assets/front')}}/css/custom.css">

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CreativeWork",
      "name": "{{ $portfolio->name }}",
      "description": "{{ strip_tags($portfolio->detail) }}",
      "url": "{{ url()->current() }}",
      "image": "{{ asset($images->first()->image) }}",
      "author": {
        "@type": "Organization",
        "name": "M2Logix"
      },
      "keywords": "{{ $portfolio->service->name }},
    @foreach($languages as $language)
        {{ $language->name }}{{ !$loop->last ? ', ' : '' }}
    @endforeach,
                  Mobile Application Development",
      "locationCreated": "{{ $portfolio->country }}",
      "mainEntityOfPage": "{{ url()->current() }}",
      "additionalProperty": [
    @if($portfolio->points && $portfolio->points->count() > 0)
        @foreach($portfolio->points as $point)
            {
              "@type": "PropertyValue",
              "name": "Key Point",
              "value": "{{ addslashes($point->point) }}"
                }{{ !$loop->last ? ',' : '' }}
        @endforeach
    @endif
    ]
  }
</script>
