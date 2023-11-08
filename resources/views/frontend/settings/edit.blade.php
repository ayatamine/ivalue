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
                        <h4 class="card-title"> تعديل معلومات المنشأة  </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('update_settings') }}" id="myform"
                                  enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            بيانات المنشأة
                                        </h3>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="name_arabic">الاسم </label>
                                        <input type="text" name="name_arabic" class="form-control" id="name_arabic"
                                               placeholder="الاسم " value="{{$setting->title}}" required>
                                        @error('name_arabic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="name_english">الاسم بالانجليزية</label>
                                        <input type="text" name="name_english" class="form-control" id="name_english"
                                               placeholder="الاسم بالانجليزية" value="{{$setting->title_en}}"
                                               required>
                                        @error('name_english')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="phone">رقم الهاتف</label>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                               placeholder="رقم الهاتف" value="{{$setting->phone}}"
                                               required>
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="mobile">رقم الجوال</label>
                                        <input type="text" name="mobile" class="form-control" id="mobile"
                                               placeholder="رقم الجوال" value="{{$setting->mobile}}"
                                               required>
                                        @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="whatsapp">رقم الجوال</label>
                                        <input type="text" name="whatsapp" class="form-control" id="whatsapp"
                                               placeholder="رقم الجوال" value="{{$setting->whats}}"
                                               required>
                                        @error('whatsapp')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="email">البريد الاكتروني</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="البريد الاكتروني" value="{{$setting->email}}"
                                               required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="website">عنوان الموقع الالكتروني</label>
                                        <input type="url" name="website" class="form-control" id="website"
                                               placeholder="عنوان الموقع الالكتروني" value="{{$setting->website}}"
                                               required>
                                        @error('website')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="about">نبذة عن المنشأة</label>
                                        <textarea type="text" name="about" class="form-control" id="about"
                                                  placeholder="نبذة عن المنشأة" required>{{$setting->about}}</textarea>
                                        @error('about')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="address">عنوان المنشأة</label>
                                        <textarea type="text" name="address" class="form-control" id="address"
                                                  placeholder="عنوان المنشأة" required>{{$setting->address}}</textarea>
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            المستندات
                                        </h3>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="commercial_number">رقم السجل التجاري</label>
                                        <input type="text" name="commercial_number" class="form-control"
                                               id="commercial_number"
                                               placeholder="رقم السجل التجاري" value="{{$setting->commercial_number}}"
                                               required>
                                        @error('commercial_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="commercial_date">تاريخ انتهاء السجل التجاري</label>
                                        <input type="date" name="commercial_date" class="form-control"
                                               id="commercial_date"
                                               placeholder="تاريخ انتهاء السجل التجاري"
                                               value="{{$setting->commercial_date ? \Carbon\Carbon::parse($setting->commercial_date)->format('Y-m-d') : ''}}"
                                               required>
                                        @error('commercial_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="license_number">رقم رخصة الهيئة</label>
                                        <input type="text" name="license_number" class="form-control"
                                               id="license_number"
                                               placeholder="رقم رخصة الهيئة" value="{{$setting->license_number}}"
                                               required>
                                        @error('license_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="license_date">تاريخ انتهاء رخصة الهيئة</label>
                                        <input type="date" name="license_date" class="form-control" id="license_date"
                                               placeholder="تاريخ انتهاء رخصة الهيئة"
                                               value="{{$setting->license_date ? \Carbon\Carbon::parse($setting->license_date)->format('Y-m-d') : ''}}"
                                               required>
                                        @error('license_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="image_commercial">صورة السجل التجاري</label>
                                            <div class="custom-file">
                                                <input name="image_commercial" type="file" class="custom-file-input"
                                                       id="image_commercial"
                                                       onchange="readURL(this);"/>
                                                <label class="custom-file-label" for="image_commercial">اضغط لاختيار
                                                    الصورة</label>
                                            </div>
                                            @error('image_commercial')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->image_commercial_url) class="blah_create"
                                                 @endif id="blah" src="{{ $setting->image_commercial_url }}"
                                                 alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-image">
                                        <fieldset class="form-group">
                                            <label for="image_license"> صورة رخصة الهيئة</label>
                                            <div class="custom-file">
                                                <input name="image_license" type="file" class="custom-file-input"
                                                       id="image_license"
                                                       onchange="readURL2(this);"/>
                                                <label class="custom-file-label" for="image_license">اضغط لاختيار
                                                    الصورة</label>
                                            </div>
                                            @error('image_license')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <div class="text-center">
                                            <img @if(!$setting->image_license_url) class="blah_create" @endif id="blah2"
                                                 src="{{ $setting->image_license_url }}" alt="your image"/>
                                        </div>
                                        <br>
                                    </div>
                                </div>
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

