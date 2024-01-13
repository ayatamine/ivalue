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
        <div class="col-12">
        </div>
        <section id="data-thumb-view" class="data-thumb-view-header">
            <div class="action-btns d-none">
                <div class="btn-dropdown mr-1 mb-1">
                    <div class="btn-group dropdown actions-dropodown">
                        <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            خيارات
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('categories.create',Route::current()->parameter('subdomain')) }}"><i class="fa fa-plus"></i>اضافة جديد</a>
                            <a class="dropdown-item delete-all" onclick="return false;" delete_url="/delete_categories/">
                                حذف الكل</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- dataTable starts -->
            <div class="table-responsive">
                <table class="table data-thumb-view">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>فعال</th>
                        <th>الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $country)
                        <tr class="delete-all-cats">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="product-name">{{ $country->name }}</td>
                            <td>{{ $country->getActive() }}</td>
                            <td class="product-action">
                                <span class="action-edit"><a href="{{ route('categories.edit' , ['category'=>$country->id,'subdomain'=>'سيبسيب']) }}"><i class="feather icon-edit"></i></a></span>
                                <a title="" onclick="return false;" object_id="{{ $country->id }}"
                                   delete_url="/estate/public/categories/" class="edit-btn-table remove-alert" href="#">
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