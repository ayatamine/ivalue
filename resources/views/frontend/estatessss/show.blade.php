@extends('frontend.layout.master')
@section('frontend-head')
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/themes/semi-dark-layout.css">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/plugins/file-uploaders/dropzone.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/pages/data-list-view.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style-rtl.css">
    <link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css" />
    <style>
        .fc-daygrid-block-event .fc-event-title{
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
            font-family: sans;
            color: white;
        }
        .fc .fc-daygrid-day.fc-day-today {
            background-color: #adb5bd;
        }
    </style>
    <!-- END: Custom CSS-->
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
            <div class="content-body">
                <!-- Data list view starts -->
                <div class="col-12">
                    @include('common.done')
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{ $estate->name }}</h4>
                                <hr>
                                <div style="height: 200px" class="text-center">
                                    @if(isset($estate->mainImage))
                                        <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                                    @else
                                        <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                </div>
                                <hr>
                                <table class="table table-striped table-bordered dt-responsive nowrap">
                                    <tr>
                                        <th>الاسم</th>
                                        <td>{{ $estate->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>العنوان</th>
                                        <td>
                                            {{ $estate->address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>عدد الطوابق</th>
                                        <td>{{ $estate->floors_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>عدد الشقق في الطابق</th>
                                        <td>{{ $estate->apartments_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>عدد الشقق الخالية</th>
                                        <td>{{ $estate->empty_apartments_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>عدد الشقق المأهولة</th>
                                        <td>{{ $estate->rented_apartments_count }}</td>
                                    </tr>

                                    <tr>
                                        <th>صاحب العقار</th>
                                        <td>{{ $estate->user->name}} </td>
                                    </tr>
                                    <tr>
                                        <th>المدينة</th>
                                        <td>{{ $estate->city->name}} </td>
                                    </tr>
                                    <tr class="text-primary">
                                        <th>المدفوعات المتوقعة</th>
                                        <td>{{ $estate->expected ?? '----' }} ريال </td>
                                    </tr>
                                    <tr class="text-danger">
                                        <th>المدفوعات التي تمت</th>
                                        <td>
                                            <?php
                                            $sum = 0;
                                            foreach(\App\Models\Report::where('estate_id' , $estate->id)->get() as $key=>$value)
                                            {
                                                $sum+= $value->price;
                                            }
                                            echo $sum;
                                            ?>
                                            ريال
                                        </td>
                                    </tr>
                                    <tr style="background: rgba(3,3,3,0.2)" class="text-success">
                                        <th>الفرق بين المفدفوعات المتوقعه والتي تمت</th>
                                        <td>{{ $estate->expected - $sum }} ريال </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">عمليات الخاصة بالعقار </h4>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>العنوان</th>
                                                    <th>التاريخ</th>
                                                    <th>اللون المميز</th>
                                                    <th>الطابق</th>
                                                    <th>الشقة</th>
                                                    <th>قيمة المبلغ</th>
                                                    <th>ملف مرفق</th>
                                                    <th>الخيارات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($estate->reports as $report)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $report->name }}</td>
                                                        <td>{{ $report->date }}</td>
                                                        <td style="background: {{ $report->color }}"></td>
                                                        <td>{{ $report->floor ?? '----' }}</td>
                                                        <td>{{ $report->flat ?? '----' }}</td>
                                                        <td>{{ $report->price ?? '----' }} ريال </td>
                                                        <td>
                                                            @if(isset($report->file))
                                                                <a target="_blank" class="mt-3" alt="الملف" href="{{ asset('pictures/reports/' . $report->file->file) }}"><i class="fa fa-file"></i> </a>
                                                            @else
                                                                لا يوجد
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('show_report' , $report->slug) }}"
                                                               class="mr-3 text-success"><i class="feather icon-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <a href="{{ route('front_estates.index') }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                            </div>
                        </div>

                    </div> <!-- end col -->
                </div> <!-- end row -->
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
    <!-- END: Theme JS-->
@endsection