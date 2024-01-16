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
                        <h4 class="card-title"> تعديل إعدادات التقييم  </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('update_rating_settings',Route::current()->parameter('subdomain')) }}" id="myform"
                                  enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PATCH') }}

                                <div class="form-row">

                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            نسبة مراحل التقييم من مدة التقييم (%)
                                        </h3>
                                    </div>
                                   <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="previewer">المعاينة</label>
                                        <input type="number" max="100" name="step_percentage[previewer]" class="form-control" id="previewer"
                                               placeholder="المعاينة" value="{{$step_percentage['previewer']}}"
                                               required>
                                        @error('previewer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="rater">التقييم</label>
                                        <input type="number" max="100" name="step_percentage[rater]" class="form-control" id="rater"
                                               placeholder="التقييم" value="{{$step_percentage['rater']}}"
                                               required>
                                        @error('rater')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="reviewer">المراجعة</label>
                                        <input type="number" max="100" name="step_percentage[reviewer]" class="form-control" id="reviewer"
                                               placeholder="المراجعة" value="{{$step_percentage['reviewer']}}"
                                               required>
                                        @error('reviewer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="approver">الاعتماد</label>
                                        <input type="number" max="100" name="step_percentage[approver]" class="form-control" id="approver"
                                               placeholder="الاعتماد" value="{{$step_percentage['approver']}}"
                                               required>
                                        @error('approver')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="value_approver">اعتماد القيمة</label>
                                        <input type="number" max="100" name="step_percentage[value_approver]" class="form-control" id="value_approver"
                                               placeholder="اعتماد القيمة" value="{{$step_percentage['value_approver']}}"
                                               required>
                                        @error('value_approver')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="submit_report">تسليم التقرير</label>
                                        <input type="number" max="100" name="step_percentage[submit_report]" class="form-control" id="submit_report"
                                               placeholder="تسليم التقرير" value="{{$step_percentage['submit_report']}}"
                                               required>
                                        @error('submit_report')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                   </div>

                                </div>
                                <hr>
                                <div class="form-row">

                                    <div class="col-md-12 col-12 mb-3">
                                        <h3>
                                            نسبة ساعات العمل على التقرير للمشاركين (%)
                                        </h3>
                                    </div>
                                   <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="previewer">المعاين</label>
                                        <input type="number" max="100" name="work_hour_percentage[previewer]" class="form-control" id="previewer"
                                               placeholder="المعاين" value="{{$step_percentage['previewer']}}"
                                               required>
                                        @error('previewer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="rater">المقيم</label>
                                        <input type="number" max="100" name="work_hour_percentage[rater]" class="form-control" id="rater"
                                               placeholder="المقيم" value="{{$step_percentage['rater']}}"
                                               required>
                                        @error('rater')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="reviewer">المراجع</label>
                                        <input type="number" max="100" name="work_hour_percentage[reviewer]" class="form-control" id="reviewer"
                                               placeholder="المراجع" value="{{$step_percentage['reviewer']}}"
                                               required>
                                        @error('reviewer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="approver">المعتمد</label>
                                        <input type="number" max="100" name="work_hour_percentage[approver]" class="form-control" id="approver"
                                               placeholder="المعتمد" value="{{$step_percentage['approver']}}"
                                               required>
                                        @error('approver')
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

