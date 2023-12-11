@extends('frontend.layout.master')
@section('frontend-head')
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
        }
        .iti.iti--allow-dropdown{
            width: 100%;
            direction: ltr;
        }
        .hh{
            display: none;
        }
    </style>
    <!-- END: Custom CSS-->
@endsection
@section('frontend-main')
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                @include('common.done')
                @include('common.errors')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">اضافة مستخدم جديد</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('users.store') }}" id="myform" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="not_client" name="membership_type">
                                {{-- <div class="form-row">
                                    <div class="col-sm-12 col-12">
                                        <label for="membership_level">
                                            نوع العضوية
                                        </label>
                                        <div class="form-group">
                                            <select name="membership_level" id="membership_level"
                                                    class="select2 form-control">
                                                <option disabled selected hidden>اختر نوع العضوية</option>
                                                @if(auth()->user()->membership_level == 'admin')
                                                    <option value="admin">مشرف شامل</option>
                                                    <option value="rater">مدير تقييم</option>
                                                    <option value="client">عميل</option>
                                                    <option value="entre">مدخل بيانات</option>
                                                    <option value="coordinator">منسق</option>
                                                    <option value="previewer">معاين</option>
                                                    <option value="reviewer">مراجع</option>
                                                @else
                                                    <option value="client">عميل</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('membership_level')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="py-2">
                                    <h3
                                        class="d-inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                        الأدوار</h3>
                                    <div class="row  ">
                                        @forelse ($roles as $role)
                                        <div class="col-sm-6 col-md-4 col-lg-3 mb-1">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                        @empty
                                        ----
                                        @endforelse
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="name">الاسم </label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="الاسم" value="{{ old('name') }}" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3 hh">
                                        <label class="admin" for="name_en">الاسم بالانجليزية</label>
                                        <label class="client" for="name_en">مسؤل التواصل</label>
                                        <input type="text" name="name_en" class="form-control" id="name_en"
                                               placeholder="الاسم " value="{{ old('name_en') }}" required>
                                        @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="name">البريد </label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="البريد" value="{{ old('email') }}" required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="password">الرقم السري </label>
                                        <input type="password" name="password" class="form-control" id="password"
                                               placeholder="الرقم السري" value="{{ old('password') }}" required>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="phone_1">الهاتف الاول </label>
                                        <input type="tel" name="phone_1"
                                               class="form-control" id="phone_1" placeholder="رقم الهاتف الاول"
                                               value="{{ old('phone_1') }}" required>
                                        @error('phone_1')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="phone_2">الهاتف الثاني </label>
                                        <input type="tel" name="phone_2"
                                               class="form-control" id="phone_2" placeholder="رقم الهاتف الثاني"
                                               value="{{ old('phone_2') }}">
                                        @error('phone_2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="mobile_1">الجوال الاول </label>
                                        <input type="text" name="mobile_1" class="form-control" id="mobile_1"
                                               placeholder="رقم الجوال الاول" value="{{ old('mobile_1') }}" required>
                                        @error('mobile_1')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="mobile_2">الجوال الثاني </label>
                                        <input type="text" name="mobile_2" class="form-control" id="mobile_2"
                                               placeholder="رقم الجوال الثاني" value="{{ old('mobile_2') }}">
                                        @error('mobile_2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="member">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="member_date">تاريخ الالتحاق بالمؤسسة </label>
                                            <input type="date" name="member_date" class="form-control"
                                                   id="member_date" placeholder="تاريخ الالتحاق"
                                                   value="{{ old('member_date') }}">
                                            @error('member_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="identity_expire">تاريخ انتهاء الهوية </label>
                                            <input type="date" name="identity_expire" class="form-control"
                                                   id="member_date" placeholder="تاريخ انتهاء الهوية"
                                                   value="{{ old('identity_expire') }}">
                                            @error('identity_expire')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="identity">نوع الهوية </label>
                                            <input type="text" name="identity" class="form-control"
                                                   id="identity" placeholder="نوع الهوية"
                                                   value="{{ old('identity') }}">
                                            @error('identity')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="identity_number">رقم الهوية </label>
                                            <input type="text" name="identity_number" class="form-control"
                                                   id="identity_number" placeholder="رقم الهوية"
                                                   value="{{ old('identity_number') }}">
                                            @error('identity_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="member">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="col-md-12">
                                            <h4>
                                                معلومات العضوية
                                            </h4>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-image">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">صورة العضوية</label>
                                                <div class="custom-file">
                                                    <input name="image" type="file" class="custom-file-input" id="image"
                                                           onchange="readURL(this);"/>
                                                    <label class="custom-file-label" for="image">اضغط لاختيار الصورة</label>
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>
                                            <div class="text-center">
                                                <img class="blah_create" id="blah" src="" alt="your image"/>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-image">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">الصورة الخاصة بالتوقيع</label>
                                                <div class="custom-file">
                                                    <input name="signature_image" type="file" class="custom-file-input"
                                                           id="signature_image" onchange="readURL2(this);"/>
                                                    <label class="custom-file-label" for="signature_image">اضغط لاختيار
                                                        الصورة</label>
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>
                                            <div class="text-center">
                                                <img class="blah_create" id="blah2" src="" alt="your image"/>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="membership_expire">تاريخ انتهاء العضوية </label>
                                            <input type="date" name="membership_expire" class="form-control"
                                                   id="membership_expire" placeholder="تاريخ انتهاء العضوية"
                                                   value="{{ old('membership_expire') }}">
                                            @error('membership_expire')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="member_number">رقم العضوية</label>
                                            <input type="text" name="member_number" class="form-control"
                                                   id="member_number" placeholder="رقم العضوية"
                                                   value="{{ old('member_number') }}">
                                            @error('member_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" checked=""
                                                       name="facility" value="1"
                                                       class="custom-control-input" id="facility">
                                                <label class="custom-control-label" for="facility">
                                                    مسجل تحت في المنشأة في قيمة؟</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="member">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <h4>
                                                معلومات العقد
                                            </h4>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-image">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">الصورة الخاصة العقد</label>
                                                <div class="custom-file">
                                                    <input name="contract_image" type="file" class="custom-file-input"
                                                           id="contract_image" onchange="readURL3(this);"/>
                                                    <label class="custom-file-label" for="contract_image">اضغط لاختيار
                                                        الصورة</label>
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>
                                            <div class="text-center">
                                                <img class="blah_create" id="blah3" src="" alt="your image"/>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="contract_expire">تاريخ انتهاء العقد </label>
                                            <input type="date" name="contract_expire" class="form-control"
                                                   id="contract_expire" placeholder="تاريخ انتهاء العقد"
                                                   value="{{ old('contract_expire') }}">
                                            @error('membership_expire')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="contract_delay">مدة العقد بالشهور </label>
                                            <input type="number" name="contract_delay" class="form-control"
                                                   id="contract_delay" placeholder="مدة العقد"
                                                   value="{{ old('contract_delay') }}">
                                            @error('contract_delay')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" checked=""
                                                       name="contract_automatic_reactive" value="1"
                                                       class="custom-control-input" id="contract_automatic_reactive">
                                                <label class="custom-control-label" for="contract_automatic_reactive">العقد
                                                    يتجدد تلقائيا</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" checked=""
                                                   name="active" value="1" class="custom-control-input"
                                                   id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">فعال</label>
                                        </div>
                                    </div>
                                </div>
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
        $(document).ready(function () {
            // validate signup form on keyup and submit
            $("#myform").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    phone_1: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    mobile_1: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                },
                messages: {
                    name: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                    password: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                    phone_1: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                    mobile_1: {
                        required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                }
            });
        });

        $('#membership_level').change(function () {
            if ($('#membership_level').val() != 'client') {
                $('.member').show();
                $('.client').hide();
                $('.admin').show();
                $('.hh').show();
            } else {
                $('.member').hide();
                $('.admin').hide();
                $('.client').show();
                $('.hh').show();
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField_1 = document.querySelector("#mobile_1");
        const phoneInputField_2 = document.querySelector("#mobile_2");
        const phoneInput = window.intlTelInput(phoneInputField_1, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
        const phoneInput_2 = window.intlTelInput(phoneInputField_2, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
@endsection

