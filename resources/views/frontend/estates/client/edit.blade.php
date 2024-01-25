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
        .file-upload-container {
  border: 1px dashed #ddd;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.file-upload-container .icon-plus {
  font-size: 2em;
  color: #ddd;
}

#preview-container {
  display: flex;
  flex-wrap: wrap;
}

#preview-container img {
  width: 150px;
  height: 150px;
  margin: 10px;
  border: 1px solid #ddd;
}

.remove-file {
  position: absolute;
  top: 5px;
  right: 5px;
  background-color: #fff;
  border-radius: 50%;
  cursor: pointer;
}

.remove-file span {
  display: inline-block;
  font-size: 12px;
  line-height: 12px;
  padding: 0 5px;
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
                        <h4 class="card-title"> تعديل العقار {{$estate->name_arabic}}  </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" action="{{ route('client.estates.update' , ['estate'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" id="myform"
                                  enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PATCH') }}
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
                                    {{--<img @if(!$estate->image_url) class="blah_create" @endif id="blah" src="{{ $estate->image_url }}" alt="your image"/>--}}
                                    {{--</div>--}}
                                    {{--<br>--}}
                                    {{--</div>--}}
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="name_arabic">اسم المسؤول عن العقار  </label>
                                        <input type="text" name="name_arabic" class="form-control" id="name_arabic"
                                               placeholder="الاسم " value="{{$estate->name_arabic}}" required>
                                        @error('name_arabic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{--<div class="col-md-12 col-12 mb-3">--}}
                                    {{--<label for="name_english">الاسم بالانجليزية</label>--}}
                                    {{--<input type="text" name="name_english" class="form-control" id="name_english"--}}
                                    {{--placeholder="الاسم بالانجليزية" value="{{$estate->name_english}}" required>--}}
                                    {{--@error('name_arabic')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    <div class="col-md-3 mb-3">
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="kind_id">
                                                    نوع العقار
                                                </label>
                                                <div class="form-group">
                                                    <select name="kind_id" id="kind_id"
                                                            class="select2 form-control">
                                                        @foreach($kinds as $kind)
                                                            <option {{$kind->id == $estate->kind_id ? 'selected' : ''}} value="{{ $kind->id }}">{{ $kind->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('kind_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @if($estate->kind_id == 2)
                                    <div class="member col-md-3 col-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-3">
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-12">
                                                        <label for="category_id">
                                                             نوع المبنى
                                                        </label>
                                                        <div class="form-group">
                                                            <select name="category_id" id="category_id"
                                                                    class="select2 form-control" required>
                                                                <option selected hidden disabled value="">اختر التصنيف
                                                                    للعقار
                                                                </option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" @selected($category->id ==$estate->category_id) >{{ $category->name }} </option>
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
                                     <div class="build_size col-md-3 col-12 mb-3">
                                        <label for="build_size">مساحة المبني</label>
                                        <input type="number" name="build_size"
                                               class="form-control" id="build_size" placeholder=""
                                               value="{{ $estate->build_size}}">
                                        @error('build_size')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     @if(in_array($estate->category_id,[1,10,11]))
                                     <div class="floor col-md-3 col-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-3">
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-12">
                                                        <label for="floor">
                                                             الطابق
                                                        </label>
                                                        <div class="form-group">
                                                         <input type="number" name="floor"
                                                         class="form-control" id="floor" placeholder=""
                                                         value="{{$estate->floor}}">
                                                        </div>
                                                        @error('floor')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                     </div>
                                     @else

                                    <div class="level col-md-3 col-12 mb-3">
                                        <label for="">عدد الادوار او الطوابق</label>
                                        <input type="number" name="level"
                                               class="form-control" id="" placeholder=""
                                               value=" $estate->level">
                                        @error('level')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     @endif
                                    @else
                                    <div class="land_size col-md-3 col-12 mb-3">
                                        <label for="land_size">مساحة الارض</label>
                                        <input type="number" name="land_size"
                                               class="form-control" id="land_size" placeholder=""
                                               value="{{ $estate->land_size}}" required>
                                        @error('land_size')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @endif
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="use">
                                                الاستخدام
                                            </label>
                                            <?php
                                            $use = \App\Models\EstateInput::where('key', 'الاستخدام')->where('estate_id', $estate->id)->first();
                                            ?>
                                            <div class="form-group">
                                                <input type="text" name="use" class=" form-control" list="use"
                                                       value="{{ $use ? $use->value : '' }}">
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


                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="country_id">
                                                الدولة
                                            </label>
                                            <div class="form-group">
                                                <select name="country_id" id="country_id"
                                                        class="select2 form-control">
                                                    <?php
                                                    $city = \App\Models\City::find($estate->city_id);
                                                    ?>
                                                    @foreach($countries as $country)
                                                        @if($city)
                                                            <option {{ $city->zone->country_id == $country->id ? 'selected' : ''}} value="{{ $country->id }}">{{ $country->name }} </option>
                                                        @else
                                                            <option value="{{ $country->id }}">{{ $country->name }} </option>

                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="zone_id">
                                                المنطقة
                                            </label>
                                            <div class="form-group">
                                                <select name="zone_id" id="zone_id"
                                                        class="select2 form-control">
                                                    <?php
                                                    $city = \App\Models\City::find($estate->city_id);
                                                    ?>
                                                    @foreach($zones as $zone)
                                                        @if($city)
                                                            <option {{ $city->zone_id == $zone->id ? 'selected' : ''}} value="{{ $zone->id }}">{{ $zone->name }} </option>
                                                        @else
                                                            <option value="{{ $zone->id }}">{{ $zone->name }} </option>

                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('zone_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="city_id">
                                                المدينة
                                            </label>
                                            <div class="form-group">
                                                <select name="city_id" id="city_id"
                                                        class="select2 form-control">
                                                    <option selected hidden disabled value="">اختر مدينة العقار</option>
                                                    @foreach($cities as $kind)
                                                        <option {{ $estate->city_id == $kind->id ? 'selected' : ''}} value="{{ $kind->id }}">{{ $kind->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="address">العنوان تفصيليا +الحي   </label>
                                        <input type="text" name="address"
                                                        class="form-control" id="address" placeholder=""
                                                        value="{{$estate->address}}">
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="site_link"> رابط الموقع</label>
                                            <input type="site_link" name="site_link"
                                                   class="form-control" id="site_link" placeholder=""
                                                   value="{{ $estate->site_link}}" required>
                                            @error('site_link')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    {{--<div class="form-row">--}}
                                    {{--<div class="col-sm-12 col-12">--}}
                                    {{--<label for="level">--}}
                                    {{--مرحلة التقرير--}}
                                    {{--</label>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<select name="level" id="level"--}}
                                    {{--class="select2 form-control" required>--}}
                                    {{--<option selected hidden disabled value="">اختر مرحلة التقرير الخاصة بالعقار </option>--}}
                                    {{--<option {{ $estate->level == 'rater' ? 'selected' : ''}} value="rater">التقييم </option>--}}
                                    {{--<option {{ $estate->level == 'entre' ? 'selected' : ''}} value="entre">ادخال بيانات</option>--}}
                                    {{--<option {{ $estate->level == 'coordinator' ? 'selected' : ''}} value="coordinator">منسق</option>--}}
                                    {{--<option {{ $estate->level == 'previewer' ? 'selected' : ''}} value="previewer">معاين</option>--}}
                                    {{--<option {{ $estate->level == 'reviewer' ? 'selected' : ''}} value="reviewer">مراجع</option>--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--@error('level')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="files">مستندات العقار
                                        <small class="text-danger">
                                            ( الملفات الأولية )
                                        </small>
                                        </label>
                                        <input type="file" multiple name="files"  id="attachment"
                                               class="form-control"  placeholder=""
                                               >
                                        @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <p id="files-area">
                                        <span id="filesList">
                                            <span id="files-names">
                                        @if($estate->file_urls)
                                        @foreach($estate->file_urls as $file_url)

                                            {{-- <a href="{{ $file_url }}">
                                                <i class="fa fa-file"></i>
                                            </a> --}}
                                            <span class="file-block">
                                                {{-- <span class="file-delete"><span>+</span></span> --}}
                                                {{-- <span class="name">location_mark.svg</span> --}}
                                                {{-- <span class="delete-file-from"><span>+</span></span> --}}
                                                @if(strpos( mime_content_type(base_path('public/'.$file_url)), "image/") === 0)
                                                <img src="{{  url($file_url) }}">
                                                @else
                                                <a target="_blink" href="{{ url($file_url) }}" style="display: block;height: 70px;
                                                width: 70px;
                                                margin: auto;
                                                margin-top: 0.5rem;">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                                @endif
                                            </span>

                                        @endforeach
                                       @endif
                                    </span>
                                        </span>
                                    </p>
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
                                                            <input type="hidden" id="lat" name="lat"
                                                                   value="{{ $estate->lat }}" required>
                                                            <input type="hidden" id="lng" name="lng"
                                                                   value="{{ $estate->lng }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                        <?php
                                        $reason = \App\Models\EstateInput::where('key', 'سبب التقييم')->where('estate_id', $estate->id)->first();
                                        ?>
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-row">
                                                <div class="col-sm-12 col-12">
                                                    <label for="reason">
                                                        الغرض من التقييم
                                                        <small>(قم بالاختيار او كتابة سبب معين)</small>
                                                    </label>

                                                    <div class="form-group">
                                                        <input type="text" name="reason" list="reason"
                                                               class="form-control"
                                                               value="{{ $reason ? $reason->value : '' }}">
                                                        <datalist id="reason">
                                                            <option value="بيع">بيع</option>
                                                            <option value="شراء">شراء</option>
                                                            <option value="تمويل">تمويل</option>
                                                            <option value="الرهن">الرهن</option>
                                                            <option value="تقدير القيمة الايجارية">تقدير القيمة
                                                                الايجارية
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
                                        @if($estate->duration)
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="yearly" class="mb-1"> فترة القيمة الايجارية  </label>
                                            <div class="custom-control custom-radio ">
                                                <input type="radio" id="yearly" @checked($estate->duration =='سنوي')
                                                       name="duration" value="سنوي" class="custom-control-input"
                                                       >
                                                <label class="custom-control-label" for="yearly">سنوية</label>
                                            </div>
                                            <div class="custom-control custom-radio ">
                                                <input type="radio" id="not_yearly"  @checked($estate->duration =="فترة محددة")
                                                       name="duration" value="فترة محددة" class="custom-control-input"
                                                      >
                                                <label class="custom-control-label" for="not_yearly">قترة محددة</label>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="duration_start col-md-6 col-12 mb-3">
                                                <label for="duration_start"> من الشهر</label>
                                                    <input type="number" min="1" max="12" name="duration_start"
                                                           class="form-control" id="duration_start" placeholder=""
                                                           value="{{ $estate->duration_start}}" required>
                                                    @error('duration_start')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="duration_end col-md-6 col-12 mb-3">
                                                <label for="duration_end"> إلى الشهر</label>
                                                    <input type="number" min="1" max="12" name="duration_end"
                                                           class="form-control" id="duration_end" placeholder=""
                                                           value="{{ $estate->duration_end}}" required>
                                                    @error('duration_end')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="evaluation_date">تاريخ التقييم  </label>
                                            <div class="form-group">
                                                <select name="evaluation_date" id="evaluation_date"
                                                        class="select2 form-control">
                                                    <option value="ميلادي" @selected($estate->evalution_date == "ميلادي")>ميلادي</option>
                                                    <option value="هجري"  @selected($estate->evalution_date == "هجري")>هجري</option>
                                                </select>
                                            </div>
                                            @error('evaluation_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="age">عمر العقار بالسنوات</label>
                                            <input type="number" name="age"
                                                   class="form-control" id="age" placeholder=""
                                                   value="{{$estate->age}}">
                                            @error('age')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="about">نبذة (وصف العقار)</label>
                                            <textarea rows="10" type="text" name="about"
                                                      class="form-control" id="about" placeholder="عن العقار "
                                            >{{$estate->about}}</textarea>
                                        </div>


                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="size_kind">
                                                طريقة القياس
                                            </label>
                                            <div class="form-group">
                                                <select name="size_kind" id="size_kind"
                                                        class="select2 form-control">
                                                    <option {{$estate->size_kind == 1 ? 'selected' : ''}} value="1">
                                                        المتر المربع
                                                    </option>
                                                    <option {{$estate->size_kind == 2 ? 'selected' : ''}} value="2">
                                                        المتر المكعب
                                                    </option>
                                                </select>
                                            </div>
                                            @error('size_kind')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" {{ $estate->active == 1 ? 'checked' : '' }}
                                            name="active" value="1" class="custom-control-input"
                                                   id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">فعال</label>
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
                        required: false,
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
                        // required: 'هذا الحقل مطلوب',
                        minlength: 'هذا الحقل مطلوب اقل من المسموح',
                    },
                }
            });
        });
        if ($('#kind_id').val() != 1) {
            $('.member').show();
        } else {
            $('.member').hide();
        }
        $('#kind_id').change(function () {
            if ($('#kind_id').val() != 1) {
                $('.member').show();
            } else {
                $('.member').hide();
            }
        });
    </script>
    <script>
                {{ $estate->lat }}
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {
                    lat: {{ $estate->lat }},
                    lng: {{ $estate->lng }},
                },
                zoom: 15
            });
        var marker = new google.maps.Marker({
            position: {
                lat: {{ $estate->lat }},
                lng: {{ $estate->lng }},
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

