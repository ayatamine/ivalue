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

        .member,.no_member {
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

        #files-area {
            /* width: 30%; */
            margin: 0 auto;
        }
        #files-names{
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }
        .file-block {
            border-radius: 10px;
            background-color: rgba(144, 163, 203, 0.2);
            margin: 5px;
            color: initial;
            display: flex;
            height: 140px;
            flex-direction: column;
            padding: 1rem;
            width: 150px;
    overflow: hidden;
    white-space: nowrap;
        }
        .file-block img{
            height: 70px;
            width: 70px;
            margin: auto;
            margin-top: 0.5rem;
        }
        .file-block > span.name {
            padding-right: 10px;
            width: max-content;
            display: inline-flex;
        }
        .file-delete {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff 0;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;
        }
        .file-delete:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }
        .file-delete > span {
            transform: rotate(45deg);
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
                        <h4 class="card-title"> اضافة طلب تقييم </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('estates.store') }}" id="myform"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    {{--<div class="col-lg-12 col-md-12 col-image">--}}
                                    {{--<fieldset class="form-group">--}}
                                    {{--<label for="basicInputFile">الصورة الخاصة بالعقار</label>--}}
                                    {{--<div class="custom-file">--}}
                                    {{--<input name="image" type="file" class="custom-file-input" id="image"--}}
                                    {{--onchange="readURL(this);"/>--}}
                                    {{--<label class="custom-file-label" for="image">اضغط لاختيار الصورة</label>--}}
                                    {{--</div>--}}
                                    {{--@error('image')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                    {{--</fieldset>--}}
                                    {{--<div class="text-center">--}}
                                    {{--<img class="blah_create" id="blah" src="" alt="your image"/>--}}
                                    {{--</div>--}}
                                    {{--<br>--}}
                                    {{--</div>--}}
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="name_arabic">عميل التقييم   </label>
                                        <input type="text" name="name_arabic" class="form-control" id="name_arabic"
                                               placeholder="الاسم " value="{{old('name_arabic')}}" required>
                                        @error('name_arabic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{--<div class="col-md-12 col-12 mb-3">--}}
                                    {{--<label for="name_english">الاسم بالانجليزية</label>--}}
                                    {{--<input type="text" name="name_english" class="form-control" id="name_english"--}}
                                    {{--placeholder="الاسم بالانجليزية" value="{{old('name_english')}}" required>--}}
                                    {{--@error('name_arabic')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="kind_id">
                                                    نوع العقار
                                                </label>
                                                <div class="form-group">
                                                    <select name="kind_id" id="kind_id"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر نوع العقار
                                                        </option>
                                                        @foreach($kinds as $kind)
                                                            <option value="{{ $kind->id }}">{{ $kind->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('kind_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="member col-md-3 col-12 mb-3">
                                       <div class="row">
                                           <div class="col-md-12 col-12 mb-3">
                                               <div class="form-row">
                                                   <div class="col-sm-12 col-12">
                                                       <label for="kind_id">
                                                            نوع المبنى
                                                       </label>
                                                       <div class="form-group">
                                                           <select name="category_id" id="category_id"
                                                                   class="select2 form-control" required>
                                                               <option selected hidden disabled value="">اختر التصنيف
                                                                   للعقار
                                                               </option>
                                                               @foreach($categories as $category)
                                                                   <option value="{{ $category->id }}">{{ $category->name }} </option>
                                                               @endforeach
                                                           </select>
                                                       </div>
                                                       @error('category_id')
                                                       <span class="text-danger">{{ $message }}</span>
                                                       @enderror
                                                   </div>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="diuretic">
                                                    هل العقار مدر للدخل
                                                </label>
                                                <div class="form-group">
                                                    <select name="diuretic" id="diuretic"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر</option>
                                                        <option value="نعم">نعم</option>
                                                        <option value="لا">لا</option>

                                                    </select>
                                                </div>
                                                @error('diuretic')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="use">
                                                    الاستخدام
                                                    <small>(قم بالاختيار او كتابة سبب معين)</small>
                                                </label>

                                                <div class="form-group">
                                                    <input type="text" name="use" list="use" class="form-control">
                                                    <datalist id="use">
                                                        <option value="سكني">سكني</option>
                                                        <option value="تجاري">تجاري</option>
                                                        <option value="اداري">اداري</option>
                                                        <option value="زراعي">زراعي</option>
                                                        <option value="صناعي">صناعي</option>
                                                        <option value="مستودعات">مستودعات</option>
                                                        <option value="تعليمي">تعليمي</option>
                                                        <option value="صحي">صحي</option>
                                                        <option value="ترفيهي">ترفيهي</option>
                                                        <option value="خدمات عامة">خدمات عامة</option>
                                                    </datalist>
                                                </div>
                                                @error('use')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="country_id">
                                                    الدولة
                                                </label>
                                                <div class="form-group">
                                                    <select name="country_id" id="country_id"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر دولة العقار
                                                        </option>
                                                        @foreach($countries as $kind)
                                                            <option value="{{ $kind->id }}">{{ $kind->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('country_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="city_id">
                                                    المدينة
                                                </label>
                                                <div class="form-group">
                                                    <select name="city_id" id="city_id"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر مدينة
                                                            العقار
                                                        </option>
                                                        @foreach($cities as $kind)
                                                            <option value="{{ $kind->id }}">{{ $kind->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('city_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="kind_id">
                                                     عميل المنشأة
                                                </label>
                                                <div class="form-group">
                                                    <select name="user_id" id="user_id"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر صاحب العقار
                                                        </option>
                                                        @foreach($users as $estate)
                                                            <option value="{{ $estate->id }}">{{ $estate->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="address"> (الحي) </label>
                                        <textarea rows="5" type="text" name="address"
                                                  class="form-control" id="address" placeholder="عنوان "
                                                  value=""></textarea>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="address">العنوان تفصيليا + (الحي - المنطقة) </label>
                                        <textarea rows="5" type="text" name="address"
                                                  class="form-control" id="address" placeholder="عنوان "
                                                  value=""></textarea>
                                    </div>
                                    {{--<div class="form-row">--}}
                                    {{--<div class="col-sm-12 col-12">--}}
                                    {{--<label for="level">--}}
                                    {{--مرحلة التقرير--}}
                                    {{--</label>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<select name="level" id="level"--}}
                                    {{--class="select2 form-control">--}}
                                    {{--<option selected hidden disabled value="">اختر مرحلة التقرير الخاصة بالعقار </option>--}}
                                    {{--<option value="rater">التقييم </option>--}}
                                    {{--<option value="entre">ادخال بيانات</option>--}}
                                    {{--<option value="coordinator">منسق</option>--}}
                                    {{--<option value="previewer">معاين</option>--}}
                                    {{--<option value="reviewer">مراجع</option>--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--@error('level')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="files">ارفاق المستندات
                                        <small class="text-danger">
                                            ( الملفات الأولية )
                                        </small>
                                        </label>
                                        <p class="mt-5 text-center">
                                            <label for="attachment">
                                                <a class="btn btn-primary text-light" role="button" aria-disabled="false">+ Add</a>

                                            </label>
                                            <input type="file" name="files[]" id="attachment" style="visibility: hidden; position: absolute;" multiple/>

                                        </p>
                                        <p id="files-area">
	<span id="filesList">
		<span id="files-names"></span>
	</span>
                                        </p>
                                        @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">الموقع على الخريطة</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="map-canvas"></div>
                                                            <input id="pac-input" type="text"
                                                                   placeholder="ابحث عن مدينتك...">
                                                            <input type="hidden" id="lat" name="lat" value="24.774265"
                                                                   required>
                                                            <input type="hidden" id="lng" name="lng" value="46.738586"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="member">
                                       <div class="row">
                                           <!--<div class="col-md-3 col-12 mb-3">-->
                                           <!--    <div class="form-row">-->
                                           <!--        <div class="col-sm-12 col-12">-->
                                           <!--            <label for="kind_id">-->
                                           <!--                 نوع المبنى-->
                                           <!--            </label>-->
                                           <!--            <div class="form-group">-->
                                           <!--                <select name="category_id" id="category_id"-->
                                           <!--                        class="select2 form-control" required>-->
                                           <!--                    <option selected hidden disabled value="">اختر التصنيف-->
                                           <!--                        للعقار-->
                                           <!--                    </option>-->
                                           <!--                    @foreach($categories as $category)-->
                                           <!--                        <option value="{{ $category->id }}">{{ $category->name }} </option>-->
                                           <!--                    @endforeach-->
                                           <!--                </select>-->
                                           <!--            </div>-->
                                           <!--            @error('category_id')-->
                                           <!--            <span class="text-danger">{{ $message }}</span>-->
                                           <!--            @enderror-->
                                           <!--        </div>-->
                                           <!--    </div>-->
                                           <!--</div>-->

                                           <div class="col-md-3 col-12 mb-3">
                                               <label for="build_size">مساحة المبني</label>
                                               <input type="number" name="build_size"
                                                      class="form-control" id="build_size" placeholder=""
                                                      value="{{old('build_size')}}">
                                               @error('build_size')
                                               <span class="text-danger">{{ $message }}</span>
                                               @enderror
                                           </div>
                                           <div class="col-md-3 col-12 mb-3">
                                               <label for="age">عمر العقار بالسنوات</label>
                                               <input type="number" name="age"
                                                      class="form-control" id="age" placeholder=""
                                                      value="{{old('$estate->age')}}">
                                               @error('age')
                                               <span class="text-danger">{{ $message }}</span>
                                               @enderror
                                           </div>
                                           <div class="col-md-3 col-12 mb-3">
                                               <label for="">عدد الادوار او الطوابق</label>
                                               <input type="number" name="level"
                                                      class="form-control" id="" placeholder=""
                                                      value="">
                                               @error('level')
                                               <span class="text-danger">{{ $message }}</span>
                                               @enderror
                                           </div>
                                       </div>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                               <label for="land_size">مساحة الارض</label>
                                               <input type="number" name="land_size"
                                                      class="form-control" id="land_size" placeholder=""
                                                      value="{{ old('land_size')}}" required>
                                               @error('land_size')
                                               <span class="text-danger">{{ $message }}</span>
                                               @enderror
                                           </div>
                                           <div class="col-md-12 col-12 mb-3">
                                           <label for="link"> رابط الموقع</label>
                                               <input type="link" name="link"
                                                      class="form-control" id="link" placeholder=""
                                                      value="{{ old('link')}}" required>
                                               @error('link')
                                               <span class="text-danger">{{ $message }}</span>
                                               @enderror
                                           </div>

                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="size_kind">
                                                    طريقة القياس
                                                </label>
                                                <div class="form-group">
                                                    <select name="size_kind" id="size_kind"
                                                            class="select2 form-control">
                                                        <option value="1">المتر المربع</option>
                                                        <option value="2">المتر المكعب</option>
                                                    </select>
                                                </div>
                                                @error('size_kind')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="reason">
                                                    الغرض من التقييم
                                                    <small>(قم بالاختيار او كتابة سبب معين)</small>
                                                </label>

                                                <div class="form-group">
                                                    <input type="text" name="reason" list="reason" class="form-control">
                                                    <datalist id="reason">
                                                        <option value="بيع">بيع</option>
                                                        <option value="شراء">شراء</option>
                                                        <option value="تمويل">تمويل</option>
                                                        <option value="الرهن">الرهن</option>
                                                        <option value="تقدري القيمة الاجارية">تقدري القيمة الاجارية
                                                        </option>
                                                        <option value="النزاعات والتقاضي">النزاعات والتقاضي</option>
                                                        <option value="التمويل">التمويل</option>
                                                        <option value="نزع الملكية">نزع الملكية</option>
                                                        <option value="اغراض محاسبية">اغراض محاسبية</option>
                                                        <option value="الضرائب">الضرائب</option>
                                                        <option value="الاستثمار">الاستثمار</option>
                                                        <option value="اغراض داخلية">اغراض داخلية</option>
                                                    </datalist>
                                                </div>
                                                @error('reason')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="about"> الوصف </label>
                                        <textarea rows="5" type="text" name="about"
                                                  class="form-control" id="about" placeholder="الوصف "
                                                  value=""></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" checked
                                                   name="active" value="1" class="custom-control-input"
                                                   id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">فعال</label>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-12 col-12 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="report_type">
                                                    المرحلة التالبة
                                                </label>
                                                <div class="form-group">
                                                    <select name="report_type" id="report_type"
                                                            class="select2 form-control">
                                                        <option selected hidden disabled value="">اختر نوع عملية الادخال
                                                        </option>
                                                        <option value="new">ادخال جديد
                                                        </option>
                                                        <option value="old"> اعتماد مسبق
                                                        </option>

                                                    </select>
                                                </div>
                                                @error('kind_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                <hr id="last_hr">
                                <div class="flex-column d-flex flex-md-row  justify-content-between align-items-center" style="    gap: 1%;" >
                                    <span class="btn btn-danger w-50  mb-1 mb-md-0" id="cancel_order">الغاء وحفظ كمسودة</span>
                                    <button class="btn btn-primary w-50  mb-1 mb-md-0" type="submit" id="submit_order">اضافة</button>
                                </div>
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

            $('#cancel_order').click(function (e) {
                e.preventDefault();
                $('#myform').append('<input type="text" class="d-none" name="cancel" id="draft_cancel" value="cancel" >')
                if($('#draft_note').length){
                    $('#myform').submit();
                }else{

                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="draft_note"> ملاحظة على المسودة </label>
                                        <textarea rows="5" type="text" name="draft_note"
                                                  class="form-control" id="draft_note" placeholder="اكتب ملاحظة على المسودة "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

             });
             $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#draft_cancel').remove();
               $('#draft_note').remove();
               $('#myform').submit();
             });
        });
        // if ($('#kind_id').val() != 1) {
        //     $('.member').show();
        //     $('.no_member').hide();
        // } else {
        //     $('.member').hide();
        //     $('.no_member').show();
        // }
        $('#kind_id').change(function () {
            if ($('#kind_id').val() != 1) {
                $('.member').show();
                $('.no_member').hide();
            } else {
                $('.member').hide();
                $('.no_member').show();
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
    <script>
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {
                lat: 24.774265,
                lng: 46.738586
            },
            zoom: 15
        });
        var marker = new google.maps.Marker({
            position: {
                lat: 24.774265,
                lng: 46.738586
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

        const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

        $("#attachment").on('change', function(e){
            for(var i = 0; i < this.files.length; i++){
                const reader = new FileReader();
                const img = document.createElement('img');
                reader.onload = function(event) {

                    img.src = event.target.result;
                    // previewContainer.appendChild(img);
                };
                reader.readAsDataURL(this.files.item(i));
                let fileBloc = $('<span/>', {class: 'file-block'}),
                    fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
                fileBloc.append('<span class="file-delete"><span>+</span></span>')
                    .append(fileName)
                    .append(img);
                $("#filesList > #files-names").append(fileBloc);
            };
            // Ajout des fichiers dans l'objet DataTransfer
            for (let file of this.files) {
                dt.items.add(file);
            }
            // Mise à jour des fichiers de l'input file après ajout
            this.files = dt.files;

            // EventListener pour le bouton de suppression créé
            $('span.file-delete').click(function(){
                let name = $(this).next('span.name').text();
                // Supprimer l'affichage du nom de fichier
                $(this).parent().remove();
                for(let i = 0; i < dt.items.length; i++){
                    // Correspondance du fichier et du nom
                    if(name === dt.items[i].getAsFile().name){
                        // Suppression du fichier dans l'objet DataTransfer
                        dt.items.remove(i);
                        continue;
                    }
                }
                // Mise à jour des fichiers de l'input file après suppression
                document.getElementById('attachment').files = dt.files;
            });
        });
    </script>
@endsection

