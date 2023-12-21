@extends('frontend.layout.master')
@section('frontend-head')
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAbukNOXKPE1M-2Duze7aLXcRLguKXbJQ&libraries=places&sensor=false">
</script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/vendors-rtl.min.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/vendors/css/file-uploaders/dropzone.min.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
<!-- END: Vendor CSS-->
<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/colors.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/components.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/themes/semi-dark-layout.css">
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/css-rtl/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/css-rtl/plugins/file-uploaders/dropzone.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/pages/data-list-view.css">
<!-- END: Page CSS-->
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/custom-rtl.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style-rtl.css">
<!-- END: Custom CSS-->
<link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css" />
<style>
    #map-canvas {
        width: 100%;
        height: 350px;
    }

    .fc-daygrid-block-event .fc-event-title {
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        font-family: sans;
        color: white;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: #adb5bd;
    }
</style>
@endsection
@section('frontend-main')
<!-- BEGIN: Content-->
<div class="content-body">
    <!-- Data list view starts -->
    <section id="data-thumb-view" class="data-thumb-view-header">
        @include('frontend.steps.estate_includes.estate_info')

        <!-- dataTable ends -->

        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> الاجراءات </h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="post" action="{{ route('client_level_inputs' , $estate->id) }}" id="myform"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        {{-- <div class="form-row">
                            <div class="col-sm-12 col-12">
                                <label for="accept">
                                    حالة الموافقة
                                </label>
                                <div class="form-group">
                                    <select name="accept" id="accept" class="select2 form-control">
                                        <option value="1">موافقة وارسال الى مدير المنشأة</option>
                                        <option value="2">رفض الطلب</option>
                                    </select>
                                </div>
                                @error('accept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        @if($estate->recieved_by_client ==0)
                        <div class="form-row">
                            <div class="col-md-12 col-12 mb-3">
                                <label for="note"> ملاحظة على الطلب </label>
                                <textarea rows="5" type="text" name="note" class="form-control" id="note"
                                    placeholder="اكتب ملاحظة على الطلب " value=""></textarea>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('pdf_pro' , $estate->id) }}">تصفح التقرير</a>
                        <br>
                        @endif
                        <hr id="last_hr">
                        <div class="flex-column d-flex flex-md-row justify-content-between align-items-center "
                            style="    gap: 1%;">
                           @if($estate->recieved_by_client ==1)
                           <button class=" btn btn-primary  mb-1 mb-md-0"
                           id="confirm_recieved">تأكيد استلام التقرير </button>
                           @else
                            @if($estate->process_start_date)
                                <button class=" btn btn-primary w-50 mb-1 mb-md-0"
                                id="submit_order">موافقة وإرسال إلى مدير المنشأة </button>
                                <span class="btn btn-danger w-50 mb-1 mb-md-0 return_order" data-return_to="reviewer" >إرجاع الطلب للمراجع</span>
                            @else
                                @if($estate->drafted_by)
                                    <a href="{{route('reopen_estate_order',$estate->id)}}"
                                    class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" ">إعادة فتح الطلب </a>
                                @else
                                    <button class=" btn btn-primary w-50 mb-1 mb-md-0" type="submit"
                                    id="submit_order">موافقة وإرسال إلى مدير المنشأة </button>
                                    <span class="btn btn-danger w-50 mb-1 mb-md-0" id="cancel_order">رفض الطلب</span>
                                @endif
                            @endif
                           @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Data list view end -->
</div>
<!-- END: Content-->
@endsection
@section('frontend-footer')
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
<script>
    $(document).ready(function () {
        $('#cancel_order').click(function (e) {
                e.preventDefault();
                $('#order_return').remove();
                $(this).text('انقر للتأكيد ...')
                if(!$('#draft_cancel').length) $('#myform').append('<input type="text" class="d-none" name="cancel" id="draft_cancel" value="cancel" >')
                // if($('#draft_note').length){
                    $('#myform').submit();
                // }else{
                //     $(`<div class="col-md-12 col-12 mb-3">
                //                         <label for="draft_note"> ملاحظة على الرفض </label>
                //                         <textarea rows="5" type="text" name="draft_note"
                //                                   class="form-control" id="draft_note" placeholder="اكتب ملاحظة على الطلب "
                //                                   value=""></textarea>
                //                     </div>`).insertBefore('#last_hr')
                // }

        });

        $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#draft_cancel').remove();
               $('#note').parent().show();
               $('#myform').submit();
        });
        $('#confirm_recieved').click(function (e) {
               e.preventDefault();
               $('#draft_cancel').remove();
               $('#note').parent().show();
               $('#myform').append(`<input type="text" class="d-none" name="confirm_recieved" id="confirm_recieved" value="recieved" >`)
               $('#myform').submit();
        });
        $('.return_order').click(function (e) {
                let return_to = $(this).data('return_to');
                e.preventDefault();
                $('#draft_cancel').remove();
                $(this).text('انقر للتأكيد ...')
                $('#note').parent().hide();
                if(!$('#order_return').length) $('#myform').append(`<input type="text" class="d-none" name="return" id="order_return" value="${return_to}" >`)
                if($('#draft_note').length){
                    $('#myform').submit();
                    $('#note').parent().show();
                }else{
                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="draft_note"> ملاحظة على الطلب </label>
                                        <textarea rows="5" type="text" name="draft_note"
                                                  class="form-control" id="draft_note" placeholder="اكتب ملاحظة على الطلب "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

        });
      })
</script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/dropzone.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset('frontend') }}/app-assets/js/core/app-menu.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/core/app.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/scripts/components.js"></script>
<script src="{{ asset('frontend') }}/custom-sweetalert.js"></script>
<script>
    {{ $estate->lat }}
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {
                    lat: {{ $estate->lat }},
                    lng: {{ $estate->lng }},
                },
                zoom: 15
            });
        var marker = new google.maps.Marker({
            position: {
                lat: {{ $estate->lat }},
                lng: {{ $estate->lng }},
            },
            map: map,
            draggable: false
        });
</script>
@endsection