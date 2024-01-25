@extends('frontend.layout.master')
@section('frontend-head')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAbukNOXKPE1M-2Duze7aLXcRLguKXbJQ&libraries=places&sensor=false"></script>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <style>
        #map-canvas {
            width: 100%;
            height: 350px;
        }

        .fc-daygrid-block-event .fc-event-title {
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
            font-family: sans;
            color: white;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: #adb5bd;
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
        .not_previewing_reason,.previewing_way{display: none}
    </style>
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- Data list view starts -->
        <section id="data-thumb-view" class="data-thumb-view-header">
        @include('frontend.steps.estate_includes.estate_info')
        <!-- dataTable ends -->
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">سبب الرفض</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post"
                                  action="{{ route('level_refuse' , ['estate_id'=>$estate->id,'type'=>auth()->user()->membership_level,'subdomain'=>Route::current()->parameter('subdomain')]) }}">
                                @csrf
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="col-md-12 col-12 mb-3">
                                            <label>سبب الرفض</label>
                                            <textarea class="form-control" name="reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    الرفض
                </button>
                {{--<a class="btn btn-danger" href="{{ route('level_refuse' , ['estate_id'=>$estate->id,'type'=>auth()->user()->membership_level]) }}">الرفض</a>--}}
                <br>
                <div class="card-header">
                    <h4 class="card-title"> المدخلات </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{ route('level_inputs' , ['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" id="myform"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[0][key]" class="form-control"
                                                   placeholder="وصف العقار" value="وصف العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <textarea type="text" name="infos[0][value]" class="form-control"
                                                      placeholder="الوصف" required>{{ $estate->about ?: '' }}</textarea>
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
                                                   placeholder="نوع العقار" value="نوع العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <!--<input type="text" name="infos[1][value]" placeholder="اختر او اكتب"-->
                                            <!--       list="infos[1][value]" class="form-control" @if($estate->category) value="{{ $estate->category->name }}" @endif required>-->
                                            <select class="form-control" name="infos[1][value]" id="infos[1][value]" required>
                                                <!--@if($estate->kind)-->
                                                <!--<option selected value="{{$estate->kind->name}}">{{ $estate->kind->name }}</option>-->
                                                <!--@endif-->
                                                <option @if(isset($estate->category) && $estate->category->name == 'ارض')  selected @endif value="ارض">ارض</option>
                                                <option @if(isset($estate->category) && $estate->category->name == 'فيلا') selected  @endif value="فيلا">فيلا</option>
                                                <option @if(isset($estate->category) && $estate->category->name ==  'فيلا دوبكس') selected @endif value="فيلا دوبلكس">فيلا دوبلكس</option>
                                                <option @if(isset($estate->category) && $estate->category->name == 'شقة')  selected @endif value="شقة">شقة</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='عمارة')  selected @endif value="عمارة">عمارة</option>
                                                <option @if(isset($estate->category) && $estate->category->name == 'فيلا روف')  selected @endif value="فيلا روف">فيلا روف</option>
                                                <option @if(isset($estate->category) && $estate->category->name == 'مستودع')  selected @endif value="مستودع">مستودع</option>
                                                <option @if(isset($estate->category) && $estate->category->name == 'مصنع')  selected @endif value="مصنع">مصنع</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='مزرعة')  selected @endif value="مزرعة">مزرعة</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='بيت شعبي')  selected @endif value="بيت شعبي">بيت شعبي</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='معرض تجاري')  selected @endif value="معرض تجاري">معرض تجاري</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='مركز تجاري')  selected @endif value="مركز تجاري">مركز تجاري</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='فندق')  selected @endif value="فندق">فندق</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='مرفق حكومي')  selected @endif value="مرفق حكومي">مرفق حكومي</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='موقع تاريخي')  selected @endif value="موقع تاريخي">موقع تاريخي</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='مجمع سكني')  selected @endif value="مجمع سكني">مجمع سكني</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='مدرسة')  selected @endif value="مدرسة">مدرسة</option>
                                                <option @if(isset($estate->category) && $estate->category->name =='حوش')  selected @endif value="حوش">حوش</option>
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
                                            <input type="text" name="infos[2][key]" class="form-control"
                                                   placeholder="الاستخدام الحالي" value="الاستخدام الحالي" readonly>
                                        </div>
                                        <?php $use = App\Models\EstateInput::where('estate_id' , $estate->id)->where('key' , 'الاستخدام')->orderBy('id','desc' )->first();  ?>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[2][value]" value="{{ $use ? $use->value : '' }}" placeholder="اختر او اكتب"
                                                   list="infos[2][value]" class="form-control" required>
                                            <datalist id="infos[2][value]">
                                                <option value="سكني">سكني</option>
                                                <option value="تجاري">تجاري</option>
                                                <option value="سكني تجاري">سكني تجاري</option>
                                                <option value="صحة">صحة</option>
                                                <option value="اداري">اداري</option>
                                                <option value="مختلط">مختلط</option>
                                                <option value="زراعي">زراعي</option>
                                                <option value="تعليمي">تعليمي</option>
                                            </datalist>
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
                                                   placeholder="نظام البناء حسب التنظيم" value="نظام البناء حسب التنظيم"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[3][value]"
                                                   placeholder="نظام البناء حسب التنظيم" class="form-control" required>
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
                                                   placeholder="نسبة مساحة البناء المصرح بها"
                                                   value="نسبة مساحة البناء المصرح بها" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[4][value]"
                                                   placeholder="نسبة مساحة البناء المصرح بها" class="form-control"
                                                   required> %
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[5][key]" class="form-control"
                                                   placeholder="عدد الادوار المصرح بها" value="عدد الادوار المصرح بها"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[5][value]"
                                                   placeholder="عدد الادوار المصرح بها" class="form-control" required>
                                            دور
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[6][key]" class="form-control"
                                                   placeholder="موقع العقار من وسط المدينة"
                                                   value="موقع العقار من وسط المدينة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[6][value]" class="form-control" required>
                                                <option value="وسط المدينة">وسط المدينة</option>
                                                <option value="شمال المدينة">شمال المدينة</option>
                                                <option value="جنوب المدينة">جنوب المدينة</option>
                                                <option value="شرق المدينة">شرق المدينة</option>
                                                <option value="غرب المدينة">غرب المدينة</option>
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
                                            <input type="text" name="infos[7][key]" class="form-control"
                                                   placeholder="مستوى العقار عن الشارع" value="مستوى العقار عن الشارع"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[7][value]" class="form-control" required>
                                                <option value="نفس مستوى الشارع">نفس مستوى الشارع</option>
                                                <option value="منخفض عن الشارع">منخفض عن الشارع</option>
                                                <option value="مرتفع عن الشارع">مرتفع عن الشارع</option>
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
                                            <input type="text" name="infos[8][key]" class="form-control"
                                                   placeholder="البيئة الخارجية" value="البيئة الخارجية" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[8][value]" required class="form-control">
                                                <option value="يوجد مصادر تلوث او مشتبة فيها اثناء المعاينة ويرجى عمل معاينة اخري">
                                                    يوجد مصادر تلوث او مشتبة فيها اثناء المعاينة ويرجى عمل معاينة
                                                    اخري
                                                </option>
                                                <option value="لم يتم ايجاد مصدر تلوث او مشتبه فيها اثناء المعاينة ولا يوصى بإجراء عمليات تحقق اضافية">
                                                                لم يتم ايجاد مصدر تلوث او مشتبه فيها اثناء المعاينة ولا يوصى بإجراء عمليات تحقق اضافية
                                                </option>
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
                                            <input type="text" name="infos[9][key]" class="form-control"
                                                   placeholder=" بناء مجاور "
                                                   value="  بناء مجاور" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select class="selectpicker form-control" name="infos[9][value][]"  multiple data-live-search="true">
                                                <option value="جار شمالي">جار شمالي</option>
                                                <option value="جر جنوبي">جار جنوبي</option>
                                                <option value="جار شرقي">جار شرقي</option>
                                                <option value="جار غربي">جار غربي</option>
                                                <option value="لا يوجد ">لا يوجد </option>
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
                                            <input type="text" name="infos[10][key]" class="form-control"
                                                   placeholder="الشوارع المحيطة" value="الشوارع المحيطة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[10][value]" placeholder="اختر او اكتب"
                                                   list="infos[10][value]" class="form-control" required>
                                            <datalist id="infos[10][value]">
                                                <option value="مرصوفة">مرصوفة</option>
                                                <option value="مرصوفة جزئيا">مرصوفة جزئيا</option>
                                                <option value="غير مرصوفة">غير مرصوفة</option>
                                                <option value="ترابية">ترابية</option>
                                                <option value="تحت الانشاء">تحت الانشاء</option>
                                            </datalist>
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[11][key]" class="form-control"
                                                   placeholder="اضاءة الشوارع المحيطة" value="اضاءة الشوارع المحيطة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[11][value]" class="form-control" required>
                                                <option value="مضاءة">مضاءة</option>
                                                <option value="غير مضاءة">غير مضاءة</option>
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
                                            <input type="text" name="infos[12][key]" class="form-control"
                                                   placeholder="شاغرية العقار" value="شاغرية العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">

                                            <select multiple class="form-control selectpicker" name="infos[12][value][]">
                                                <option value="مأهول">مأهول</option>
                                                <option value="المالك">المالك</option>
                                                <option value="مستأجر">مستأجر</option>
                                                <option value="غير مأهول">غير مأهول</option>
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
                                            <input type="text" name="infos[94][key]" class="form-control"
                                                   placeholder=" نسبة الاشغال" value=" نسبة الاشغال" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[94][value]" class="form-control"
                                                   placeholder=" نسبة الاشغال  " value="0" >%
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[67][key]" class="form-control"
                                                   placeholder=" مميزات موقع العقار" value=" مميزات موقع العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">

                                            <select multiple class="form-control selectpicker" name="infos[67][value][]">
                                                <option value="بالقرب من الطرق الرئيسية">بالقرب من الطرق الرئيسية</option>
                                                <option value="سهولة الوصول للموقع">سهولة الوصول للموقع</option>
                                                <option value="سهولة الاستدلال على الموقع">سهولة الاستدلال على الموقع</option>
                                                <option value="شوارع نافذة للعقار">شوارع نافذة للعقار</option>
                                                <option value="توافر الخدمات والمرافق بالقرب من العقار">توافر الخدمات والمرافق بالقرب من العقار</option>
                                                <option value="بالقرب من مسجد">بالقرب من مسجد</option>
                                                <option value="بالقرب من حديقة">بالقرب من حديقة</option>
                                                <option value="مطل على مسجد">مطل على مسجد</option>
                                                <option value="مطل على حديقة">مطل على حديقة</option>
                                                <option value="شوارع عريضة حول العقار">شوارع عريضة حول العقار</option>
                                                <option value="توفر مواقف سيارات">توفر مواقف سيارات</option>
                                                <option value="شوارع مرصوفة في منطقة العقار">شوارع مرصوفة في منطقة العقار</option>
                                                <option value="شوارع مضاءة في منطقة العقار">شوارع مضاءة في منطقة العقار</option>
                                                <option value="ارض مستوية">ارض مستوية</option>
                                                <option value="اضلاع العقار متناسقة">اضلاع العقار متناسقة</option>
                                                <option value="ارضية صلبه">ارضية صلبه</option>
                                                <option value="خالية من الدمار او الحفر">خالية من الدمار او الحفر</option>
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
                                            <input type="text" name="infos[68][key]" class="form-control"
                                                   placeholder=" مميزات موقع العقار" value=" سلبيات موقع العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">

                                            <select multiple class="form-control selectpicker" name="infos[68][value][]">
                                                <option value="سهولة صعوبة للموقع">صعوبة الوصول للموقع</option>
                                                <option value="سهولة صعوبة على الموقع">صعوبة الاستدلال على الموقع</option>
                                                <option value="شوارع غير مرصوفة">شوارع غير مرصوفة</option>
                                                <option value="شوارع ضيقة حول للعقار">شوارع ضيقة حول للعقار</option>
                                                <option value="عدم توافر الخدمات والمرافق بالقرب من العقار">عدم توافر الخدمات والمرافق بالقرب من العقار</option>
                                                <option value=" مواقف سيارات غير كافية"> مواقف سيارات غير كافية</option>
                                                <option value="لا تتوافر اضاءة في منطقة العقار "> لا تتوافر اضاءة في منطقة العقار </option>
                                                <option value="العقار بالقرب من مصادر تلوث او ازعاج "> العقار بالقرب من مصادر تلوث او ازعاج </option>
                                                <option value=" اضلاع العقار غير متناسقة"> اضلاع العقار غير متناسقة </option>
                                                <option value="وجود دمار او حفر  "> وجود دمار او حفر  </option>
                                                <option value=" ارض سبخة مائية"> ارض سبخة مائية </option>
                                                <option value=" ارض دفان مخلفات">  ارض دفان مخلفات</option>
                                                <option value="ارض غير مستوية او جبلية "> ارض غير مستوية او جبلية </option>

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
                                            <input type="text" name="infos[13][key]" class="form-control"
                                                   placeholder="سهولة الوصول والاستدلال على الموقع"
                                                   value="سهولة الوصول والاستدلال على الموقع" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[13][value][]"  multiple class="form-control selectpicker" required>
                                                <option value="سهل الوصول">سهل الوصول</option>
                                                <option value="سهل الاستدلال">سهل الاستدلال</option>

                                                <option value="صعب الوصول">صعب الوصول</option>
                                                <option value="صعب الاستدلال">صعب الاستدلال</option>
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
                                            <input type="text" name="infos[14][key]" class="form-control"
                                                   placeholder="كثافة سكانية في المنطقة المحيطة"
                                                   value="كثافة سكانية في المنطقة المحيطة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[14][value]" class="form-control" required>
                                                <option value="منخفضة">منخفضة</option>
                                                <option value="متوسطة">متوسطة</option>
                                                <option value="مرتفعة">مرتفعة</option>
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
                                            <input type="text" name="infos[15][key]" class="form-control"
                                                   placeholder="نسبة العقارات المبنية بالمنطقة"
                                                   value="نسبة العقارات المبنية بالمنطقة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[15][value]" class="form-control" required>
                                                <option value="اقل من 25 %">اقل من 25 %</option>
                                                <option value="20 % - 50 %">20 % - 50 %</option>
                                                <option value="50 % - 70 %">50 % - 70 %</option>
                                                <option value="اكثر من 70 %">اكثر من 70 %</option>
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
                                            <input type="text" name="infos[16][key]" class="form-control"
                                                   placeholder="نسبة اشغار العقارات بالمنطقة"
                                                   value="نسبة اشغار العقارات بالمنطقة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[16][value]" class="form-control" required>
                                                <option value="اقل من 25 %">اقل من 25 %</option>
                                                <option value="20 % - 50 %">20 % - 50 %</option>
                                                <option value="50 % - 70 %">50 % - 70 %</option>
                                                <option value="اكثر من 70 %">اكثر من 70 %</option>
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
                                            <input type="text" name="infos[17][key]" class="form-control"
                                                   placeholder="توفر الخدمات العامة في منطقة العقار"
                                                   value="توفر الخدمات العامة في منطقة العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[17][value]" class="form-control" required>
                                                <option value="يقع العقار بالقرب من بعض الخدمات العامة والمرافق">يقع
                                                    العقار بالقرب من بعض الخدمات العامة والمرافق
                                                </option>
                                                <option value="لا يوجد خدمات عامة او مرافق">لا يوجد خدمات عامة او
                                                    مرافق
                                                </option>
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
                                            <input type="text" name="infos[18][key]" class="form-control"
                                                   placeholder="الخدمات والمرافق العامة المتوفرة في منطقة العقار"
                                                   value="الخدمات والمرافق العامة المتوفرة في منطقة العقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                             <select name="infos[18][value][]"  multiple class="form-control selectpicker" required>
                                                <option value="مدرسة">مدرسة</option>
                                                <option value="مطار">مطار</option>
                                                <option value="مجمع تجاري">مجمع تجاري</option>
                                                <option value=" مسجد">مسجد </option>
                                                <option value=" محطة">محطة </option>
                                                <option value=" بنك">بنك </option>
                                                <option value=" مستشفى">مستشفى </option>
                                                <option value=" مركز صحي">مركز صحي </option>
                                                <option value="دفاع مدني">دفاع مدني</option>
                                                <option value="بريد">بريد</option>
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
                                            <input type="text" name="infos[19][key]" class="form-control"
                                                   placeholder="موقع لعقار" value="موقع لعقار" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[19][value]" class="form-control" required>
                                                <option value="داخل النطاق العمراني">داخل النطاق العمراني</option>
                                                <option value="خارج النطاق العمراني">خارج النطاق العمراني</option>
                                            </select>
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="previewed_in_real" class="mb-1"> هل تم معاينة العقار على الطبيعة  </label>
                                        <div class="custom-control custom-radio ">
                                            <input type="radio" id="previewed_in_real_yes"
                                                   name="previewed_in_real" value="yes" class="custom-control-input"
                                                   >
                                            <label class="custom-control-label" for="previewed_in_real_yes">نعم</label>
                                        </div>
                                        <div class="custom-control custom-radio ">
                                            <input type="radio" id="previewed_in_real_no"
                                                   name="previewed_in_real" value="no" class="custom-control-input"
                                                  >
                                            <label class="custom-control-label" for="previewed_in_real_no">لا</label>
                                        </div>
                                    </div>
                                    <div class="previewing_way col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-6 mb-3">
                                                <input type="text" name="infos[19][key]" class="form-control"
                                                       placeholder="طريقة المعاينة" value="طريقة المعاينة" readonly>
                                            </div>
                                            <div class="col-md-6 col-6 mb-3">
                                                <select name="infos[19][value][]" multiple class="form-control selectpicker" required>
                                                    <option value="معاينة داخلية">معاينة داخلية</option>
                                                    <option value="معاينة خارجية">معاينة خارجية</option>
                                                </select>
                                            </div>
                                        </div>

                                </div>
                                <div class="not_previewing_reason col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[19][key]" class="form-control"
                                                   placeholder="السبب لعدم المعاينة" value="السبب لعدم المعاينة" readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input name="infos[19][value][]" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    @error('product_price_list')
                                    <div class="alert" style="color:#a94442">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($estate->kind_id == 1)
                                    <div class="land">
                                        <h3>
                                            وصف الارض
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[20][key]" class="form-control"
                                                               placeholder="اضلاع متناسقة" value="اضلاع متناسقة"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[20][value]" class="form-control" required>
                                                            <option value="اضلاع متناسقة ">اضلاع متناسقة</option>
                                                            <option value="اضلاع غير متناسقة">اضلاع غير متناسقة</option>
                                                            <option value="اضلاع شبة متناسقة">اضلاع شبة متناسقة</option>
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
                                                        <input type="text" name="infos[21][key]" class="form-control"
                                                               placeholder="وجود بتر خرسانية" value="وجود بتر خرسانية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[21][value]" class="form-control" required>
                                                            <option value="نعم ">نعم</option>
                                                            <option value="لا">لا</option>
                                                            <option value="البعض فقط">البعض فقط</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                @endif

                                @if($estate->kind_id == 2)
                                    <div class="build">
                                        <h3>
                                            معلومات العقار الخارجية
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[70][key]" class="form-control"
                                                               placeholder="نوع المبنى" value="نوع المبنى" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[70][value]" class="form-control" required>
                                                            <option value="مبنى مستقل ">مبنى مستقل</option>
                                                            <option value="جزء من مبنى">جزء من مبنى</option>
                                                            <option value="مشروع متعدد المباني">مشروع متعدد المباني
                                                            </option>
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
                                                        <input type="text" name="infos[72][key]" class="form-control"
                                                               placeholder="حالة المبنى" value="حالة المبنى" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[72][value]" class="form-control" required>
                                                            <option value="تحت الانشاء ">تحت الانشاء</option>
                                                            <option value="مكتمل الانشاء">مكتمل الانشاء</option>
                                                            <option value="اساسات فقط">اساسات فقط</option>
                                                            <option value="عضم ومباني">عضم ومباني</option>
                                                            <option value="تحت التشطيب">تحت التشطيب</option>
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
                                                        <input type="text" name="infos[22][key]" class="form-control"
                                                               placeholder="حالة التشطيب" value="حالة التشطيب" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[22][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="بدون تشطيب">بدون تشطيب</option>
                                                            <option value="تشطيب خارجي فقط">تشطيب خارجي فقط</option>
                                                            <option value="تشطيب داخلي">تشطيب داخلي</option>
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
                                                        <input type="text" name="infos[23][key]" class="form-control"
                                                               placeholder="مستوى التشطيب الداخلي" value="مستوى التشطيب الداخلي"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[23][value]" class="form-control" required>
                                                            <option value="عادي">عادي</option>
                                                            <option value="متوسط">متوسط</option>
                                                            <option value="فاخر">فاخر</option>
                                                            <option value="سيئ">سيئ</option>
                                                            <option value="بدون">بدون</option>

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
                                                        <input type="text" name="infos[24][key]" class="form-control"
                                                               placeholder="عمر العقار" value="عمر العقار"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="number" name="infos[24][value]"
                                                               placeholder="عمر العقار بالسنوات" class="form-control"
                                                               required> سنة
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[25][key]" class="form-control"
                                                               placeholder="عمر العقار المتبقي "
                                                               value="عمر العقار  المتبقي"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="number" name="infos[25][value]"
                                                               placeholder="عمر العقار المتبقي بالسنوات"
                                                               class="form-control" required> سنة
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[26][key]" class="form-control"
                                                               placeholder="عمر العقار الافتراضي "
                                                               value="عمر العقار  الافتراضي"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="number" name="infos[26][value]"
                                                               placeholder="عمر العقار الافتراضي بالسنوات"
                                                               class="form-control" required> سنة
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[27][key]" class="form-control"
                                                               placeholder="نسبة اكتمال البناء "
                                                               value="نسبة اكتمال البناء"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="number" name="infos[27][value]"
                                                               placeholder="نسبة اكتمال البناء نسبة مئوية"
                                                               class="form-control" required> %
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[28][key]" class="form-control"
                                                               placeholder="حالة العقار" value="حالة العقار" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[28][value]" class="form-control" required>
                                                            <option value="جيد">جيد</option>
                                                            <option value="متوسط">متوسط</option>
                                                            <option value="ردئ">ردئ</option>

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
                                                        <input type="text" name="infos[29][key]" class="form-control"
                                                               placeholder="التصميم المعماري" value="التصميم المعماري"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[29][value]" class="form-control" required>
                                                            <option value="ممتاز">ممتاز</option>
                                                            <option value="جيد">جيد</option>
                                                            <option value="متوسط">متوسط</option>
                                                            <option value="ردئ">ردئ</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!--<div class="col-md-12">-->
                                            <!--    <div class="row">-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <input type="text" name="infos[30][key]" class="form-control"-->
                                            <!--                   placeholder="الخدمات والمرافق  المتوفرة في منطقة العقار"-->
                                            <!--                   value="الخدمات والمرافقة المتوفرة في منطقة العقار" readonly>-->
                                            <!--        </div>-->
                                            <!--       <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <select name="infos[30][value][]" multiple class="form-control selectpicker" required>-->
                                            <!--                <option value="مدرسة ">مدرسة </option>-->
                                            <!--                <option value="مطار ">مطار </option>-->
                                            <!--                <option value="مسجد ">مسجد </option>-->
                                            <!--                <option value="محطة ">محطة </option>-->
                                            <!--                <option value="بنك ">بنك </option>-->
                                            <!--                <option value="مستشفى ">مستشفى </option>-->
                                            <!--                <option value="شرطة ">شرطة </option>-->
                                            <!--                <option value="مركز صحي ">مركز صحي </option>-->
                                            <!--                <option value="بريد ">بريد </option>-->
                                            <!--                <option value="مجمع تجاري ">مجمع تجاري </option>-->
                                            <!--                <option value="دفاع مدني ">دفاع مدني </option>-->

                                            <!--            </select>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    @error('product_price_list')-->
                                            <!--    <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                                            <!--    @enderror-->
                                            <!--</div>-->
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[69][key]" class="form-control"
                                                               placeholder="الخدمات   المتوفرة في العقار"
                                                               value="الخدمات المتوفرة في العقار" readonly>
                                                    </div>
                                                   <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[69][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="كهرباء ">كهرباء </option>
                                                            <option value="تم اطلاق التيار الكهربائي ">تم اطلاق التيار الكهربائي </option>
                                                            <option value="ماء ">ماء </option>
                                                            <option value="هاتف ">هاتف </option>
                                                            <option value="صرف صحي ">صرف صحي </option>
                                                            <option value="تغطية جوال ">تغطية جوال </option>
                                                            <option value="الياف بصرية ">الياف بصرية </option>
                                                            <option value="شبكة انترنت DSL ">شبكة انترنت DSL </option>

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
                                                        <input type="text" name="infos[31][key]" class="form-control"
                                                               placeholder="نوع التكييف" value="نوع التكييف"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[31][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="تكييف مركزي">تكييف مركزي</option>
                                                            <option value="وحدات شباك">وحدات شباك</option>
                                                            <option value="وحدات منفصلة">وحدات منفصلة</option>
                                                            <option value="تكييف صحراوي">تكييف صحراوي</option>
                                                            <option value="غير مكيف">غير مكيف</option>
                                                            <option value="يوجد توصيلات فقط">يوجد توصيلات فقط</option>

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
                                                        <input type="text" name="infos[32][key]" class="form-control"
                                                               placeholder="نوع واجهة المبنى الشمالية"
                                                               value="نوع واجهة المبنى الشمالية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[32][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="دهان">دهان</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="حجر">حجر</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="كلادنج">كلادنج</option>
                                                            <option value="بروفايل">بروفايل</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="كسر رخام">كسر رخام</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[63][key]" class="form-control"
                                                               placeholder="نوع واجهة المبنى الجنوبية"
                                                               value="نوع واجهة المبنى الجنوبية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[63][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="دهان">دهان</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="حجر">حجر</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="كلادنج">كلادنج</option>
                                                            <option value="بروفايل">بروفايل</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="كسر رخام">كسر رخام</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[62][key]" multiple class="form-control"
                                                               placeholder="نوع واجهة المبنى الشرقية"
                                                               value="نوع واجهة المبنى الشرقية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[62][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="دهان">دهان</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="حجر">حجر</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="كلادنج">كلادنج</option>
                                                            <option value="بروفايل">بروفايل</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="كسر رخام">كسر رخام</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[33][key]" class="form-control"
                                                               placeholder="نوع واجهة المبنى الغربية"
                                                               value="نوع واجهة المبنى الغربية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[33][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="دهان">دهان</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="حجر">حجر</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="كلادنج">كلادنج</option>
                                                            <option value="بروفايل">بروفايل</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="كسر رخام">كسر رخام</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[34][key]" class="form-control"
                                                               placeholder="نوع الابواب الخارجية"
                                                               value="نوع الابواب الخارجية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[34][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="خشب">خشب</option>
                                                            <option value="حديد">حديد</option>
                                                            <option value="الومنيوم">الومنيوم</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[35][key]" class="form-control"
                                                               placeholder="ارضيات الفناء الخارجي"
                                                               value="ارضيات الفناء الخارجي" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[35][value][]" multiple class="form-control selectpicker">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="بورسلان">بورسلان</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[36][key]" class="form-control"
                                                               placeholder="نوع ارضيات المدخل" value="نوع ارضيات المدخل"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[36][value][]" multiple class="form-control selectpicker">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="بورسلان">بورسلان</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[37][key]" class="form-control"
                                                               placeholder="نوع ارضيات الملحق الخارجي"
                                                               value="نوع ارضيات الملحق الخارجي" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select multiple class="form-control selectpicker" name="infos[37][value][]">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="بورسلان">بورسلان</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[38][key]" class="form-control"
                                                               placeholder="نوع ارضيات غرفة السائق / الحارس"
                                                               value="نوع ارضيات غرفة السائق / الحارس" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select multiple class="form-control selectpicker" name="infos[38][value][]">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="بورسلان">بورسلان</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="لياسة">لياسة</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[39][key]" class="form-control"
                                                               placeholder="حالة الجدران الخارجية"
                                                               value="حالة الجدران الخارجية" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select multiple class="form-control selectpicker" name="infos[39][value][]">
                                                            <option value="لا يوجد ملاحظات ">لا يوجد ملاحظات</option>
                                                            <option value="رطوبة بسيطة">رطوبة بسيطة</option>
                                                            <option value="رطوبة منتشرة">رطوبة منتشرة</option>
                                                            <option value="تشققات بسيطة">تشققات بسيطة</option>
                                                            <option value="تشققات عميقة">تشققات عميقة</option>
                                                            <option value="لياسة متساقطة">لياسة متساقطة</option>
                                                            <option value="رخام متساقط">رخام متساقط</option>
                                                            <option value="دهان متقشر بسيط">دهان متقشر بسيط</option>
                                                            <option value="دهان متقشر منتشر">دهان متقشر منتشر</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[40][key]" class="form-control"
                                                               placeholder="حالة الارضيات الخارجية"
                                                               value="حالة الارضيات الخارجية" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[40][value][]" multiple class="form-control selectpicker">
                                                            <option value="لا يوجد ملاحظات ">لا يوجد ملاحظات</option>
                                                            <option value="تكسير بسيط في الارضيات">تكسير بسيط في
                                                                الارضيات
                                                            </option>
                                                            <option value="تكسير كبير في الارضيات">تكسير كبير في
                                                                الارضيات
                                                            </option>
                                                            <option value="هبوط في الارضيات">هبوط في الارضيات</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[41][key]" class="form-control"
                                                               placeholder="مميزات اضافية" value="مميزات اضافية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                         <select name="infos[41][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="مسابح ">مسابح </option>
                                                            <option value="مواقف سيارات ">مواقف سيارات </option>
                                                            <option value="نادي رياضي ">نادي رياضي </option>
                                                            <option value="انظمة صوتية ">انظمة صوتية </option>
                                                            <option value="انذار واطفاء حرائق ">انذار واطفاء حرائق </option>
                                                            <option value="شبكة مراقبة تلفزيونية ">شبكة مراقبة تلفزيونية </option>

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
                                                        <input type="text" name="infos[42][key]" class="form-control"
                                                               placeholder="هل الارض تحت المبنى مستأجرة"
                                                               value="هل الارض تحت المبنى مستأجرة"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[42][value]" class="form-control" required>
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
                                                <hr>
                                                <h3>
                                                    الاعمال الانشائية
                                                </h3>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[43][key]" class="form-control"
                                                               placeholder="الهيكل الانشائي" value="الهيكل الانشائي"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[43][value][]" multiple class="form-control selectpicker">
                                                            <option value="خرساني">خرساني</option>
                                                            <option value="مباني معدنية">مباني معدنية</option>
                                                            <option value="مباني خشبية">مباني خشبية</option>
                                                            <option value="حوائط حاملة">حوائط حاملة</option>
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
                                                        <input type="text" name="infos[44][key]" class="form-control "
                                                               placeholder="نوع الاسقف" value="نوع الاسقف" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[44][value][]" multiple class="form-control selectpicker">
                                                            <option value="خرسانة مسلحة">خرساني</option>
                                                            <option value="كمرات حديد">كمرات حديد</option>
                                                            <option value="كمرات خشبية">كمرات خشبية</option>
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
                                                        <input type="text" name="infos[45][key]" class="form-control"
                                                               placeholder="نوع العازل" value="نوع العازل" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[45][value][]" multiple class="form-control selectpicker">
                                                            <option value="عازل صوت">عازل صوت</option>
                                                            <option value="عازل حراري">عازل حراري</option>
                                                            <option value="عازل ماء">عازل ماء</option>
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
                                                        <input type="text" name="infos[65][key]" class="form-control"
                                                               placeholder=" ملاحظات الاعمال الانشائية" value="ملاحظات الاعمال الانشائية "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[65][value]" class="form-control"
                                                               placeholder=" ملاحظات الاعمال الانشائية" value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                                <h3>
                                                    معلومات العقار الداخلية
                                                </h3>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[45][key]" class="form-control "
                                                               placeholder="نوع الابواب الداخلية"
                                                               value="نوع الابواب الداخلية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[45][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="خشب">خشب</option>
                                                            <option value="حديد">حديد</option>
                                                            <option value="الومنيوم">الومنيوم</option>
                                                            <option value="زجاج">زجاج</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[46][key]" class="form-control selectpicker"
                                                               placeholder="نوع ارضيات المباني"
                                                               value="نوع ارضيات المباني" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[46][value][]" multiple class="form-control selectpicker">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="بورسلان">بورسلان</option>
                                                            <option value="سيراميك">سيراميك</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[47][key]" class="form-control selectpicker"
                                                               placeholder="نوع الدرج الداخلي" value="نوع الدرج الداخلي"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[47][value][]" multiple class="form-control selectpicker">
                                                            <option value="بلاط ">بلاط</option>
                                                            <option value="رخام">رخام</option>
                                                            <option value="جرانيت">جرانيت</option>
                                                            <option value="خشب">خشب</option>
                                                            <option value="معدن">معدن</option>
                                                            <option value="لياسه">لياسه</option>
                                                            <option value="لا يوجد">لا يوجد</option>
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
                                                        <input type="text" name="infos[48][key]" class="form-control"
                                                               placeholder="محتويات المبنى" value="محتويات المبنى"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">

                                                        <select name="infos[48][value][]" multiple class="form-control selectpicker">
                                                            <option value="كراج كهربي ">كراج كهربي</option>
                                                            <option value="نظام مراقبة امني">نظام مراقبة امني</option>
                                                            <option value="ساتر نوافذ">ساتر نوافذ</option>
                                                            <option value="غاز مركزي">غاز مركزي</option>
                                                            <option value="زجاج مزدوج">زجاج مزدوج</option>
                                                            <option value="حوائط حاملة">حوائط حاملة</option>
                                                            <option value="خزان تحت الارض "> خزان تحت الارض</option>
                                                            <option value=" نظام مكافحة حريق">نظام مكافحة حريق </option>
                                                            <option value=" مصعد"> مصعد</option>
                                                            <option value=" سلم طوارئ"> سلم طوارئ</option>
                                                            <option value=" مخارج طوارئ"> مخارج طوارئ</option>
                                                            <option value=" درج كهربائي"> درج كهربائي</option>
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
                                                        <input type="text" name="infos[49][key]" class="form-control"
                                                               placeholder="حالة الجدران الداخلية"
                                                               value="حالة الجدران الداخلية" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                         <select name="infos[49][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="لا يوجد ملاحظات ">لا يوجد ملاحظات</option>
                                                            <option value="رطوبة بسيطة">رطوبة بسيطة</option>
                                                            <option value="رطوبة منتشرة">رطوبة منتشرة</option>
                                                            <option value="تشققات بسيطة">تشققات بسيطة</option>
                                                            <option value="تشققات عميقة">تشققات عميقة</option>
                                                            <option value="لياسة متساقطة">لياسة متساقطة</option>
                                                            <option value="رخام متساقط">رخام متساقط</option>
                                                            <option value="دهان متقشر بسيط">دهان متقشر بسيط</option>
                                                            <option value="دهان متقشر منتشر">دهان متقشر منتشر</option>
                                                            <option value="عضم (بلوك)">عضم (بلوك)</option>
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
                                                        <input type="text" name="infos[50][key]" class="form-control"
                                                               placeholder="حالة الارضيات الداخلية"
                                                               value="حالة الارضيات الداخلية" readonly>
                                                    </div>
                                                     <div class="col-md-6 col-6 mb-3">
                                                         <select name="infos[50][value][]" multiple class="form-control selectpicker" required>
                                                            <option value="لا يوجد ملاحظات ">لا يوجد ملاحظات</option>
                                                            <option value="تكسير بسيط في الارضيات">تكسير بسيط في
                                                                الارضيات
                                                            </option>
                                                            <option value="تكسير كبير في الارضيات">تكسير كبير في
                                                                الارضيات
                                                            </option>
                                                            <option value="هبوط في الارضيات">هبوط في الارضيات</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[51][key]" class="form-control"
                                                               placeholder="حالة الاسقف الداخلية"
                                                               value="حالة الاسقف الداخلية" readonly>
                                                    </div>
                                                     <div class="col-md-6 col-6 mb-3">
                                                         <select name="infos[51][value][]" multiple class="form-control selectpicker" required>
                                                           <option value="لا يوجد ملاحظات ">لا يوجد ملاحظات</option>
                                                            <option value="رطوبة بسيطة">رطوبة بسيطة</option>
                                                            <option value="رطوبة منتشرة">رطوبة منتشرة</option>
                                                            <option value="تشققات بسيطة">تشققات بسيطة</option>
                                                            <option value="تشققات عميقة">تشققات عميقة</option>
                                                            <option value="لياسة متساقطة">لياسة متساقطة</option>
                                                            <option value="جبس متساقط">جبس متساقط</option>
                                                            <option value="دهان متقشر بسيط">دهان متقشر بسيط</option>
                                                            <option value="دهان متقشر منتشر">دهان متقشر منتشر</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[52][key]" class="form-control"
                                                               placeholder="مستوى التشطيب العام"
                                                               value="مستوى التشطيب العام" readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                         <select name="infos[52][value]"  class="form-control selectpicker" required>
                                                           <option value="ردئ">ردئ</option>
                                                           <option value="جيد">جيد</option>
                                                           <option value="لا ينطبق">لا ينطبق</option>
                                                           <option value="فاخر">فاخر</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                                <h3>
                                                    الحالة الانشائية
                                                </h3>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[53][key]" class="form-control"
                                                               placeholder="الاساسات \ الانشاءات"
                                                               value="الاساسات \ الانشاءات"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[53][value]" class="form-control" required>
                                                            <option value="بحالة جيدة">بحالة جيدة</option>
                                                            <option value="تشققات سطحية">تشققات سطحية</option>
                                                            <option value="اضرار جسيمة">اضرار جسيمة</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[54][key]" class="form-control"
                                                               placeholder="الاعمدة \ الجدران الحاملة"
                                                               value="الاعمدة \ الجدران الحاملة"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[54][value]" class="form-control" required>
                                                            <option value="بحالة جيدة">بحالة جيدة</option>
                                                            <option value="تشققات سطحية">تشققات سطحية</option>
                                                            <option value="اضرار جسيمة">اضرار جسيمة</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[55][key]" class="form-control"
                                                               placeholder="الاسقف الخرسانية" value="الاسقف الخرسانية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[55][value]" class="form-control" required>
                                                            <option value="بحالة جيدة">بحالة جيدة</option>
                                                            <option value="تشققات سطحية">تشققات سطحية</option>
                                                            <option value="اضرار جسيمة">اضرار جسيمة</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[56][key]" class="form-control"
                                                               placeholder="نتيجة فحص الاساسات \ الانشاءات"
                                                               value="نتيجة فحص الاساسات \ الانشاءات"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[56][value]" class="form-control" required>
                                                            <option value="قابل للاصلاح">قابل للاصلاح</option>
                                                            <option value="غير قابل للاصلاح">غير قابل للاصلاح</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[57][key]" class="form-control"
                                                               placeholder="نتيجة فحص الاعمدة \ الجدران الحاملة"
                                                               value="نتيجة فحص الاعمدة \ الجدران الحاملة"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[57][value]" class="form-control" required>
                                                            <option value="قابل للاصلاح">قابل للاصلاح</option>
                                                            <option value="غير قابل للاصلاح">غير قابل للاصلاح</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
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
                                                        <input type="text" name="infos[64][key]" class="form-control"
                                                               placeholder="نتيجة فحص الاسقف الخرسانية"
                                                               value="نتيجة فحص الاسقف الخرسانية"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <select name="infos[64][value]" class="form-control" required>
                                                            <option value="قابل للاصلاح">قابل للاصلاح</option>
                                                            <option value="غير قابل للاصلاح">غير قابل للاصلاح</option>
                                                            <option value="لا ينطبق">لا ينطبق</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                @endif
                                 @if($estate->category_id == 2 ||$estate->category_id == 1 )
                                <div class="col-md-12">
                                    <hr>
                                    <h3>
                                        تفاصيل المبنى
                                    </h3>
                                </div>
                                @endif
                                @if($estate->category_id == 2)

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[75][key]" class="form-control"
                                                   placeholder="غرف نوم" value="غرف نوم"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[75][value]" class="form-control"
                                                   placeholder="غرف نوم" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[76][key]" class="form-control"
                                                   placeholder=" صالة" value="صالة "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[76][value]" class="form-control"
                                                   placeholder=" صالة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[77][key]" class="form-control"
                                                   placeholder=" مجلس" value="مجلس "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[77][value]" class="form-control"
                                                   placeholder=" مجلس" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[77][key]" class="form-control"
                                                   placeholder=" غرفة طعام" value="غرفة طعام "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[77][value]" class="form-control"
                                                   placeholder=" غرفة طعام" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[89][key]" class="form-control"
                                                   placeholder=" غرفة غسيل" value="غرفة غسيل "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[89][value]" class="form-control"
                                                   placeholder=" غرفة غسيل" value="" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[78][key]" class="form-control"
                                                   placeholder="مطبخ" value="مطبخ"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[78][value]" class="form-control"
                                                   placeholder=" مطبخ" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[78][key]" class="form-control"
                                                   placeholder="غرفة خادمة" value="غرفة خادمة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[78][value]" class="form-control"
                                                   placeholder=" غرفة خادمة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[79][key]" class="form-control"
                                                   placeholder="مستودع" value="مستودع"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[79][value]" class="form-control"
                                                   placeholder="  مستودع" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[80][key]" class="form-control"
                                                   placeholder="دورات مياة" value="دورات مياة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[80][value]" class="form-control"
                                                   placeholder="  دورات مياة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[81][key]" class="form-control"
                                                   placeholder="شرفة" value="شرفة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[81][value]" class="form-control"
                                                   placeholder="شرفة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[82][key]" class="form-control"
                                                   placeholder="سطح" value="سطح"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[82][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[83][key]" class="form-control"
                                                   placeholder="درج " value="درج "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[83][value]" class="form-control" required>
                                                <option value="داخلي">داخلي</option>
                                                <option value=" جانبي "> جانبي </option>
                                                <option value=" لا "> لا يوجد </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[84][key]" class="form-control"
                                                   placeholder="غرفة سائق" value="غرفة سائق"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[84][value]" class="form-control"
                                                   placeholder="غرفة سائق" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[90][key]" class="form-control"
                                                   placeholder="مسبح" value="مسبح"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[90][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[85][key]" class="form-control"
                                                   placeholder="غرف اخرى" value="غرف اخرى"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[85][value]" class="form-control"
                                                   placeholder="غرف اخرى" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[86][key]" class="form-control"
                                                   placeholder=" عدد ادوار المبنى " value=" عدد ادوار المبنى "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[86][value]" class="form-control"
                                                   placeholder=" عدد ادوار المبنى " value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[87][key]" class="form-control"
                                                   placeholder=" عدد ادوار البدروم " value="  عدد ادوار البدروم  "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[87][value]" class="form-control"
                                                   placeholder=" عدد ادوار البدروم   " value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[88][key]" class="form-control"
                                                   placeholder="  ملحق علوى" value="ملحق علوى  "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[88][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[91][key]" class="form-control"
                                                   placeholder="  ملحق ارضي" value="ملحق ارضي  "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[91][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[92][key]" class="form-control"
                                                   placeholder="مواقف سيارة خاصة" value="مواقف سيارة خاصة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[92][value]" class="form-control"
                                                   placeholder="مواقف سيارة خاصة" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[93][key]" class="form-control"
                                                   placeholder="حديقة خاصة" value="حديقة خاصة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[93][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                @endif
                                @if($estate->category_id == 1)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[75][key]" class="form-control"
                                                   placeholder="غرف نوم" value="غرف نوم"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[75][value]" class="form-control"
                                                   placeholder="غرف نوم" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[76][key]" class="form-control"
                                                   placeholder=" صالة" value="صالة "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[76][value]" class="form-control"
                                                   placeholder=" صالة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[77][key]" class="form-control"
                                                   placeholder=" مجلس" value="مجلس "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[77][value]" class="form-control"
                                                   placeholder=" مجلس" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[77][key]" class="form-control"
                                                   placeholder=" غرفة طعام" value="غرفة طعام "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[77][value]" class="form-control"
                                                   placeholder=" غرفة طعام" value="" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[78][key]" class="form-control"
                                                   placeholder="مطبخ" value="مطبخ"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[78][value]" class="form-control"
                                                   placeholder=" مطبخ" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[78][key]" class="form-control"
                                                   placeholder="غرفة خادمة" value="غرفة خادمة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[78][value]" class="form-control"
                                                   placeholder=" غرفة خادمة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[79][key]" class="form-control"
                                                   placeholder="مستودع" value="مستودع"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[79][value]" class="form-control"
                                                   placeholder="  مستودع" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[80][key]" class="form-control"
                                                   placeholder="دورات مياة" value="دورات مياة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[80][value]" class="form-control"
                                                   placeholder="  دورات مياة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[81][key]" class="form-control"
                                                   placeholder="شرفة" value="شرفة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[81][value]" class="form-control"
                                                   placeholder="شرفة" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[82][key]" class="form-control"
                                                   placeholder="سطح" value="سطح"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[82][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[83][key]" class="form-control"
                                                   placeholder="درج داخلي" value="درج داخلي"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[83][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[84][key]" class="form-control"
                                                   placeholder="غرفة سائق" value="غرفة سائق"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[84][value]" class="form-control"
                                                   placeholder="غرفة سائق" value="" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[85][key]" class="form-control"
                                                   placeholder="غرف اخرى" value="غرف اخرى"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[85][value]" class="form-control"
                                                   placeholder="غرف اخرى" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[86][key]" class="form-control"
                                                   placeholder=" رقم الطابق" value=" رقم الطابق"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[86][value]" class="form-control"
                                                   placeholder=" رقم الطابق" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[87][key]" class="form-control"
                                                   placeholder="اجمالي عدد ادوار المبنى الرئيسي" value="اجمالي عدد ادوار المبنى الرئيسي"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="number" name="infos[87][value]" class="form-control"
                                                   placeholder="اجمالي عدد ادوار المبنى الرئيسي" value="" required>
                                        </div>
                                    </div>

                                </div>
                                 <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[88][key]" class="form-control"
                                                   placeholder="موقف خاص " value="موقف خاص "
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[88][value]" class="form-control" required>
                                                <option value="نعم">نعم</option>
                                                <option value=" لا "> لا </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                @endif

                                 <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <h3>
                                        مطابقة مستندات العقار
                                    </h3>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-6 mb-3">
                                            <input type="text" name="infos[58][key]" class="form-control"
                                                   placeholder="الصك مطابق للموقع" value="الصك مطابق للموقع"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[58][value]" class="form-control" required>
                                                <option value="مطابق">مطابق</option>
                                                <option value=" غير مطابق"> غير مطابق</option>
                                                <option value=" مستند غير متوفر">  مستند غير متوفر</option>
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
                                            <input type="text" name="infos[59][key]" class="form-control"
                                                   placeholder="رخصة البناء مطابقة للطبيعة" value="رخصة البناء مطابقة للطبيعة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[59][value]" class="form-control" required>
                                                <option value="مطابق">مطابق</option>
                                                <option value=" غير مطابق"> غير مطابق</option>
                                                  <option value=" مستند غير متوفر">  مستند غير متوفر</option>
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
                                            <input type="text" name="infos[60][key]" class="form-control"
                                                   placeholder="قرار الذرعة مطابق للطبيعة" value="قرار الذرعة مطابق للطبيعة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[60][value]" class="form-control" required>
                                                <option value="مطابق">مطابق</option>
                                                <option value=" غير مطابق"> غير مطابق</option>
                                                  <option value=" مستند غير متوفر">  مستند غير متوفر</option>
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
                                            <input type="text" name="infos[61][key]" class="form-control"
                                                   placeholder="كروكي تنظيمي مطابق للطبيعة" value="كروكي تنظيمي مطابق للطبيعة"
                                                   readonly>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <select name="infos[61][value]" class="form-control" required>
                                                <option value="مطابق">مطابق</option>
                                                <option value=" غير مطابق"> غير مطابق</option>
                                                  <option value=" مستند غير متوفر">  مستند غير متوفر</option>
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
                                                        <input type="text" name="infos[66][key]" class="form-control"
                                                               placeholder=" ملاحظات  مطابقة المستندات" value="ملاحظات  مطابقة المستندات "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[66][value]" class="form-control"
                                                               placeholder=" ملاحظات  مطابقة المستندات" value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- <div class="col-md-12">-->
                                            <!--    <div class="row">-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <input type="text" name="infos[70][key]" class="form-control"-->
                                            <!--                   placeholder=" هل يعتبر الاستخدام الحالي افضل استخدام " value=" هل يعتبر الاستخدام الحالي افضل استخدام "-->
                                            <!--                   readonly>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <select name="infos[70][value]" class="form-control" required>-->
                                            <!--                <option value="نعم">نعم</option>-->
                                            <!--                <option value="لا">لا</option>-->


                                            <!--            </select>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    @error('product_price_list')-->
                                            <!--    <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                                            <!--    @enderror-->
                                            <!--</div>-->
                                            <!-- <div class="col-md-12">-->
                                            <!--    <div class="row">-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <input type="text" name="infos[71][key]" class="form-control"-->
                                            <!--                   placeholder=" ملاحظات  وتوصيات " value="ملاحظات   وتوصيات "-->
                                            <!--                   readonly>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--           <input type="text" name="infos[71][value]" class="form-control"-->
                                            <!--                   placeholder=" ملاحظات  وتوصيات " value="   "-->
                                            <!--                   required>-->

                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    @error('product_price_list')-->
                                            <!--    <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                                            <!--    @enderror-->
                                            <!--</div>-->

                                            <!--<div class="col-md-12">-->
                                            <!--    <div class="row">-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--            <input type="text" name="infos[72][key]" class="form-control"-->
                                            <!--                   placeholder=" الافتراضات الخاصة" value="الافتراضات الخاصة "-->
                                            <!--                   readonly>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-6 col-6 mb-3">-->
                                            <!--           <input type="text" name="infos[72][value]" class="form-control"-->
                                            <!--                   placeholder="  الافتراضات الخاصة  " value="   "-->
                                            <!--                   required>-->

                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    @error('product_price_list')-->
                                            <!--    <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                                            <!--    @enderror-->
                                            <!--</div>-->

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-6 mb-3">
                                                        <input type="text" name="infos[73][key]" class="form-control"
                                                               placeholder="الملاحظات العامة عن المعاين " value="  الملاحظات العامة عن المعاين"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[73][value]" class="form-control"
                                                               placeholder="   الملاحظات العامة عن المعاين  " value="   "
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
                                                        <input type="text" name="infos[74][key]" class="form-control"
                                                               placeholder=" مقارنات للعقار " value=" مقارنات للعقار "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="text" name="infos[74][value]" class="form-control"
                                                               placeholder="  مقارنات للعقار   " value="   "
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
                                                        <input type="text" name="infos[75][key]" class="form-control"
                                                               placeholder=" تاريخ المعاينة " value=" تاريخ المعاينة "
                                                               readonly>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-3">
                                                       <input type="date" name="infos[75][value]" class="form-control"
                                                               placeholder="  تاريخ المعاينة   " value="   "
                                                               required>

                                                    </div>
                                                </div>
                                                @error('product_price_list')
                                                <div class="alert" style="color:#a94442">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-md-12 col-12 mb-3">
                                <label for="files">ارفاق المستندات</label>
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
                            <hr>

                            </div>
                            <hr>
                            <button class="btn btn-primary" type="submit">إرسال الطلب للمقييم</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Data list view end -->
    </div>
    <!-- END: Content-->
@endsection
@section('frontend-footer')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('frontend') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('frontend') }}/app-assets/js/scripts/components.js"></script>
    <script src="{{ asset('frontend') }}/custom-sweetalert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script>
        $('.selectpicker').selectpicker();
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
            draggable: false
        });
    </script>

    <script>
        var childNumberprice = 2;


        function addPrice() {
            var parent = document.getElementById('prices');
            //   var newChild = '<p>Child ' + childNumber + '</p>';
            var newChild = `

            <div id="list_price_` + childNumberprice + `" class="col-md-5 col-6 mb-3">
              <label>الاسم</label>
              <input name="infos[` + childNumberprice + `][key]" type="text" class="form-control">
           </div>
           <div id="list_quantity_from_` + childNumberprice + `" class="col-md-5 col-6 mb-3">
              <label>القيمة</label>
              <input name="infos[` + childNumberprice + `][value]" type="text" class="form-control">
           </div>

           <div id="list_delete_` + childNumberprice + `" class="form-group col-md-2 col-12">
            <label></label>
                        <button type="button"  onclick="deletePrice(` + childNumberprice + `);"
                            style="padding: 10px;width:100%; background: #d9534f!important; cursor: pointer; border: none; border-radius: 5px;"><i
                                style=" color: white;" class=" fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>

           `;
            parent.insertAdjacentHTML('beforeend', newChild);
            childNumberprice++;


        }

        function deletePrice(number) {

            var list_price = document.getElementById("list_price_" + number);
            list_price.remove();

            var list_quantity_from = document.getElementById("list_quantity_from_" + number);
            list_quantity_from.remove();

            var list_delete = document.getElementById("list_delete_" + number);
            list_delete.remove();

        }


        const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

        // $("#attachment").on('change', function(e){
        //     for(var i = 0; i < this.files.length; i++){
        //         const reader = new FileReader();
        //         const img = document.createElement('img');
        //         reader.onload = function(event) {

        //             img.src = event.target.result;
        //             // previewContainer.appendChild(img);
        //         };
        //         reader.readAsDataURL(this.files.item(i));
        //         let fileBloc = $('<span/>', {class: 'file-block'}),
        //             fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
        //         fileBloc.append('<span class="file-delete"><span>+</span></span>')
        //             .append(fileName)
        //             .append(img);
        //         $("#filesList > #files-names").append(fileBloc);
        //     };
        //     // Ajout des fichiers dans l'objet DataTransfer
        //     for (let file of this.files) {
        //         dt.items.add(file);
        //     }
        //     // Mise à jour des fichiers de l'input file après ajout
        //     this.files = dt.files;

        //     // EventListener pour le bouton de suppression créé
        //     $('span.file-delete').click(function(){
        //         let name = $(this).next('span.name').text();
        //         // Supprimer l'affichage du nom de fichier
        //         $(this).parent().remove();
        //         for(let i = 0; i < dt.items.length; i++){
        //             // Correspondance du fichier et du nom
        //             if(name === dt.items[i].getAsFile().name){
        //                 // Suppression du fichier dans l'objet DataTransfer
        //                 dt.items.remove(i);
        //                 continue;
        //             }
        //         }
        //         // Mise à jour des fichiers de l'input file après suppression
        //         document.getElementById('attachment').files = dt.files;
        //     });
        // });
        $(document).on('change','input[name="previewed_in_real"]',function () {

            if($(this).val() == 'no')
            {
                $('.previewing_way').hide()
                $('.not_previewing_reason').show()
            }
            else
            {
                $('.previewing_way').show()
                $('.not_previewing_reason').hide()
            }
        });
    </script>
@endsection