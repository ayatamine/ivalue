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
                <h4 class="card-title"> المدخلات </h4>
            </div>
            <div class="card-content">
                <div class="card-body">

                    <form method="post" action="{{ route('level_inputs' , ['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" id="myform"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-row">
                            <div class="col-sm-12 col-12">
                                <label for="accept">
                                    الدفعات التي تم دفعها في حالة الموافقة
                                </label>
                                <div class="form-group">
                                    @foreach($estate->payments as $payment)
                                    <label for="accept">
                                        <!--<input {{ $payment->done == 1 ? 'disabled checked ' : '' }} type="checkbox" name="payment[]" value="{{ $payment->id }}">-->
                                        {{ $payment->price }} ريال
                                    </label>
                                    <br />
                                    @endforeach
                                </div>
                                @error('accept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- @if(auth()->user()->hasRole('manager'))
                        <div class="form-row">
                            <div class="col-sm-12 col-12">
                                <label for="accept">
                                    حالة الموافقة
                                </label>
                                <div class="form-group">
                                    <select name="accept" id="accept" class="select2 form-control">
                                        <option value="1">موافقة وارسال الى العميل </option>
                                        <option value="2">رفض والرجوع الى مدير التقييم</option>
                                    </select>
                                </div>
                                @error('accept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @else --}}
                        {{-- @if(!auth()->user()->hasRole('manager'))
                        <a href="{{ route('pdf_pro' , $estate->id) }}">تصفح التقرير</a>
                        <br>
                        <div class="form-row">
                            <div class="col-sm-12 col-12">
                                <label for="accept">
                                    حالة الموافقة
                                </label>
                                <div class="form-group">
                                    <select name="accept" id="accept" class="select2 form-control">
                                        <option value="1">اعتماد التقرير و وارسالة الى اعتماد قيمة </option>
                                        <option value="2">رفض والرجوع الى مدير التقييم</option>
                                    </select>
                                </div>
                                @error('accept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <!--<div class="form-row rel_part">-->
                        <!--    <div class="col-sm-12 col-12">-->
                        <!--        <label for="accept">-->
                        <!--           اعتماد قيمة-->
                        <!--        </label>-->
                        <!--        <div class="form-group">-->
                        <!--             <div class="col-sm-12 col-12">-->

                        <!--       <div class="form-group">-->
                        <!--            <input placeholder="رقم التسجيل في قيمة  " name="qema_code" id="qema_code"-->
                        <!--                    class="form-control" type="number" required>-->

                        <!--        </div>-->


                        <!--    </div>-->
                        <!--        </div>-->

                        <!--    </div>-->
                        <!--</div>-->
                        {{-- @endif --}}
                        <div class="form-row">
                            <div class="col-sm-12 col-12">
                                <label for="stats">
                                    حالة الاستلام من طرف العميل
                                </label>
                                <div class="form-group">
                                    @if($estate->recieved_by_client == 0)
                                        <span class="text-danger d-block mt-1 font-bold">لم يتم إرسال التقرير للعميل بعد</span>
                                    @elseif($estate->recieved_by_client == 1)
                                        <span class="text-primary d-block mt-1 font-bold">تم إرسال التقرير للعميل  بانتظار التأكيد</span>
                                    @else
                                        <span class="text-success d-block mt-1 font-bold">تم تأكيد التسليم من طرف العميل</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr id="last_hr">
                        @if($estate->recieved_by_client !==2)
                        <div class="flex-column d-flex flex-md-row justify-content-between align-items-center "
                            style="    gap: 1%;">
                            @if(auth()->user()->hasRole('manager'))
                             @if($estate->qema)
                                    @if($estate->recieved_by_client !==0) {{--if not recieved yet--}}
                                    <button class="btn btn-primary w-50 mb-1 mb-md-0"  id="send_to_client">إرسال الطلب والتقرير للعميل</button>
                                    @elseif($estate->recieved_by_client !==1)
                                    <button class="btn btn-success w-50 mb-1 mb-md-0"  id="end_report">إنهاء التقرير</button>
                                    @endif
                                    <span class="btn btn-warning w-50 mb-1 mb-md-0 return_order" data-return_to="value_approver" >إعادة الطلب لمعتمد قيمة</span>
                             @else
                                @if($estate->process_start_date)
                                    <button class="btn btn-primary w-50 mb-1 mb-md-0"  id="send_to_approver">إرسال الطلب إلى الاعتماد</button>
                                    <span class="btn btn-warning w-50 mb-1 mb-md-0 return_order" data-return_to="reviewer" >إعادة الطلب للمراجع</span>
                                @else
                                    @if(\App\Models\EstateInput::where('key','like',"%موافقة العميل%")->whereValue('موافقة')->whereEstateId($estate->id)->latest()->first())
                                    <button class="btn btn-success w-50 mb-1 mb-md-0" type="submit" id="approve_request">اعتماد الطلب </button>
                                    <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">
                                        إعادة الإرسال للعميل
                                    </button>
                                    @else
                                    <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">
                                        موافقة وإرسال إلى العميل
                                    </button>
                                    @endif

                                    <span class="btn btn-warning w-50 mb-1 mb-md-0 return_order" data-return_to="rater_manager">رفض وإرجاع لمدير
                                        التقييم</span>
                                @endif
                             @endif
                            @else
                            {{-- the order is proccessed --}}
                            {{-- <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">اعتماد
                                التقرير و وارسالة الى اعتماد قيمة </button>
                            <span class="btn btn-warning w-50 mb-1 mb-md-0 return_order" data-return_to="rater_manager">رفض والرجوع الى مدير
                                التقييم</span> --}}
                            @endif
                            <span class="btn btn-danger w-50 mb-1 mb-md-0" id="cancel_order">الغاء وحفظ كمسودة</span>
                        </div>
                        @endif
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
                if($('#draft_note').length){
                    $('#myform').submit();
                }else{
                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="draft_note"> ملاحظة على المسودة </label>
                                        <textarea rows="5" type="text" name="draft_note"
                                                  class="form-control" id="draft_note" placeholder="اكتب ملاحظة على المسودة "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

        });
        $('.return_order').click(function (e) {
                let return_to = $(this).data('return_to');
                e.preventDefault();
                $('#draft_cancel').remove();
                $(this).text('انقر للتأكيد ...')
                if(!$('#order_return').length) $('#myform').append(`<input type="text" class="d-none" name="return" id="order_return" value="${return_to}" >`)
                if($('#draft_note').length){
                    $('#myform').submit();
                }else{
                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="draft_note"> ملاحظة على الطلب </label>
                                        <textarea rows="5" type="text" name="draft_note"
                                                  class="form-control" id="draft_note" placeholder="اكتب ملاحظة على الطلب "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

        });
        //اعتماد الطلب
        $('#approve_request').click(function (e) {
                e.preventDefault();
                $('#draft_cancel').remove();
                $('#myform').append('<input type="text" class="d-none" name="approve" id="order_approve" value="approve" >')
                $('#myform').submit();

        });
        $('#send_to_approver').click(function (e) {
                e.preventDefault();
                $('#draft_cancel').remove();
                $('#order_approve').remove();
                $('#order_return').remove();
                $('#myform').append('<input type="text" class="d-none" name="send_to_approver" id="send_to_approver" value="approve" >')
                $('#myform').submit();

        });
        $('#send_to_client').click(function (e) {
                e.preventDefault();
                $('#draft_cancel').remove();
                $('#order_approve').remove();
                $('#order_return').remove();
                $('#myform').append('<input type="text" class="d-none" name="send_to_client" id="send_to_client" value="send_to_client" >')
                $('#myform').submit();

        });
        $('#end_report').click(function (e) {
                e.preventDefault();
                $('#draft_cancel').remove();
                $('#order_approve').remove();
                $('#order_return').remove();
                $('#send_to_client').remove();
                $('#approve_request').remove();
                $('#myform').append('<input type="text" class="d-none" name="end_report" id="end_report" value="end_report" >')
                $('#myform').submit();

        });
        $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#draft_cancel').remove();
               $('#order_return').remove();
               $('#order_approve').remove();
               $('#send_to_approver').remove();
               $('#draft_note').remove();
               $('#myform').submit();
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


        $('#accept').change(function(){
  if($('.rel_status').val() == 1) {
    $('.rel_part').show();
  } else {
    $('.rel_part').hide();
  }
});
</script>
@endsection