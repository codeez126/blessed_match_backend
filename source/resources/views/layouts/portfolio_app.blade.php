<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $meta_title??'' }}</title>
    @include('layouts.common.portfolio_head')
    @stack('styles')
</head>
<body>
<div class="page_wrapper">


    @include('layouts.common.header')

    @if(!empty(session('subscribe_error')))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <main class="page_content">
        @yield('contents')
    </main>


    @include('layouts.common.footer_contents')
</div>

<script  rel="preload"  src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"
         type="text/javascript"></script>

@include('layouts.common.footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).ready(function() {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: true,
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            showConfirmButton: true,
        });
        @endif
    });



</script>

@stack('scripts')

</body>
</html>
