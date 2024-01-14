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

    </style>
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- Data list view starts -->
        <div class="col-12">
        </div>
        <form method="post" action="{{ route('investments.store',Route::current()->parameter('subdomain')) }}" id="myform">
            @csrf
            <div class="form-row">
                 <?php

        if (session()->has('estate_id') && session()->has('from'))
        {
            $estate_id = session()->get('estate_id');
            $estate = \App\Models\Estate::find($estate_id);
        }else{
            $estate_id = '';
        }
    ?>
                <div class="col-sm-12 col-12">
                    <label for="estate_id">
                        العقار

                    </label>
                    @if($estate_id)
                    <div class="form-group">
                        <input class="form-control" name="estate_id" readonly value="{{ $estate_id }}" hidden/>
                        <input class="form-control" readonly value="{{ $estate->name_arabic }}"/>
                    </div>
                    @else
                    <div class="form-group">
                        <select {{ $estate_id ? 'readonly' : '' }} name="estate_id" id="estate_id"
                                class="select2 form-control" required>
                            <option selected hidden disabled {{ $estate_id ? '' : 'selected' }} value="">اختر العقار</option>
                            @foreach($estates as $kind)
                                <option {{ $estate_id == $kind->id ? 'selected' : '' }} land="{{ $kind->land_size }}"
                                        value="{{ $kind->id }}">{{ $kind->name_arabic }} </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @error('estate_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <hr>
            <hr>
            <section id="data-thumb-view" class="data-thumb-view-header">
                <!-- dataTable starts -->
                <div class="table-responsive">
                    <table class="table data-thumb-view">
                        <thead>
                        <tr>
                            <th style="display:none;">#</th>
                            <th>المساحه التأجيرية</th>
                            <th>اجمالي الايجار السنوي</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="delete-all-cats">
                            <td  style="display:none;">

                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[0]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[0]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[1]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[1]') }}" required>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <h3>
                    الى نهاية العقد
                </h3>
                <div class="table-responsive">
                    <table class="table data-thumb-view">
                        <thead>
                        <tr>
                            <th style="display:none;">#</th>
                            <th>نسبة المصاريف التشغيلية</th>
                            <th>تاريخ انتهاء العقد</th>
                            <th>معدل العائد للابدية</th>
                            <th>عامل شراء السنوات لفتره محدوده</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="delete-all-cats">
                            <td  style="display:none;">

                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[2]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[2]') }}" required>
                            </td>
                            <td>
                                <input type="date" name="value[3]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[3]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[4]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[4]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[5]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[5]') }}" required>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <hr>
                <h3>
                    بعد التجديد
                </h3>
                <div class="table-responsive">
                    <table class="table data-thumb-view">
                        <thead>
                        <tr>
                            <th style="display:none;">#</th>
                            <th>الايجار للمتر المربع</th>
                            <th>معدل العائد للابدية</th>
                            <th>نسبه المصاريف التشغيلية</th>
                            <th>القيمة الحالية</th>
                            <th>معدل الاشغال</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="delete-all-cats">
                            <td  style="display:none;">

                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[9]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[9]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[6]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[6]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[8]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[8]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[7]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[7]') }}" required>
                            </td>
                            <td class="product-name">
                                <input type="number" step="0.01" name="value[10]" class="form-control"
                                       placeholder="القيمة " value="{{ old('value[10]') }}" required>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                </div>
                <hr>
                 <div class="rate_info">
                                        <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[0][key]" class="form-control"
                                                               placeholder=" هل يعتبر الاستخدام الحالي افضل استخدام " value=" هل يعتبر الاستخدام الحالي افضل استخدام "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[0][value]" class="form-control" required>
                                                            <option value="نعم">نعم</option>
                                                            <option value="لا">لا</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[1][key]" class="form-control"
                                                               placeholder=" ملاحظات  وتوصيات " value="ملاحظات   وتوصيات "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[1][value]" class="form-control"
                                                               placeholder=" ملاحظات  وتوصيات " value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[2][key]" class="form-control"
                                                               placeholder=" الافتراضات الخاصة" value="الافتراضات الخاصة "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[2][value]" class="form-control"
                                                               placeholder="  الافتراضات الخاصة  " value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[3][key]" class="form-control"
                                                               placeholder=" الشروط الخاصة" value="الشروط الخاصة "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[3][value]" class="form-control"
                                                               placeholder="  الشروط الخاصة  " value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[4][key]" class="form-control"
                                                               placeholder=" تاريخ التقييم " value="  تاريخ التقييم"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="date" name="infos[4][value]" class="form-control"
                                                               placeholder="     " value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                <!-- dataTable ends -->
            </section>
            <!-- Data list view end -->
            <hr>
            <button class="btn btn-primary" type="submit">حفظ</button>
        </form>
    </div>
    <!-- END: Content-->
@endsection
@section('frontend-footer')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('frontend') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/scripts/components.js"></script>
    <script src="{{ asset('frontend') }}/custom-sweetalert.js"></script>
@endsection