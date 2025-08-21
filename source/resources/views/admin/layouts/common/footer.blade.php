<!-- jQuery -->
<script src="{{ asset('assets/admin/theme/js/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/admin/theme/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="{{ asset('assets/admin/theme/js/config.js') }}"></script>
<!-- Sidebar JS -->
<script src="{{ asset('assets/admin/theme/js/sidebar.js') }}"></script>
<!-- Apexcharts JS -->
{{--<script src="{{ asset('assets/admin/theme/js/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>--}}

<!-- Chart.js -->
{{--<script src="{{ asset('assets/admin/theme/js/vendors/chart.js/dist/chart.umd.js') }}"></script>--}}
<!-- Datatable JS -->
{{--<script src="{{ asset('assets/admin/theme/js/vendors/simple-datatables/dist/umd/simple-datatables.js') }}"></script>--}}
<!-- Default Dashboard JS -->
{{--<script src="{{ asset('assets/admin/theme/js/dashboard/default.js') }}"></script>--}}
<!-- Scrollbar JS -->
{{--<script src="{{ asset('assets/admin/theme/js/scrollbar/simplebar.js') }}"></script>--}}
{{--<script src="{{ asset('assets/admin/theme/js/scrollbar/custom.js') }}"></script>--}}
<!-- Customizer -->
{{--<script src="{{ asset('assets/admin/theme/js/theme-customizer/customizer.js') }}"></script>--}}
<!-- Custom Script -->
<script src="{{ asset('assets/admin/theme/js/script.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    $('#example').DataTable({
        paging: true,         // Enable pagination
        searching: true,      // Enable searching
        ordering: true,       // Enable column ordering
        info: true            // Show table information
    });

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
