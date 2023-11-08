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
        <form method="post" action="{{ route('land.store') }}" id="myform">
            @csrf
            <div class="form-row">
                <div class="col-sm-12 col-12">
                    <h3 class="text-center">
                        تكلفة الاحلال (الدليل الاسعار الاسترشادية) المخططات العامة ارض خام
                    </h3>
                    <hr/>
                </div>
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
                            <th>تمهيد الأرض(ريال لكل م2)</th>
                            <th>اعمال السفلته(ريال لكل م2)</th>
                            <th>اعمال الرصف(ريال لكل م2)</th>
                            <th>أعمدة الانارة (ريال لكل م2)</th>
                            <th>الحدائق(ريال لكل م2)</th>
                            <th>اعمال البنية التحتية(ريال لكل م2)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="delete-all-cats">
                            <td style="display:none;">

                            </td>
                            <td class="product-name">
                                <input type="text" name="value[0]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[0]') }}" required>
                            </td>
                            <td>
                                <input type="text" name="value[1]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[1]') }}" required>
                            </td>
                            <td>
                                <input type="text" name="value[2]" class="form-control" placeholder="القيمة "
                                       value="{{ old('value[2]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[3]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[3]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[4]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[4]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[5]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[5]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[6]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[6]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[7]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[7]') }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="value[8]" class="form-control"
                                       placeholder="القيمة "
                                       value="{{ old('value[8]') }}" required>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>
                            حساب مجموع تكاليف البناء مخطط عام
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>مساحة الأرض</th>
                                    <td>
                                        <input id="land" type="number" step="0.01" name="value[9]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[9]') }}" required readonly>
                                        م2
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة تمهيد الأرض</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[10]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[10]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة اعمال السفلته</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[11]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[11]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة الحدائق</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[12]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[12]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة اعمال البنية التحتية</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[13]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[13]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة اعمال الرصف</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[14]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[14]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة أعمدة الانارة</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[15]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[15]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">مجموع تكاليف البناء (بدون تكاليف التمويل)</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[16]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[16]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>مدة التطوير</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[17]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[17]') }}" required>
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>معدل الفائدة على التمويل سنويا</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[18]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[18]') }}" required>
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>نسبة التمويل من مدة التطوير</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[19]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[19]') }}" required>
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>نسبة التمويل من تكلفة التمويل</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[20]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[20]') }}" required>
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي تكلفة التمويل</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[21]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[21]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">القيمة الاجمالية للتطوير</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[22]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[22]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>
                            حساب قيمة المباني للمخطط
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>العمر الافتراضي للمبنى</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[23]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[23]') }}" required>
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>العمر المتبقي للمبنى</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[24]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[24]') }}" required >
                                        سنة
                                    </td>
                                </tr>
                                <tr>
                                    <th>معدل الاهلاك السنوي (العمر الممتد)</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[25]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[25]') }}" required readonly>
                                        %
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي قيمة التطوير</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[26]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[26]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>قيمة الاهلاك</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[27]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[27]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">قيمة المباني بعد الاهلاك:</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[28]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[28]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <h3>
                            حساب قيمة العقار مخطط عام
                        </h3>
                        <div class="table-responsive">
                            <table style="width:100%" class="table data-thumb-view">
                                <tr>
                                    <th>قيمة الارض بطريقة المقارنة</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[29]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[29]') }}" required>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th>اجمالي قيمة المباني بعد الاهلاك</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[30]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[30]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">قيمة العقار بطريقة الاحلال:</th>
                                    <td>
                                        <input type="number" step="0.01" name="value[31]" class="form-control"
                                               placeholder="القيمة "
                                               value="{{ old('value[31]') }}" required readonly>
                                        ريال
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- dataTable ends -->
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
    <script>
        $(function () {
            $("#estate_id").change(function () {
                var option = $('option:selected', this).attr('land');
                $('#land').val(option);
            });
        });

        $('input[name="value[3]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_3 = $('input[name="value[3]"]').val();
            $('input[name="value[10]"]').val(land * input_3);
        });

        $('input[name="value[4]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_4 = $('input[name="value[4]"]').val();
            $('input[name="value[11]"]').val(land * input_4);
        });

        $('input[name="value[7]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_7 = $('input[name="value[7]"]').val();
            $('input[name="value[12]"]').val(land * input_7);
        });

        $('input[name="value[8]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_8 = $('input[name="value[8]"]').val();
            $('input[name="value[13]"]').val(land * input_8);
        });

        $('input[name="value[5]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_5 = $('input[name="value[5]"]').val();
            $('input[name="value[14]"]').val(land * input_5);
        });
        $('input[name="value[6]"]').on('keydown, keyup', function () {
            var land = $('#land').val();
            var input_6 = $('input[name="value[6]"]').val();
            $('input[name="value[15]"]').val(land * input_6);
        });

        /////////////////////////  input ( 16 ) /////////////////////////////
        $('input[name="value[3]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });

        $('input[name="value[4]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });

        $('input[name="value[7]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });

        $('input[name="value[8]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });

        $('input[name="value[5]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });
        $('input[name="value[6]"]').on('keydown, keyup', function () {
            var input_10 = parseInt($('input[name="value[10]"]').val());
            var input_11 = parseInt($('input[name="value[11]"]').val());
            var input_12 = parseInt($('input[name="value[12]"]').val());
            var input_13 = parseInt($('input[name="value[13]"]').val());
            var input_14 = parseInt($('input[name="value[14]"]').val());
            var input_15 = parseInt($('input[name="value[15]"]').val());
            $('input[name="value[16]"]').val(input_10 + input_11 + input_12 + input_13 + input_14 + input_15);
        });
        ////////////////////// input ( 21 ) ////////////////////////////////
        $('input[name="value[17]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_17 = parseInt($('input[name="value[17]"]').val());
            var input_18 = parseInt($('input[name="value[18]"]').val()) / 100 ;
            var input_19 = parseInt($('input[name="value[19]"]').val()) / 100 ;
            var input_20 = parseInt($('input[name="value[20]"]').val()) / 100 ;
            $('input[name="value[21]"]').val(input_16 * input_17 * input_18 * input_19 * input_20);
        });
        $('input[name="value[18]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_17 = parseInt($('input[name="value[17]"]').val());
            var input_18 = parseInt($('input[name="value[18]"]').val()) / 100 ;
            var input_19 = parseInt($('input[name="value[19]"]').val()) / 100 ;
            var input_20 = parseInt($('input[name="value[20]"]').val()) / 100 ;
            $('input[name="value[21]"]').val(input_16 * input_17 * input_18 * input_19 * input_20);
        });
        $('input[name="value[19]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_17 = parseInt($('input[name="value[17]"]').val());
            var input_18 = parseInt($('input[name="value[18]"]').val()) / 100 ;
            var input_19 = parseInt($('input[name="value[19]"]').val()) / 100 ;
            var input_20 = parseInt($('input[name="value[20]"]').val()) / 100 ;
            $('input[name="value[21]"]').val(input_16 * input_17 * input_18 * input_19 * input_20);
        });
        $('input[name="value[20]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_17 = parseInt($('input[name="value[17]"]').val());
            var input_18 = parseInt($('input[name="value[18]"]').val()) / 100 ;
            var input_19 = parseInt($('input[name="value[19]"]').val()) / 100 ;
            var input_20 = parseInt($('input[name="value[20]"]').val()) / 100 ;
            $('input[name="value[21]"]').val(input_16 * input_17 * input_18 * input_19 * input_20);
        });
        /////////////////////// input ( 22 - 26 )///////////////////////////
        $('input[name="value[17]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_21 = parseInt($('input[name="value[21]"]').val());
            $('input[name="value[22]"]').val(input_16 + input_21);
            $('input[name="value[26]"]').val(input_16 + input_21);
        });
        $('input[name="value[18]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_21 = parseInt($('input[name="value[21]"]').val());
            $('input[name="value[22]"]').val(input_16 + input_21);
            $('input[name="value[26]"]').val(input_16 + input_21);
        });
        $('input[name="value[19]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_21 = parseInt($('input[name="value[21]"]').val());
            $('input[name="value[22]"]').val(input_16 + input_21);
            $('input[name="value[26]"]').val(input_16 + input_21);
        });
        $('input[name="value[20]"]').on('keydown, keyup', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_21 = parseInt($('input[name="value[21]"]').val());
            $('input[name="value[22]"]').val(input_16 + input_21);
            $('input[name="value[26]"]').val(input_16 + input_21);
        });
        $('input[name="value[21]"]').on('keydown, keyup , change', function () {
            var input_16 = parseInt($('input[name="value[16]"]').val());
            var input_21 = parseInt($('input[name="value[21]"]').val());
            $('input[name="value[22]"]').val(input_16 + input_21);
            $('input[name="value[26]"]').val(input_16 + input_21);
        });
        ///////////////////////////  input ( 25 ) ////////////////////////////////////
        $('input[name="value[23]"]').on('keydown, keyup', function () {
            var input_24 = parseInt($('input[name="value[24]"]').val());
            var input_23 = parseInt($('input[name="value[23]"]').val());
            $('input[name="value[25]"]').val((input_23 - input_24) / input_23 * 100);
        });
        $('input[name="value[24]"]').on('keydown, keyup , change', function () {
            var input_24 = parseInt($('input[name="value[24]"]').val());
            var input_23 = parseInt($('input[name="value[23]"]').val());
            $('input[name="value[25]"]').val((input_23 - input_24) / input_23 * 100);
        });

        ///////////////////////////  input ( 27 - 28 - 30 ) ////////////////////////////////////
        $('input[name="value[23]"]').on('keydown, keyup', function () {
            var input_26 = parseInt($('input[name="value[26]"]').val());
            var input_25 = parseInt($('input[name="value[25]"]').val()) / 100;
           $('input[name="value[27]"]').val(input_26 * input_25);
        });
        $('input[name="value[24]"]').on('keydown, keyup , change', function () {
            var input_26 = parseInt($('input[name="value[26]"]').val());
            var input_25 = parseInt($('input[name="value[25]"]').val()) / 100;
            $('input[name="value[27]"]').val(input_26 * input_25);
        });

        $('input[name="value[23]"]').on('keydown, keyup', function () {
            var input_26 = parseInt($('input[name="value[26]"]').val());
            var input_27 = parseInt($('input[name="value[27]"]').val());
            $('input[name="value[28]"]').val(input_26 - input_27);
            $('input[name="value[30]"]').val(input_26 - input_27);
        });
        $('input[name="value[24]"]').on('keydown, keyup , change', function () {
            var input_26 = parseInt($('input[name="value[26]"]').val());
            var input_27 = parseInt($('input[name="value[27]"]').val());
            $('input[name="value[28]"]').val(input_26 - input_27);
            $('input[name="value[30]"]').val(input_26 - input_27);
        });
        ///////////////////////////  input ( 31 ) ////////////////////////////////////
        $('input[name="value[29]"]').on('keydown, keyup , change', function () {
            var input_29 = parseInt($('input[name="value[29]"]').val());
            var input_30 = parseInt($('input[name="value[30]"]').val());
            $('input[name="value[31]"]').val(input_29 + input_30);
        });
    </script>
@endsection