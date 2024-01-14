@extends('frontend.layout.master')
@section('frontend-head')
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
        .fc-daygrid-block-event .fc-event-title {
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
            font-family: sans;
            color: white;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: #adb5bd;
        }

        .old {
            background: rgba(255, 0, 0, 0.39);
        }

        .new {
            background: rgba(144, 255, 30, 0.39);
        }
    </style>
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- Data list view starts -->

        <section id="data-thumb-view" class="data-thumb-view-header">
            <h3>
                اسلوب الدخل بطريقه الاستثمار الخاصه بالعقار {{ $estate->name_arabic }}
            </h3>
            <div class="col-12">
                <a style="width: 100%" onclick="return confirm('هل انت متأكد من ذلك ؟!');" href="{{ route('investment_delete' , ['id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" class="btn btn-danger text-white">
                    حذف المدخلات وضافه جديد
                </a>
            </div>
            <!-- dataTable starts -->
            <div class="table-responsive">
                <table class="table data-thumb-view">
                    <thead>
                    <tr>
                        <th style="display: none">#</th>
                        <th>
                            المساحة التأجيرية
                        </th>
                        <th>
                            اجمالي الايجار السنوي
                        </th>
                        <th class="old">
                            الايجار للمتر المربع
                        </th>
                        <th class="old">
                            نسبة المصاريف التشغيلية
                        </th>
                        <th class="old">
                            اجمالي المصاريف التشغيلية
                        </th>
                        <th class="old">
                            صافي الايجار السنوي
                        </th>
                        <th class="old">
                            صافي الايجار السنوي للمتر المربع
                        </th>
                        <th class="old">
                            تاريخ انتهاء العقد

                        </th>
                        <th class="old">
                            الفترة المتبقية لانتهاء العقد
                        </th>
                        <th class="old">
                            معدل العائد للأبدية قبل انتهاء العقد
                        </th>
                        <th class="old">
                            عامل شراء السنوات لفترة محددة
                        </th>
                        <th class="old">
                            القيمة السوقية
                        </th>
                        <th class="new">
                            الايجار للمتر المربع بعد التجديد
                        </th>
                        <th class="new">
                            اجمالي الايجار السنوي
                        </th>
                        <th class="new">
                            نسبة المصاريف التشغيلية
                        </th>
                        <th class="new">
                            اجمالي المصاريف التشغيلية
                        </th>
                        <th class="new">
                            صافي الايجار السنوي
                        </th>
                        <th class="new">
                            الايجار السنوي للمتر المربع
                        </th>
                        <th class="new">
                            معدل الاشغال
                        </th>
                        <th class="new">
                            معدل العائد للأبدية بعد تجديد العقد
                        </th>
                        <th class="new">
                            القيمة الحالية
                        </th>
                        <th class="new">
                            عامل سنوات الشراء للأبد
                        </th>
                        <th class="new">
                            القيمة السوقية
                        </th>
                        <th class="">
                            ااجمالي القيمة السوقية (ريال)
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="display:none"></td>
                        <td class="product-name">{{ $option[0]['value'] ?? '' }}</td>
                        <td>{{ $option[1]['value'] ?? '' }}</td>
                        <td>{{ $option[3]['value'] ?? '' }}</td>
                        <td>{{ $option[4]['value'] ?? '' }}</td>
                        <td>{{ $option[5]['value'] ?? '' }}</td>
                        <td>{{ $option[14]['value'] ?? '' }}</td>
                        <td>{{ $option[15]['value'] ?? '' }}</td>
                        <td>{{ $option[6]['value'] ?? '' }}</td>
                        <td>{{ $option[16]['value'] ?? '' }}</td>
                        <td>{{ $option[7]['value'] ?? '' }}</td>
                        <td>{{ $option[8]['value'] ?? '' }}</td>
                        <td>{{ $option[17]['value'] ?? '' }}</td>
                        <td>{{ $option[11]['value'] ?? '' }}</td>
                        <td>{{ $option[18]['value'] ?? '' }}</td>
                        <td>{{ $option[10]['value'] ?? '' }}</td>
                        <td>{{ $option[19]['value'] ?? '' }}</td>
                        <td>{{ $option[20]['value'] ?? '' }}</td>
                        <td>{{ $option[23]['value'] ?? '' }}</td>
                        <td>{{ $option[12]['value'] ?? '' }}</td>
                        <td>{{ $option[9]['value'] ?? '' }}</td>
                        <td>{{ $option[13]['value'] ?? '' }}</td>
                        <td>{{ $option[21]['value'] ?? '' }}</td>
                        <td>{{ $option[22]['value'] ?? '' }}</td>
                        <td>{{ $option[24]['value'] ?? '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- dataTable ends -->
        </section>
        <!-- Data list view end -->
    </div>
    <!-- END: Content-->
@endsection
@section('frontend-footer')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
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
@endsection