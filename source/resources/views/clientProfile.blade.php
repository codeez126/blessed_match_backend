<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ optional($user->clientAbout)->full_name ?? 'Asan Match' }}</title>
    <meta name="keywords" content="@yield('meta_keywords', 'Asan Match')">
    <meta name="description" content="@yield('meta_description', 'Asan Match')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/icon.png')}}"/>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="Asan Match">
    <meta property="og:image" content="{{ isset($fb_image)?asset($fb_image): asset('') }}"/>
    <meta property="og:title" content="{{ optional($user->clientAbout)->full_name ?? 'Asan Match' }}"/>
    <meta property="og:url" content="{{str_replace('www.','',url()->current())}}"/>
    <meta property="og:site_name" content="Asan Match"/>
    <meta property="og:type" content="Company"/>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{str_replace('www.','',url()->current())}}" />
    <meta name="twitter:title" content="{{ optional($user->clientAbout)->full_name ?? 'Asan Match' }}" />
    <meta name="twitter:description" content="{{ optional($user->clientAbout)->full_name ?? 'Asan Match' }}" />
    <meta name="twitter:image" content="{{ isset($tw_image)?asset($tw_image): asset('') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<style>
    .profile-card{
        background:#fff;
        border:1px solid rgba(0,0,0,0.06);
        box-shadow:0 6px 18px rgba(0,0,0,0.08);
        border-radius:12px;
        margin:18px 0;
        padding:16px;
        display:flex;
        align-items:center;
        gap:14px;
        transition:transform .18s ease,box-shadow .18s ease;
        width: 100%;
    }
    .first-container{
        text-align:center;
        color:#fff;
        font-weight:bold;
        background:linear-gradient(135deg,#8C37F8,#D51BF9);
        padding:10px;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        width: 100%;
    }
    .profile-image {
        border-radius: 50%;
        padding: 3px; /* border thickness */
        background: linear-gradient(135deg, #8C37F8, #D51BF9);
        display: inline-block;
    }

    .profile-image img {
        display: block;
        border-radius: 50%;
        background: #fff; /* inner background */
    }

</style>
<div class="container">

   <div class="profile-card">

           <div class="row">
               <div class="col-md-3 col-4">
                   <img class=" img-fluid profile-image" src="https://t4.ftcdn.net/jpg/03/64/21/11/360_F_364211147_1qgLVxv1Tcq0Ohz3FawUfrtONzz8nq3e.jpg" alt="">
               </div>
           </div>
   </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script></body>
</html>
