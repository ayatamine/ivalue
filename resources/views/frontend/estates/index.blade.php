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
    <!-- END: Custom CSS-->
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
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- Data list view starts -->
        <div class="action-btns d-none">
            <div class="btn-dropdown mr-1 mb-1">
                <div class="btn-group dropdown actions-dropodown">
                    <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        خيارات
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('estates.create',Route::current()->parameter('subdomain')) }}"><i class="fa fa-plus"></i>اضافة جديد</a>
                    </div>
                </div>
            </div>
        </div>
        <section id="data-thumb-view" class="data-thumb-view-header">
            <div class="table-responsive">
                <table class="table data-thumb-view">
                    <thead>
                    <tr>
                        <th>#</th>
                        {{--<th>#</th>--}}
                        <th>الاسم</th>
                        <th>كود التقرير</th>
                        <th>المرحلة</th>
                        <th>فعال</th>
                        <th>الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($estates as $estate)
                        <tr >
                            <td>{{ $loop->index + 1 }}</td>
                            {{--<td class="product-img">--}}
                                {{--<img src="{{ $estate->image_url }}">--}}
                            {{--</td>--}}
                            <td class="product-name">{{ $estate->name_arabic }}</td>
                            <td class="product-name">{{ $estate->id }}</td>
                            <td>{{ $estate->level_name }}</td>
                            <td>{{ $estate->getActive() }}</td>
                            <td class="product-action">
                                <span class="action-edit"><a href="{{ route('estates.edit' ,['estate'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}"><i class="feather icon-edit"></i></a></span>
                                @if(auth()->user()->membership_level == 'manager')
                                <?php
                                     $payment = \App\Models\EstatePayment::where('estate_id',$estate->id)->where('done' , 0)->first();
                                ?>
                                @if($payment)
                                <span class="text-warning"><a href="{{ route('estate_paid' ,['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}"><i title="اضافة عملية دفع" class="feather text-warning icon-dollar-sign"></i></a></span>
                                @endif
                                @endif
                                <span class="text-danger"><a href="{{ route('pdf_pro' ,['id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}"><i class="feather icon-file text-danger"></i></a></span>
                                <a title="" onclick="return false;" object_id=""
                                   delete_url="{{route('estates.destroy',['estate'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')])}}" class="edit-btn-table remove-alert" href="#">
                                    <i class="feather icon-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
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