@extends('frontend.layout.master')
@section('frontend-head')
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/forms/select/select2.min.css">
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
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style-rtl.css">
    <style>
        .note-btn-group i{
            color: white;
        }
    </style>
    <!-- END: Custom CSS-->
@endsection    
@section('frontend-main')
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                @include('common.done')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> العقار {{ $report->estate->name }}</h4>
                    </div>
                    <hr>
                    <div style="height: 200px" class="text-center">
                        @if(isset($report->estate->mainImage))
                            <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('pictures/estates/' . $report->estate->mainImage->file) }}"/>
                        @else
                            <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                        @endif
                    </div>
                    <hr>
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                        <tr>
                            <th>اسم العقار</th>
                            <td>{{ $report->estate->name }}</td>
                        </tr>
                        <tr>
                            <th>عنوان العقار</th>
                            <td>
                                {{ $report->estate->address }}
                            </td>
                        </tr>
                        <tr>
                            <th>عدد الطوابق</th>
                            <td>{{ $report->estate->floors_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق في الطابق</th>
                            <td>{{ $report->estate->apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق الخالية</th>
                            <td>{{ $report->estate->empty_apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق المأهولة</th>
                            <td>{{ $report->estate->rented_apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>صاحب العقار</th>
                            <td>{{ $report->estate->user->name}} </td>
                        </tr>
                        <tr>
                            <th>المدينة</th>
                            <td>{{ $report->estate->city->name}} </td>
                        </tr>
                        <tr class="text-primary">
                            <th>المدفوعات المتوقعة</th>
                            <td>{{ $report->estate->expected ?? '----' }} ريال </td>
                        </tr>
                        <tr class="text-danger">
                            <th>المدفوعات التي تمت</th>
                            <td>
                                <?php
                                $sum = 0;
                                foreach(\App\Models\Report::where('estate_id' , $report->estate->id)->get() as $key=>$value)
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
                            <td>{{ $report->estate->expected - $sum }} ريال </td>
                        </tr>
                    </table>
                    <br>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">معلومات العملية</h4>
                                <table class="table table-striped table-bordered dt-responsive nowrap">
                                    <tr>
                                        <th>اسم العملية</th>
                                        <td>{{ $report->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>الشقة</th>
                                        <td>
                                            {{ $report->flat ?? '----' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>الدور</th>
                                        <td>
                                            {{ $report->floor ?? '----' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>السعر المسجل</th>
                                        <td>
                                            {{ $report->price ?? '----' }} ريال
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>التاريخ</th>
                                        <td>
                                            {{ $report->date ?? '----' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>اللون المميز</th>
                                        <td style="background: {{ $report->color }}">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <a href="{{ route('front_estates.index') }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('frontend-footer')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('frontend') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('frontend') }}/app-assets/js/scripts/forms/form-tooltip-valid.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <!-- END: Page JS-->
@endsection    
