<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $meta_title??'' }}</title>
    @include('layouts.common.head')
    @stack('styles')
</head>
<body>
@include('layouts.common.header')

@yield('contents')


@include('layouts.common.footer_contents')

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
