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
                تكلفة الاحلال (الدليل الاسعار الاسترشادية) محطات الوقود لـــ
                {{ $estate->name_arabic }}
                <br>
            </h3>
            <div class="col-12">
                <a style="width: 100%" onclick="return confirm('هل انت متأكد من ذلك ؟!');" href="{{ route('petrol_station_delete' ,  ['id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" class="btn btn-danger text-white">
                    حذف المدخلات وضافه جديد
                </a>
            </div>
            <!-- dataTable starts -->
            <section id="data-thumb-view" class="data-thumb-view-header">
                <!-- dataTable starts -->
                <div class="table-responsive">
                    <table class="table data-thumb-view">
                        <thead>
                        <tr>
                            <th style="display:none;">#</th>
                            <th>التصنيف العام</th>
                            <th>التصنيف التفصيلي</th>
                            <th>الفئة/التحسينات</th>
                            <th>تجهيز الموقع العام (ارض) (ريال لكل م2)</th>
                            <th>تكلفة انشاء السور (ريال - م.ط)</th>
                            <th>منطقة الخدمات المساندة (مباني) (ريال لكل م2)</th>
                            <th>مظلة المحطة (مباني) (ريال لكل م2)</th>
                            <th>خزانات الوقود (ريال لكل م3)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="delete-all-cats">
                            <td style="display:none;">

                            </td>
                            <td class="product-name">
                               {{ $option[0]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[1]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[2]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[3]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[4]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[5]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[6]['value'] ?? '' }}
                            </td>
                            <td>
                                {{ $option[7]['value'] ?? '' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>
                            حساب مجموع تكاليف البناء محطة وقود
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>مساحة الأرض</th>
                                    <td>
                                        {{ $option[8]['value'] ?? '' }}
                                        م2
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي مساحة المباني المساندة</th>
                                    <td>
                                        {{ $option[9]['value'] ?? '' }}
                                        م2
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة تجهيز الموقع العام</th>
                                    <td>
                                        {{ $option[10]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة المباني المساندة</th>
                                    <td>
                                        {{ $option[11]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي طول السور</th>
                                    <td>
                                        {{ $option[12]['value'] ?? '' }}
                                        م.ط
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة السور</th>
                                    <td>
                                        {{ $option[13]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>حجم خزانات الوقود</th>
                                    <td>
                                        {{ $option[14]['value'] ?? '' }}
                                        م3
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة خزانات الوقود</th>
                                    <td>
                                        {{ $option[15]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>مساحة مظلة المحطة</th>
                                    <td>
                                        {{ $option[16]['value'] ?? '' }}
                                        م2
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة مظلة المحطة</th>
                                    <td>
                                        {{ $option[17]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">مجموع تكاليف البناء (بدون تكاليف التمويل)</th>
                                    <td>
                                        {{ $option[18]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>مدة التطوير</th>
                                    <td>
                                        {{ $option[19]['value'] ?? '' }}
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>معدل الفائدة على التمويل سنويا</th>
                                    <td>
                                        {{ $option[20]['value'] ?? '' }}
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>نسبة التمويل من مدة التطوير</th>
                                    <td>
                                        {{ $option[21]['value'] ?? '' }}
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>نسبة التمويل من تكلفة التمويل</th>
                                    <td>
                                        {{ $option[22]['value'] ?? '' }}
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة التمويل</th>
                                    <td>
                                        {{ $option[23]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">القيمة الاجمالية للتطوير</th>
                                    <td>
                                        {{ $option[24]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>
                            حساب قيمة المباني للمحطة
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>العمر الافتراضي للمبنى</th>
                                    <td>
                                        {{ $option[25]['value'] ?? '' }}
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>العمر المتبقي للمبنى</th>
                                    <td>
                                        {{ $option[26]['value'] ?? '' }}
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>معدل الاهلاك السنوي (العمر الممتد)</th>
                                    <td>
                                        {{ $option[27]['value'] ?? '' }}
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي قيمة التطوير</th>
                                    <td>
                                        {{ $option[28]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>قيمة الاهلاك</th>
                                    <td>
                                        {{ $option[29]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">قيمة المباني بعد الاهلاك:</th>
                                    <td>
                                        {{ $option[30]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <h3>
                            حساب قيمة العقار محطة الوقود
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>قيمة الارض بطريقة المقارنة</th>
                                    <td>
                                        {{ $option[31]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي قيمة المباني بعد الاهلاك</th>
                                    <td>
                                        {{ $option[32]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">قيمة العقار بطريقة الاحلال:</th>
                                    <td>
                                        {{ $option[33]['value'] ?? '' }}
                                        ريال
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- dataTable ends -->
            </section>
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