@extends('frontend.layout.master')
@section('frontend-head')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAbukNOXKPE1M-2Duze7aLXcRLguKXbJQ&libraries=places&sensor=false"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('frontend') }}/app-assets/vendors/css/forms/select/select2.min.css">
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
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style-rtl.css">
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <style>
        .note-btn-group i {
            color: white;
        }

        .member {
            display: none;
            width: 100%;
        }

        .iti.iti--allow-dropdown {
            width: 100%;
            direction: ltr;
        }

        #map-canvas {
            width: 100%;
            height: 350px;
        }

        #pac-input {
            z-index: 0 !important;
            position: absolute !important;
            top: 0px !important;
            left: 0 !important;
            width: 100% !important;
            height: 40px !important;
            padding: 0 6px !important;
            border: 2px solid #ce8483 !important;
            border-radius: 3px !important;
        }

        .form-row {
            width: 100%;
        }
    </style>
    <!-- END: Custom CSS-->
@endsection
@section('frontend-main')
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                @include('common.errors')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> تعديل إعدادات التقرير  </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('update_reports_settings',Route::current()->parameter('subdomain')) }}" id="myform"
                                  enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PATCH') }}

                                <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            تصميم التقرير
                                        </h3>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="stamp">صورة الختم</label>
                                            <div class="custom-file">
                                                <input name="stamp" type="file" class="custom-file-input" id="stamp"
                                                       onchange="readURL3(this);"/>
                                                <label class="custom-file-label" for="image_commercial">اضغط لاختيار
                                                    الصورة</label>
                                            </div>
                                            @error('stamp')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->stamp_url) class="blah_create" @endif id="blah3"
                                                 src="{{ $setting->stamp_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="logo"> صورة شعار المؤسسة</label>
                                            <div class="custom-file">
                                                <input name="logo" type="file" class="custom-file-input"
                                                       id="logo"
                                                       onchange="readURL4(this);"/>
                                                <label class="custom-file-label" for="logo">اضغط لاختيار الصورة</label>
                                            </div>
                                            @error('logo')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->logo_url) class="blah_create" @endif id="blah4"
                                                 src="{{ $setting->logo_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="header">صورة هيدر التقرير</label>
                                            <div class="custom-file">
                                                <input name="header" type="file" class="custom-file-input" id="header"
                                                       onchange="readURL5(this);"/>
                                                <label class="custom-file-label" for="header">اضغط لاختيار
                                                    الصورة</label>
                                            </div>
                                            @error('header')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->header_url) class="blah_create" @endif id="blah5"
                                                 src="{{ $setting->header_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="footer"> صورة فوتر التقرير</label>
                                            <div class="custom-file">
                                                <input name="footer" type="file" class="custom-file-input"
                                                       id="footer"
                                                       onchange="readURL6(this);"/>
                                                <label class="custom-file-label" for="footer">اضغط لاختيار الصورة</label>
                                            </div>
                                            @error('footer')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->footer_url) class="blah_create" @endif id="blah6"
                                                 src="{{ $setting->footer_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="background">صورة العلامة المائية</label>
                                            <div class="custom-file">
                                                <input name="background" type="file" class="custom-file-input" id="background"
                                                       onchange="readURL7(this);"/>
                                                <label class="custom-file-label" for="background">اضغط لاختيار
                                                    الصورة</label>
                                            </div>
                                            @error('background')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->background_url) class="blah_create" @endif id="blah7"
                                                 src="{{ $setting->background_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="cover"> صورة غلاف التقرير</label>
                                            <div class="custom-file">
                                                <input name="cover" type="file" class="custom-file-input"
                                                       id="cover"
                                                       onchange="readURL8(this);"/>
                                                <label class="custom-file-label" for="cover">اضغط لاختيار الصورة</label>
                                            </div>
                                            @error('cover')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->cover_url) class="blah_create" @endif id="blah8"
                                                 src="{{ $setting->cover_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                    {{-- ------------------ --}}
                                    <div class="col-md-12 col-12 mb-3">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            القيم الافتراضية للبيانات والحقول
                                        </h3>
                                    </div>
                                   <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="offer_price">عرض السعر</label>
                                        <input type="number" name="offer_price" class="form-control" id="offer_price"
                                               placeholder="عرض السعر" value="{{$setting->offer_price}}"
                                               required>
                                        @error('offer_price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="price_delay">مدة عرض السعر</label>
                                        <input type="number" name="price_delay" class="form-control" id="price_delay"
                                               placeholder="مدة عرض السعر" value="{{$setting->price_delay}}" required>
                                        @error('price_delay')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-12 mb-3">
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
                                                <option value="{{ $currency->name }}"  @if($currency->name == $setting->currency) selected @endif>{{ $currency->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   </div>
                                   <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="work_area">نطاق العمل</label>
                                        <input type="text" name="work_area" class="form-control" id="work_area"
                                               placeholder="نطاق العمل" value="{{$setting->work_area}}"
                                               required>
                                        @error('work_area')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="work_delay">مده العمل</label>
                                        <input type="text" name="work_delay" class="form-control" id="work_delay"
                                               placeholder="مدة العمل" value="{{$setting->work_delay}}" required>
                                        @error('work_delay')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-6 mb-3">
                                        <label for="payment_partitions">عدد الدفعات</label>
                                        <input type="number" name="payment_partitions" class="form-control" id="payment_partitions"
                                               placeholder="عدد الدفعات" value="{{$setting->payment_partitions}}" required>
                                        @error('payment_partitions')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   </div>
                                   <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="report_standards">معايير التقييم</label>


                                               <div class="form-group">
                                                        <select name="report_standards" id="report_standards"
                                                                class="select2 form-control" required>

                                                            <option value="2020" @selected($setting->report_standards == '2020')> 2020</option>
                                                            <!--<option value="2021"> 2021</option>-->
                                                            <option value="2022" @selected($setting->report_standards == '2022')> 2022</option>

                                                            <option value="2024" @selected($setting->report_standards == '2024')> 2024</option>

                                                        </select>
                                                    </div>
                                        @error('report_standards')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="report_desc">وصف التقرير</label>
                                        <div class="form-group">
                                                        <select name="report_desc" id="report_desc"
                                                                class="select2 form-control">

                                                            <option value="ورقي" @selected($setting->report_desc == 'ورقي')>ورقي </option>
                                                            <option value="الكتروني" @selected($setting->report_desc == 'الكتروني')>الكتروني </option>

                                                        </select>
                                                    </div>
                                        @error('report_desc')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-12 mb-3">
                                        <label for="report_kind">
                                            نوع التقرير
                                        </label>
                                        <div class="form-group">
                                            <select name="report_kind" id="report_kind"
                                                    class="select2 form-control">
                                                <option selected hidden disabled value="">اختر نوع التقرير
                                                </option>
                                                <option value="تقرير مفصل" @selected($setting->report_kind =="تقرير مفصل") >تقرير مفصل </option>
                                                <option value="ملخص التقرير" @selected($setting->report_kind=="ملخص التقرير")>ملخص التقرير </option>
                                                <option value="مراجعة مع قيمة جديدة" @selected($setting->report_kind =="مراجعة مع قيمة جديدة")>مراجعة مع قيمة جديدة</option>
                                                <option value="مراجعة بدون قيمة جديدة" @selected($setting->report_kind =="مراجعة بدون قيمة جديدة")>مراجعة بدون قيمة جديدة</option>
                                            </select>
                                        </div>
                                        @error('report_kind')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   </div>

                                </div>
                                <hr>
                                <button class="btn btn-primary" type="submit">حفظ</button>
                            </form>
                        </div>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#myform").validate({
                rules: {
                    name_arabic: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    name_english: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                },
                messages: {
                    name_arabic: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                    name_english: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                }
            });
        });
    </script>
    <script>
                {{ $setting->lat }}
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {
                    lat: {{ $setting->lat }},
                    lng: {{ $setting->lng }},
                },
                zoom: 15
            });
        var marker = new google.maps.Marker({
            position: {
                lat: {{ $setting->lat }},
                lng: {{ $setting->lng }},
            },
            map: map,
            draggable: true
        });
        var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
        google.maps.event.addListener(searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for (i = 0; place = places[i]; i++) {
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location); //set marker position new...
            }
            map.fitBounds(bounds);
            map.setZoom(15);
        });
        google.maps.event.addListener(marker, 'position_changed', function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            $('#lat').val(lat);
            $('#lng').val(lng);
        });
    </script>

@endsection

