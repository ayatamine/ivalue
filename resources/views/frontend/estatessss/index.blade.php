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
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
            <div class="content-body">
                <!-- Data list view starts -->
                <div class="col-12">
                    @include('common.done')
                </div>
                <section id="data-thumb-view" class="data-thumb-view-header">
                    <div class="table-responsive">
                        <table class="table data-thumb-view">
                            <thead>
                            <tr>
                                <th hidden=""></th>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>اسم العقار</th>
                                <th>عدد الطوابق</th>
                                <th>عدد الشقق في الطابق</th>
                                <th>عدد الشقق الفارغة</th>
                                <th>عدد الشقق المأهولة</th>
                                <th>المدفوعات المتوقعة</th>
                                <th>المدفوعات الفعلية</th>
                                <th>تصفح</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($estates as $estate)
                            <tr class="delete-all-cats">
                                <td hidden=""></td>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="product-img">
                                    @if(isset($estate->mainImage))
                                        <img alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                                    @else
                                        <img alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                </td>
                                <td>
                                    {{ $estate->name ?? '' }}
                                </td>
                                <td>
                                    {{ $estate->floors_count ?? '' }}
                                </td>
                                <td>
                                    {{ $estate->apartments_count ?? '' }}
                                </td>
                                <td>
                                    {{ $estate->empty_apartments_count ?? '' }}
                                </td>
                                <td>
                                    {{ $estate->rented_apartments_count ?? '' }}
                                </td>
                                <td>
                                    {{ $estate->expected ?? '' }}
                                </td>
                                <td>
                                    <?php
                                    $sum = 0;
                                    foreach(\App\Models\Report::where('estate_id' , $estate->id)->get() as $key=>$value)
                                    {
                                        $sum+= $value->price;
                                    }
                                    echo $sum;
                                    ?>
                                </td>
                                <td class="product-action">
                                    <span class="action-edit"><a title="تصفح العقار" href="{{ route('front_estates.show' , $estate->slug) }}"><i class="feather icon-eye"></i></a></span>
                                    <span class="action-delete"><a title="عمليات العقار على شكل التقويم"  href="{{ route('show_calendar' , $estate->slug) }}"><i class="feather icon-calendar"></i></a></span>
                                    <span class="action-delete"><a title="عمليات العقار" href="{{ route('show_reports' , $estate->slug) }}"><i class="feather icon-paperclip"></i></a></span>
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
    <!-- END: Theme JS-->
@endsection