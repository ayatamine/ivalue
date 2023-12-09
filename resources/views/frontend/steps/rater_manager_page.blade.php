@extends('frontend.layout.master')
@section('frontend-head')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAbukNOXKPE1M-2Duze7aLXcRLguKXbJQ&libraries=places&sensor=false"></script>
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
    <link rel="stylesheet" type="text/css"
          href="{{ asset('frontend') }}/app-assets/css-rtl/themes/semi-dark-layout.css">
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
    <link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css"/>
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
                    <h4 class="card-title"> مدخلات مدير التقييم </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{ route('level_inputs' , $estate->id) }}" id="myform"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-row">
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="works">نطاق العمل والاتعاب</label>
                                    <input type="text" name="works" class="form-control" id="works"
                                           placeholder="نطاق العمل" value="" required>
                                    @error('works')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if($estate->report_type != 'old')
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="works_delay">مده العمل</label>
                                    <input type="text" name="works_delay" class="form-control" id="works_delay"
                                           placeholder="مدة العمل" value="" required>
                                    @error('works_delay')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="report_standards">معايير التقييم</label>


                                           <div class="form-group">
                                                    <select name="report_standards" id="report_standards"
                                                            class="select2 form-control" required>

                                                        <option value="2020"> 2020</option>
                                                        <!--<option value="2021"> 2021</option>-->
                                                        <option value="2022"> 2022</option>

                                                    </select>
                                                </div>
                                    @error('report_standards')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="col-md-3 col-12 mb-3">
                                    <label for="report_users">مستخدم التقرير (يتم الفصل بين الاسامي بـ "-")</label>
                                    <input type="text" name="report_users" class="form-control" id="report_users"
                                           placeholder="مستخدم التقرير" value="" required>
                                    @error('report_users')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if($estate->report_type != 'old')
                                <div class="col-md-3 col-6 mb-3">
                                    <label for="price">عرض السعر التكاليف</label>
                                    <input type="number" name="price" class="form-control" id="price"
                                           placeholder="عرض السعر التكاليف" value="" required>
                                    ريال
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="report_kind">
                                                نوع التقرير
                                            </label>
                                            <div class="form-group">
                                                <select name="report_kind" id="report_kind"
                                                        class="select2 form-control">
                                                    <option selected hidden disabled value="">اختر نوع التقرير
                                                    </option>
                                                    <option value="تقرير مفصل">تقرير مفصل </option>
                                                    <option value="ملخص التقرير">ملخص التقرير </option>
                                                    <option value="مراجعة مع قيمة جديدة">مراجعة مع قيمة جديدة</option>
                                                    <option value="مراجعة بدون قيمة جديدة">مراجعة بدون قيمة جديدة</option>
                                                </select>
                                            </div>
                                            @error('report_kind')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="report_main">
                                                اساس القيمة
                                            </label>
                                            <div class="form-group">
                                                <select name="report_main" id="report_main"
                                                        class="select2 form-control">
                                                    <option selected hidden disabled value="">اختر اساس القيمة
                                                    </option>
                                                    <option value="القيمة السوقية">القيمة السوقية</option>
                                                    <option value="الايجار السوقي">الايجار السوقي</option>
                                                    <option value="القيمة المنصفة">القيمة المنصفة</option>
                                                    <option value="القيمة الاستثمارية">القيمة الاستثمارية</option>
                                                    <option value="القيمة التكاملية">القيمة التكاملية</option>
                                                    <option value="قيمة التصفية">قيمة التصفية</option>
                                                </select>
                                            </div>
                                            @error('report_main')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="default_value">
                                                فرضية القيمة
                                            </label>
                                            <div class="form-group">
                                                <select name="default_value" id="default_value"
                                                        class="select2 form-control">
                                                    <option selected hidden disabled value="">اختر فرضية القيمة
                                                    </option>
                                                    <option value="الاستخدام الاعلى والافضل">الاستخدام الاعلى والافضل</option>
                                                    <option value="الاستخدام الحالي">الاستخدام الحالي</option>
                                                    <option value="التصفية النظمة">التصفية النظمة</option>
                                                    <option value="البيع القسري">البيع القسري</option>
                                                </select>
                                            </div>
                                            @error('default_value')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if($estate->report_type != 'old')
                                <div class="col-md-3 col-6 mb-3">
                                    <label for="qty">عدد الدفعات</label>
                                    <input type="number" name="qty" class="form-control" id="qty"
                                           placeholder="عدد الدفعات" value="" required>
                                    @error('qty')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                                @if($estate->report_type != 'old')
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="price_delay">مدة عرض السعر</label>
                                    <input type="number" name="price_delay" class="form-control" id="price_delay"
                                           placeholder="مدة عرض السعر" value="" required>
                                    @error('price_delay')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="special_order">اضافة اشتراطات وافتراضات خاصة</label>
                                    <input type="text" name="special_order" class="form-control" id="special_order"
                                           placeholder="اضافة اشتراطات وافتراضات خاصة" value="" required>
                                    @error('special_order')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                                <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="size_kind">
                                                    العملة
                                                </label>
                                                <?php
                                                    $currencies = \DB::table('currncies')->get();
                                                ?>
                                                <div class="form-group">
                                                    <select name="currency" id="currency"
                                                            class="select2 form-control">
                                                        @foreach($currencies as $currency)
                                                        <option value="{{ $currency->name }}">{{ $currency->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('currency')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-12 col-6 mb-3">
                                    <label for="report_desc">وصف التقرير</label>
                                    <div class="form-group">
                                                    <select name="report_desc" id="report_desc"
                                                            class="select2 form-control">

                                                        <option value="ورقي">ورقي </option>
                                                        <option value="الكتروني">الكتروني </option>

                                                    </select>
                                                </div>
                                    @error('report_desc')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr id="last_hr">
                            <div class="d-flex justify-content-between align-items-center $estate->entered_by = $request->report_type;" style="    gap: 1%;" >
                                <button class="btn btn-primary w-50" type="submit" id="submit_order">اضافة</button>
                                <span class="btn btn-warning w-50" id="return_order">رفض وإرجاع للادخال</span>
                                <span class="btn btn-danger w-50" id="cancel_order">الغاء وحفظ كمسودة</span>
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
    <!-- BEGIN Vendor JS-->
    <script>
        $(document).ready(function () {
        $('#cancel_order').click(function (e) {
                e.preventDefault();
                $('#order_return').remove();
                $(this).text('انقر للتأكيد ...')
                $('#myform').append('<input type="text" class="d-none" name="cancel" id="draft_cancel" value="cancel" >')
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
        $('#return_order').click(function (e) {
                e.preventDefault();
                $('#draft_cancel').remove();
                $(this).text('انقر للتأكيد ...')
                $('#myform').append('<input type="text" class="d-none" name="return" id="order_return" value="return" >')
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
        $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#draft_cancel').remove();
               $('#order_return').remove();
               $('#draft_note').remove();
               $('#myform').submit();
        });
      })
    </script>
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