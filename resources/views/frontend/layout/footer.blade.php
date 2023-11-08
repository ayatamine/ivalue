@section('frontend-footer')
@show
<!-- BEGIN: sweett alert JS-->
<script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/polyfill.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/scripts/ui/data-list-view.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/scripts/extensions/sweet-alerts.js"></script>
<!-- END: sweett alert JS-->
<script src="{{ asset('frontend') }}/custom-sweetalert.js"></script>
<script src="{{ asset('frontend') }}/mine.js"></script>

<script>
    var url = '/estate/public';
    $(document).ready(function() {
        $('.alert').fadeIn('fast').delay(5000).fadeOut('slow');
    });
</script>