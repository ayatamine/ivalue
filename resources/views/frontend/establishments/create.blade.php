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
                @include('common.errors')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">اضافة منشأة جديدة</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('establishments.store') }}" id="myform">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="name">اسم الأدمن </label>

                                        <input type="text" name="name" class="form-control" id="name" placeholder="Admin name " value="{{ old('name') }}">

                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email">البريد الالكتروني للأدمن </label>

                                        <input type="text" name="email" class="form-control" id="email" placeholder="Admin email " value="{{ old('email') }}">

                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                                <label for="password">كلمة السر (افتراضيا 123456789)</label>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="" value="{{ old('password') }}">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="establishment_name">اسم المنشأة </label>
                                        <input type="text" name="establishment_name" class="form-control" id="establishment_name" placeholder="Establishment name " value="{{ old('establishment_name') }}">
                                        @error('establishment_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                                <label for="domain">اسم الدومين (بالانجليزي فقط )</label>
                                                <input type="text" name="domain" class="form-control" id="domain" placeholder="Domin name in English" value="{{ old('domain') }}">
                                                @error('domain')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="database">قاعدة البيانات (من الاستضافة) </label>
                                        <input type="text" name="database" class="form-control" id="database" placeholder="Establishment name " value="{{ old('database') }}">
                                        @error('database')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                                <label for="database_username">اسم المستخدم (بالانجليزي فقط )</label>
                                                <input type="text" name="database_username" class="form-control" id="database_username" placeholder="Domin name in English" value="{{ old('database_username') }}">
                                                @error('database_username')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                                <label for="database_password">كلمة السر (بالانجليزي فقط )</label>
                                                <input type="text" name="database_password" class="form-control" id="database_password" placeholder="Domin name in English" value="{{ old('database_password') }}">
                                                @error('database_password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="name">الاسم </label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="الاسم " value="{{ old('name') }}" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="name_en">الاسم بالانجليزي</label>
                                        <input type="text" name="name_en" class="form-control" id="name_en" placeholder="Name in English" value="{{ old('name_en') }}">
                                        @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}


                                {{-- <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="bio">نبذة تعريفية</label>
                                        <textarea name="bio" class="form-control" id="bio" placeholder="Bio">{{ old('bio') }}</textarea>
                                        @error('bio')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Repeat the above structure for other fields based on the provided validation rules -->



                                <!-- Phone numbers -->
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone1"> رقم الجوال 1</label>
                                        <input type="tel" name="phone1" class="form-control" id="phone1" placeholder="Phone 1" value="{{ old('phone1') }}" required>
                                        @error('phone1')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone2"> رقم الجوال 2</label>
                                        <input type="tel" name="phone2" class="form-control" id="phone2" placeholder="Phone 2" value="{{ old('phone2') }}" >
                                        @error('phone2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- Email +  -->
                                 <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email">البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}" >
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="whatstapp_number">رقم الواتساب</label>
                                        <input type="text" name="whatstapp_number" class="form-control" id="whatstapp_number" placeholder="whatstapp_number" value="{{ old('whatstapp_number') }}" >
                                        @error('whatstapp_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="">
                                    <label for="country"> عنوان المنشأة</label>
                                    <div class="row">
                                        <div class="col-md-3 col-12 mb-3">
                                            <label for="country"> الدولة</label>
                                            <select name="country" class="form-control" id="country"  required value="{{ old('country') }}">
                                                <option value="" selected disabled>اختر</option>
                                                @foreach (\App\Models\Country::latest()->get() as $country)
                                                 <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <label for="zone"> المنطقة</label>
                                            <input type="text" name="zone" class="form-control" id="zone" placeholder="المنطقة" value="{{ old('zone') }}" >
                                            @error('zone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <label for="city"> المدينة</label>
                                            <select  name="city" class="form-control" id="city"  value="{{ old('city') }}">
                                            </select>
                                            @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <label for="street"> الحي</label>
                                            <input type="text" name="street" class="form-control" id="street" placeholder="الحي" value="{{ old('street') }}" >
                                            @error('street')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                                <label for="city"> المدينة</label>
                                                <select  name="city" class="form-control" id="city"  value="{{ old('city') }}">
                                                </select>
                                                @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="website_link"> رابط الموقع</label>
                                        <input type="text" name="website_link" class="form-control" id="website_link" placeholder="رابط الموقع" value="{{ old('website_link') }}" >
                                        @error('website_link')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="commercial_register_number">رقم السجل التجاري</label>
                                        <input type="number" name="commercial_register_number" class="form-control" id="commercial_register_number" placeholder="Commercial Register Number" value="{{ old('commercial_register_number') }}" required>
                                        @error('commercial_register_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                     <!-- Commercial Register Photo -->
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="commercial_register_photo">صورة السجل التجاري</label>
                                        <input type="file" name="commercial_register_photo" class="form-control-file" id="commercial_register_photo" required>
                                        @error('commercial_register_photo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="tax_number">الرقم الضريبي</label>
                                        <input type="number" name="tax_number" class="form-control" id="tax_number" placeholder="Tax Number" value="{{ old('tax_number') }}" required>
                                        @error('tax_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="tax_certificate_image">صورة شهادة الضريبة</label>
                                        <input type="file" name="tax_certificate_image" class="form-control-file" id="tax_certificate_image" required>
                                        @error('tax_certificate_image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="license_number">رقم رخصةالهيئة</label>
                                        <input type="number" name="license_number" class="form-control" id="license_number" placeholder="License Number" value="{{ old('license_number') }}" required>
                                        @error('license_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                <!-- Example structure for the 'license_image' field -->
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="license_image">صورة رخصة الهيئة</label>
                                        <input type="file" name="license_image" class="form-control-file" id="license_image" required>
                                        @error('license_image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Example structure for the 'evaluation_branch' field -->
                                <div class="form-row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="evaluation_branch">فرع التقييم</label>
                                        <input type="text" name="evaluation_branch" class="form-control" id="evaluation_branch" placeholder="Evaluation Branch" value="{{ old('evaluation_branch') }}" required>
                                        @error('evaluation_branch')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                <!-- Example structure for the 'evaluation_end_date' field -->
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="evaluation_end_date">تاريخ الانتهاء</label>
                                        <input type="date" name="evaluation_end_date" class="form-control" id="evaluation_end_date" required>
                                        @error('evaluation_end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <!-- Example structure for the 'domain' field -->
                                {{-- <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="domain">Domain</label>
                                        <input type="text" name="domain" class="form-control" id="domain" placeholder="Domain" value="{{ old('domain') }}" required>
                                        @error('domain')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <!-- Example structure for the 'database' field -->
                                {{-- <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="database">Database</label>
                                        <input type="text" name="database" class="form-control" id="database" placeholder="Database" value="{{ old('database') }}" required>
                                        @error('database')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <hr>
                                <button class="btn btn-primary" type="submit">اضافة</button>
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
        $(document).ready(function() {
            document.getElementById('country').addEventListener('change', function() {
            var country = this.value;
            // var url = this.getAttribute('data-url').replace('{country}', country);
            var url = `/cities/by-country/${country}`
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    var cities = JSON.parse(this.responseText);
                    var citySelect = document.getElementById('city');
                    citySelect.innerHTML = '';
                    cities.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.name;
                        option.text = city.name;
                        citySelect.add(option);
                    });
                }
            };
            xhr.send();
        });
            // validate signup form on keyup and submit
            // $("#myform").validate({
            //     rules: {
            //         name: {
            //             required: true,
            //             minlength: 3,
            //             maxlength: 100,
            //         },
            //         country_id: {
            //             required: true,
            //         },
            //     },
            //     messages:{
            //         name: {
            //             required : 'هذا الحقل مطلوب',
            //             minlength : 'هذا الحقل مطلوب اقل من المسموح',
            //         },
            //         country_id: {
            //             required : 'هذا الحقل مطلوب',
            //         },
            //     }
            // });
        });
    </script>
@endsection

