<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $meta_title??'' }}</title>
    @include('layouts.common.head')
    @stack('styles')
</head>
<body>
<!-- page start -->
<div class="page">

    <!-- site-main start -->
    <div class="site-main">

        <section class="error-404 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-content">
                            <header class="page-header">
                                <h2 class="page-title">4<img width="163" height="164" class="img-fluid" src="{{asset('assets/front')}}/images/error-404.png" alt="image">4</h2>
                                <h2 class="page-title-text">OOPS!</h2>
                                <h3>Sorry we cant find that page!</h3>
                            </header>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 col-sm-10 col-10 m-auto">
                        <a class="prt-btn prt-btn-size-md prt-btn-style-fill prt-btn-color-darkcolor prt-btn-shape-round prt-btn-style-border prt-btn-color-whitecolor " href="{{url('/')}}">Back to home page</a>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- site-main end-->

    <!-- back-to-top start -->
    <a id="totop" href="#top">
        <i class="icon-angle-up"></i>
    </a>
    <!-- back-to-top end -->

</div><!-- page end -->

@include('layouts.common.footer')

</body>
</html>
