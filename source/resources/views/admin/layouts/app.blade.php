<!DOCTYPE html>
<html lang="en">
 @include('admin.layouts.common.head')
<body>

<!-- loader-->
{{--<div class="loader-wrapper">--}}
{{--    <div class="loader"></div>--}}
{{--</div>--}}
@if(auth()->check())
<main class="page-wrapper compact-wrapper" id="pageWrapper">
    @include('admin.layouts.common.header')
    <div class="page-body-wrapper">
        @include('admin.layouts.common.sidebar')
@yield('contents')
        @include('admin.layouts.common.footer_content')
    </div>
</main>
    @else
<div class="alert bg-light-tertiary mb-0 default-border" role="alert">
    <h5 class="alert-heading pb-2">You Don't have the access or your Session's Time out</h5>
    <p>Please Login Again</p>
    <hr>
    <p class="mb-0">Consider moving clocks and plush animals from your area if you think they may be concealing cameras because they are both portable items.</p>
</div>

@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@include('admin.layouts.common.footer')
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
