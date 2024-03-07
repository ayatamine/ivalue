@extends('frontend.layout.master')
@section('frontend-head')
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAbukNOXKPE1M-2Duze7aLXcRLguKXbJQ&libraries=places&sensor=false">
</script>
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
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/themes/semi-dark-layout.css">
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
<link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
{{-- spreadsheet --}}
<link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
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

    #files-names {
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

    .file-block img {
        height: 70px;
        width: 70px;
        margin: auto;
        margin-top: 0.5rem;
    }

    .file-block>span.name {
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

    .file-delete>span {
        transform: rotate(45deg);
    }

    .market_way,
    .income_way,
    .cost_way {
        display: none
    }
</style>
@endsection
@section('frontend-main')
<!-- BEGIN: Content-->
<div class="content-body">
    <!-- Data list view starts -->
    <section id="data-thumb-view" class="data-thumb-view-header">
        {{-- @include('frontend.steps.estate_includes.estate_info') --}}
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
                            action="{{ route('level_refuse' , ['estate_id'=>$estate->id,'type'=>'rater','subdomain'=>Route::current()->parameter('subdomain')]) }}">
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
            {{--<a class="btn btn-danger"
                href="{{ route('level_refuse' , ['estate_id'=>$estate->id,'type'=>auth()->user()->membership_level]) }}">الرفض</a>--}}
            <br>
            <div class="card-header">
                <h4 class="card-title"> مستندات </h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="post"
                        action="{{ route('level_inputs' , ['estate_id'=>$estate->id,'type'=>auth()->user()->membership_level,'subdomain'=>Route::current()->parameter('subdomain')]) }}"
                        id="myform" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        {{--<div class="form-row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="row" id="prices">--}}
                                    {{--<div class="col-md-6 col-6 mb-3">--}}
                                        {{--<label>الاسم</label>--}}
                                        {{--<input type="text" name="infos[0][key]" class="form-control" --}}
                                            {{--placeholder="الاسم" value="{{$estate->price}}" required>--}}
                                        {{--</div>--}}
                                    {{--<div class="col-md-6 col-6 mb-3">--}}
                                        {{--<label>القيمة</label>--}}
                                        {{--<input type="text" name="infos[0][value]" class="form-control" --}}
                                            {{--placeholder="القيمة" value="{{$estate->price}}" required>--}}
                                        {{--</div>--}}
                                    {{--<div class="form-group col-md-12 col-xs-12">--}}
                                        {{--
                                        <hr>--}}
                                        {{--
                                    </div>--}}
                                    {{--</div>--}}
                                {{--@error('product_price_list')--}}
                                {{--<div class="alert" style="color:#a94442">{{ $message }}</div>--}}
                                {{--@enderror--}}
                                {{--</div>--}}
                            {{--<div class="col-md-12 col-12 mb-3">--}}
                                {{--<button type="button" onclick="addPrice();" --}}
                                    {{--class="vendor-btn-xs industrial-area-btn btn btn-info w-100">اضافة
                                    جديد</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--
                        <hr>--}}




                        <div class="col-md-12 col-12 mb-3">
                            <label for="files">ارفاق المستندات</label>
                            <p class="mt-5 text-center">
                                <label for="attachment">
                                    <a class="btn btn-primary text-light" role="button" aria-disabled="false">+ Add</a>

                                </label>
                                <input type="file" name="files[]" id="attachment"
                                    style="visibility: hidden; position: absolute;" multiple />

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


                        {{-- <div class="form-row mb-3">
                            <div class="col-sm-12 col-12">
                                <label for="rating_ways">
                                    أساليب التقييم
                                </label>
                                <select name="rating_ways[]" multiple id="rating_ways"
                                    class="selectpicker form-control">
                                    <option value="market_way">أسلوب السوق</option>
                                    <option value="income_way">أسلوب الدخل</option>
                                    <option value="cost_way">أسلوب التكلفة</option>
                                </select>
                                @error('rating_ways')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3 ">
                            <div class="col-sm-4 col-12 market_way">
                                <label for="market_way">
                                    اسلوب السوق
                                </label>
                                <div class="form-group mt-1">
                                    <select name="market_way" id="market_way" class="select2 form-control ">
                                        <option value="" selected disabled> اختر</option>
                                        <optgroup label="طريقة المعاملات المقارنة">
                                            <option value="comparative_summation">--- جمع</option>
                                            <option value="comparative_comulative">--- تراكمي</option>
                                        </optgroup>
                                        <option value="comparative_heuristic"> الطريقة الارشادية
                                            للمقارنات المتداولة</option>

                                    </select>
                                </div>
                                @error('market_way')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-4 col-12 income_way">
                                <label for="income_way">
                                    اسلوب الدخل
                                </label>
                                <div class="form-group mt-1">
                                    <select name="income_way" id="income_way" class="select2 form-control ">
                                        <optgroup label="طريقة الاستثمار">
                                            <option value="details">--- مفصل</option>
                                            <option value="brief">--- مختصر</option>
                                        </optgroup <option value="طريقة القيمة المتبقية"> طريقة القيمة المتبقية</option>
                                        <option value="طريقة الارباح"> طريقة الارباح</option>
                                        <option value="طريقة التدفقات النقدية المخصومة (DCF)">طريقة التدفقات النقدية
                                            المخصومة (DCF) </option>

                                    </select>
                                </div>
                                @error('income_way')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-4 col-12 cost_way">
                                <label for="cost_way">
                                    اسلوب التكلفة
                                </label>
                                <div class="form-group mt-1">
                                    <select name="cost_way" id="cost_way" class="select2 form-control ">
                                        <option value="طريقة تكلفة الاحلال"> طريقة تكلفة الاحلال</option>
                                        <option value="طريقة تكلفة اعادة الانتاج"> طريقة تكلفة اعادة الانتاج</option>
                                        <option value="طريقة الجمع">طريقة الجمع </option>

                                    </select>
                                </div>
                                @error('cost_way')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div id="rating_ways_block">
                            <hr>
                            <h6 class="d-flex justify-content-between align-items-center"> <span>جدول طرق التقييم</span>
                            <button class="btn btn-sm  text-dark " style="     font-size: 13px;
                            background: #f3f3f3;
                            border: 1px solid #d4d4d4;
                            padding: 6px 1rem;margin-left: 1.5rem;" id="add_rating_way_row""> + سطر جديد</button>
                            </h6>
                            <div id="rating_ways_table"></div>
                        </div>
                        <div id="spreadsheet_block">

                        </div>
                        <div id="spreadsheet"></div>

                        <div id="value_equalizer_block" >
                            <hr>
                            <h6>جدول ترجيح القيمة</h6>
                            <div id="value_equalizer_table"></div>
                        </div>
                        <div id="value_edit_block" >
                            <hr>
                            <h6>جدول تعديل القيمة</h6>
                            <div id="value_edit_table"></div>
                        </div>
                        <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="save-copy" >حفظ نسخة</button>
                        <!--<div class="rate_info">-->
                        <!--    <div class="col-md-12">-->
                        <!--            <div class="row">-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <input type="text" name="infos[0][key]" class="form-control"-->
                        <!--                           placeholder=" هل يعتبر الاستخدام الحالي افضل استخدام " value=" هل يعتبر الاستخدام الحالي افضل استخدام "-->
                        <!--                           readonly>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <select name="infos[0][value]" class="form-control" required>-->
                        <!--                        <option value="لا">لا</option>-->
                        <!--                        <option value="لا">لا</option>-->


                        <!--                    </select>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            @error('product_price_list')-->
                        <!--            <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                        <!--            @enderror-->
                        <!--        </div>-->
                        <!--        <div class="col-md-12">-->
                        <!--            <div class="row">-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <input type="text" name="infos[1][key]" class="form-control"-->
                        <!--                           placeholder=" ملاحظات  وتوصيات " value="ملاحظات   وتوصيات "-->
                        <!--                           readonly>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                   <input type="text" name="infos[1][value]" class="form-control"-->
                        <!--                           placeholder=" ملاحظات  وتوصيات " value="   "-->
                        <!--                           required>-->

                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            @error('product_price_list')-->
                        <!--            <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                        <!--            @enderror-->
                        <!--        </div>-->

                        <!--        <div class="col-md-12">-->
                        <!--            <div class="row">-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <input type="text" name="infos[2][key]" class="form-control"-->
                        <!--                           placeholder=" الافتراضات الخاصة" value="الافتراضات الخاصة "-->
                        <!--                           readonly>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                   <input type="text" name="infos[2][value]" class="form-control"-->
                        <!--                           placeholder="  الافتراضات الخاصة  " value="   "-->
                        <!--                           required>-->

                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            @error('product_price_list')-->
                        <!--            <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                        <!--            @enderror-->
                        <!--        </div>-->

                        <!--        <div class="col-md-12">-->
                        <!--            <div class="row">-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <input type="text" name="infos[3][key]" class="form-control"-->
                        <!--                           placeholder=" الشروط الخاصة" value="الشروط الخاصة "-->
                        <!--                           readonly>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                   <input type="text" name="infos[3][value]" class="form-control"-->
                        <!--                           placeholder="  الشروط الخاصة  " value="   "-->
                        <!--                           required>-->

                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            @error('product_price_list')-->
                        <!--            <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                        <!--            @enderror-->
                        <!--        </div>-->

                        <!--        <div class="col-md-12">-->
                        <!--            <div class="row">-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                    <input type="text" name="infos[4][key]" class="form-control"-->
                        <!--                           placeholder=" تاريخ التقييم " value="  تاريخ التقييم"-->
                        <!--                           readonly>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-6 col-6 mb-3">-->
                        <!--                   <input type="date" name="infos[4][value]" class="form-control"-->
                        <!--                           placeholder="     " value="   "-->
                        <!--                           required>-->

                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            @error('product_price_list')-->
                        <!--            <div class="alert" style="color:#a94442">{{ $message }}</div>-->
                        <!--            @enderror-->
                        <!--        </div>-->
                        <!--</div>-->
                        <hr id="last_hr">
                        <div class="mb-3 px-2 flex-column d-flex flex-md-row justify-content-between align-items-center "
                            style="    gap: 1%;">
                            <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">إرسال
                                الطلب للمراجع</button>
                            <span class="btn btn-warning w-50 mb-1 mb-md-0 " id="return_coordinator">إعادة الطلب
                                للمنسق</span>
                            <span class="btn btn-danger w-50 mb-1 mb-md-0 " id="return_previewer">إعادة الطلب
                                للمعاين</span>
                        </div>
                    </form>
                    @php
                    // $inputs = \App\Models\EstateInput::whereEstateId($estate->id);
                    @endphp
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
<script>
    $(document).ready(function () {
        $('#return_coordinator').click(function (e) {
                e.preventDefault();
                $('#return_previewer').text('إعادة الطلب للمعاين')
                $(this).text('انقر للتأكيد ...')
                $('#myform').append(`<input type="text" class="d-none" name="return" id="order_return" value="coordinator" >`)
                if($('#reject_note').length){
                    $('#myform').submit();
                }else{
                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="reject_note"> ملاحظة على سبب الإرجاع </label>
                                        <textarea rows="5" type="text" name="reject_note"
                                                  class="form-control" id="reject_note" placeholder="اكتب ملاحظة على سبب الإرجاع "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

        });
        $('#return_previewer').click(function (e) {
                e.preventDefault();
                $('#return_coordinator').text('إعادة الطلب للمنسق')
                $(this).text('انقر للتأكيد ...')
                $('#myform').append(`<input type="text" class="d-none" name="return" id="order_return" value="previewer" >`)
                if($('#reject_note').length){
                    console.log('yess')
                    $('#myform').submit();
                }else{
                    $(`<div class="col-md-12 col-12 mb-3">
                                        <label for="reject_note"> ملاحظة على سبب الإرجاع </label>
                                        <textarea rows="5" type="text" name="reject_note"
                                                  class="form-control" id="reject_note" placeholder="اكتب ملاحظة على سبب الإرجاع "
                                                  value=""></textarea>
                                    </div>`).insertBefore('#last_hr')
                }

        });
        $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#order_return').remove();
               $('#reject_note').remove();
               $('#myform').submit();
        });
      })
</script>
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
<script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>

<script src="https://jsuites.net/v4/jsuites.js"></script>
{{-- <script>
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
</script> --}}

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

        $(function () {
            $("#assessment").change(function() {
                $(".rate_info").show();
            });
            $(document).on('change','#rating_ways',function()
            {
                let selected_ways = $(this).val();
                $('.market_way').css('display','none')
                $('.income_way').css('display','none')
                $('.cost_way').css('display','none')
                selected_ways.forEach(element => {
                    $('.'+element).css('display','block')
                });

            });
        });
</script>
<script>
    var value_equalizer = [];
    var selected_methods=[]
    var  active_row = 0;
    var sheets = [ ];
    var choosen_tables_data=[]
    window.localStorage.removeItem('investement_methods_cell_merged')

    methodsdropdownFilter = function(instance, cell, c, r, source) {
        var value = instance.jexcel.getValueFromCoords(c - 1, r);
        if (value == 1) {
            return [{'id':'1', 'name':'طريقة المعاملات المقارنة'}, {'id':'2', 'name':'الطريقة الإرشادية للمقارنات المتداولة'}];
        } else if (value == 2) {
            return [{'id':'3', 'name':'طريقة الاستثمار'},{'id':'4', 'name':'طريقة القيمة المتبقية'} ,{'id':'5', 'name':'طريقة الأرباح'}
                             ,{'id':'6', 'name':'طريقة التدفقات النقدية المخصومة DCF'}];
        } else  {
            return source.filter((item)=>item.id > 6);
        }
    }
    detailsdropdownFilter = function(instance, cell, c, r, source) {
        var value = instance.jexcel.getValueFromCoords(c - 1, r);
        if (value == 1) {
            return [{'id':'1', 'name':'تراكمي'}, {'id':'2', 'name':'جمع'}];
        } else if (value == 3) {
            return [{'id':'3', 'name':'مفصل'}, {'id':'4', 'name':'مختصر'}];
        } else {
            return [];
        }
    }
    var rating_ways_table =jspreadsheet(document.getElementById('rating_ways_table'), {
                data:[
                    ['','',''],
                ],
                columns: [
                    {
                            type: 'dropdown',
                            title:'أسلوب التقييم',
                            source:[ {'id':'1', 'name':'أسلوب السوق'}, {'id':'2', 'name':'أسلوب الدخل'}, {'id':'3', 'name':'أسلوب التكلفة'} ],
                            width:400,

                            // readOnly:true,
                    },
                    {
                            type: 'dropdown',
                            title:'طريقة التقييم',
                            source:[ {'id':'1', 'name':'طريقة المعاملات المقارنة'}, {'id':'2', 'name':'الطريقة الإرشادية للمقارنات المتداولة'},
                             {'id':'3', 'name':'طريقة الاستثمار'},{'id':'4', 'name':'طريقة القيمة المتبقية'} ,{'id':'5', 'name':'طريقة الأرباح'}
                             ,{'id':'6', 'name':'طريقة التدفقات النقدية المخصومة DCF'},
                             {'id':'7', 'name':'طريقة تكلفة الاحلال'},{'id':'8', 'name':'طريقة تكلفة إعادةالانتاج'},{'id':'9', 'name':'طريقة الجمع'}],
                            width:300,filter:methodsdropdownFilter
                            // readOnly:true,
                    },
                    {
                            type: 'dropdown',
                            title:'تفصيل', width:200,
                            source:[ {'id':'1', 'name':'تراكمي'}, {'id':'2', 'name':'جمع'}, {'id':'3', 'name':'مفصل'}, {'id':'4', 'name':'مختصر'}],
                            filter:detailsdropdownFilter
                            // readOnly:true,
                    }
                ],
                allowInsertColumn:false,
                onchange:function(instance, cell, c, r, value) {
                    active_row = r;
                    if (c == 0) {
                        var columnName = jspreadsheet.getColumnNameFromId([c + 1, r]);
                        instance.jexcel.setValue(columnName, '');

                    }
                    else
                    {
                        if(c ==1)
                        {

                            prepareSheet(parseInt(value),false);

                        }else{
                            prepareSheet(parseInt(value),true);

                        }
                    }
                    //TODO: fix this
                    // if(selected_methods.length == 3)
                    // {
                    //     instance.options.allowInsertColumn =false
                    // }
                },
                mergeCells:{
                },
                style: {
                },
    })
    $('#value_equalizer_block').css('display','block')
        var value_equalizer_table=null;
        //value_equalizer_table
        if($('#value_equalizer_table').html() == '')
        {

             value_equalizer_table =jspreadsheet(document.getElementById('value_equalizer_table'), {
                    data:[[],[],[],['','قيمة العقار بعد الترجيح','=ROUND(D1 + D2 + D3,2)','']],
                    columns: [
                        {
                                type: 'text',
                                title:'طريقة التقييم',
                                width:300,
                                // readOnly:true,
                        },
                        {
                                type: 'text',
                                title:'القيمة',
                                width:200,
                        },
                        {
                                type: 'numeric',
                                title:'نسبةالترجيح',
                                width:200
                        },
                        {
                                type: 'numeric',
                                title:'الوزن',
                                width:200
                        }
                    ],
                    mergeCells:{
                    },
                    allowInsertColumn:false,
                    allowInsertRow:false,
                    allowDeleteRow:false,
                    style: {
                        B4:'background-color: #EEECE1;color:#000;',
                        C4:'background-color: #EEECE1;color:#000;',
                    },
                    onload:function(instance, cell, x, y, value) {

                                // if(!$(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'></span>");
                                if(!$(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#value_equalizer_table td[data-x="2"][data-y="3"]`).find("span").length) $(`#value_equalizer_table td[data-x="2"][data-y="3}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(y != 3)$(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).text(parseFloat( $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).text()) * parseFloat( $(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).text()) * 0.01);
                                //حساب قيمة الترجيح
                                $(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text(
                                     parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="0"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="1"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="2"]`).text())
                                )
                    },
                    oneditionend:function(instance, cell, x, y, value) {

                                // if(!$(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>,00</span>");
                                if(!$(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                // if(!$(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>,00</span>");
                                if(y != 3)$(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).text(parseFloat( $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).text()) * parseFloat( $(`#value_equalizer_table td[data-x="1"][data-y="${y}"]`).text()) * 0.01);

                                $(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text(
                                     parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="0"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="1"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="2"]`).text())
                                )

                    },
                    onchange:function(instance, cell, x, y, value) {
                        if(!$(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                        // if(!$(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>,00</span>");
                        if(y != 3)$(`#value_equalizer_table td[data-x="3"][data-y="${y}"]`).text(parseFloat( $(`#value_equalizer_table td[data-x="2"][data-y="${y}"]`).text()) * parseFloat( $(`#value_equalizer_table td[data-x="1"][data-y="0"]`).text()) * 0.01);
                        let calc_value =0;
                        if(parseFloat( $(`#value_edit_table td[data-x="1"][data-y="0"]`).text()) == 0)
                        {
                            calc_value = parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text())
                        }
                        else
                        {
                            calc_value =(parseFloat( $(`#value_edit_table td[data-x="1"][data-y="0"]`).text()) * 0.01) *  parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text())

                        }
                        $(`#value_edit_table td[data-x="2"][data-y="0"]`).text(calc_value.toFixed(2))
                        $(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text(
                                     parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="0"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="1"]`).text())
                                    +~~parseFloat( $(`#value_equalizer_table td[data-x="3"][data-y="2"]`).text())
                                )
                    }
            })
        }
        var value_edit_table =null;
        if($('#value_edit_table').html() == '')
        {

             value_edit_table =jspreadsheet(document.getElementById('value_edit_table'), {
                    data:[['',0,0,0]],
                    columns: [
                        {
                                type: 'text',
                                title:'الغرض من التقييم',
                                width:300,
                                // readOnly:true,
                        },
                        {
                                type: 'text',
                                title:'نسبة التعديل',
                                width:200,
                        },
                        {
                                type: 'numeric',
                                title:'قيمة التعديل',
                                width:200
                        },
                        {
                                type: 'numeric',
                                title:'قيمة العقار بعد التعديل',
                                width:200
                        }
                    ],
                    mergeCells:{
                    },
                    allowInsertColumn:false,
                    allowInsertRow:false,
                    allowDeleteRow:false,
                    style: {
                        // B4:'background-color: #EEECE1;color:#000;',
                        // C4:'background-color: #EEECE1;color:#000;',
                    },
                    onload:function(instance, cell, x, y, value) {

                        if(!$(`#value_edit_table td[data-x="1"][data-y="0"]`).find("span").length) $(`#value_edit_table td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>%</span>");
                        $(`#value_edit_table td[data-x="2"][data-y="0"]`).text(
                           (parseFloat($(`#value_edit_table td[data-x="1"][data-y="0"]`).text()) * 0.01 +1) * (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()))
                        )
                        $(`#value_edit_table td[data-x="3"][data-y="0"]`).text(
                            (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()) + parseFloat($(`#value_edit_table td[data-x="2"][data-y="0"]`).text())).toFixed(2)
                        )
                    },
                    oneditionend:function(instance, cell, x, y, value) {

                        if(!$(`#value_edit_table td[data-x="1"][data-y="0"]`).find("span").length) $(`#value_edit_table td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>%</span>");
                        $(`#value_edit_table td[data-x="2"][data-y="0"]`).text(
                           (parseFloat($(`#value_edit_table td[data-x="1"][data-y="0"]`).text()) * 0.01 +1) * (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()))
                        )
                        $(`#value_edit_table td[data-x="3"][data-y="0"]`).text(
                            (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()) + parseFloat($(`#value_edit_table td[data-x="2"][data-y="0"]`).text())).toFixed(2)
                        )
                    },
                    onchange:function(instance, cell, x, y, value) {

                        if(!$(`#value_edit_table td[data-x="1"][data-y="0"]`).find("span").length) $(`#value_edit_table td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>%</span>");
                        $(`#value_edit_table td[data-x="2"][data-y="0"]`).text(
                           (parseFloat($(`#value_edit_table td[data-x="1"][data-y="0"]`).text()) * 0.01 +1) * (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()))
                        )
                        $(`#value_edit_table td[data-x="3"][data-y="0"]`).text(
                            (parseFloat($(`#value_equalizer_table td[data-x="2"][data-y="3"]`).text()) + parseFloat($(`#value_edit_table td[data-x="2"][data-y="0"]`).text())).toFixed(2)
                        )
                    },
            })
        }
    function prepareSheet(value,isDetailed){
    // $(document).on('change','#market_way',function(){
        // selected_ways.push(
        //     [
        //         "أسلوب السوق",$(this).find("option:selected").text(),""
        //     ]
        // )



        var columns = [ {
                            type: 'text',
                            title:'تجربة',
                            width:400,
                            readOnly:true,
                        },];
        var data = [['تجربة']];

        if(isDetailed)
        {
            switch (value) {

                case 1 : //تراكمي
                    //columns for أرض
                        columns =
                        [
                            {
                                type: 'text',
                                title:'خصائص التسويات',
                                width:400,
                                readOnly:true,
                            },
                            {
                                type: 'text',
                                title:'بند',
                                width:100
                            },
                            {
                                type: 'text',
                                title:'عقار التقييم',
                                width:100,
                                // readOnly:true,
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 1',
                                // mask:'0,0 %',
                                width:100
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 2',
                                // mask:'0,0 %',
                                width:100
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 3',
                                // mask:'0,0 %',
                                width:100
                            },
                        ]
                        data =
                        [
                                ['سعر المتر المربع الواحد (ريال)', '', '', '0', '0', '0'],
                                ['نوع العقار', '', "{{$estate->kind->name}}", "{{$estate->kind->name}}","{{$estate->kind->name}}", "{{$estate->kind->name}}"],
                                ['تسوية نوع العقار','', '', '0', '0', '0'],
                                ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                                ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                                ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                                [' تسوية شروط التمويل','', '', '0', '0', '0'],
                                [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                                [' تسوية شروط البيع','', '', '0', '0', '0'],
                                [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                                [' تسوية ظروف السوق','', '', '0', '0', '0'],
                                [' التخطيط نظام البناء','', 'عمائر', 'تجاري عمائر', 'تجاري عمائر', 'تجاري فيلال'],
                                [' تسوية التخطيط نظام البناء','', '', '0', '0', '0'],
                                ['المساحة (م2)','', "{{$estate->land_size}}", '0', '0', '0'],
                                ['تسوية المساحة بطريقة الامثال','0', '', '=ROUND((D14-C14)/D14*B15 ,3)', '=ROUND((E14-C14)/E14*B15 ,3)', '=ROUND((F14-C14)/F14*B15 ,3)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '', '', ''],
                                ['طبيعة الأرض','', 'مستوية', 'مستوية', 'مستوية', 'مستوية'],
                                ['تسوية طبيعة الأرض','', '', '0', '0', '0'],
                                ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                                ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                                ['موقع العقار سهولة الوصول والاستدلال','', 'جيد', 'متوسط', 'ممتاز', 'ممتاز'],
                                ['تسوية بعد العقار عن مركز المدينة','', '', '0', '0', '0'],
                                ['مميزات العقار','', '', 'لايوجد', 'لايوجد', 'لايوجد'],
                                ['تسوية مميزات العقار','', '', '0', '0', '0'],
                                ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                                ['تسوية أخرى','', '', '0', '0', '0'],
                                ['سعر المتر بعد تسويات خصائص العقار (ريال)','', '',
                                "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*(1+D3*0.01)*D1,3)",
                                "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*(1+E3*0.01)*E1,3)",
                                "=ROUND((1+F33*0.01)*(1+F31*0.01)*(1+F29*0.01)*(1+F27*0.01)*(1+F25*0.01)*(1+F23*0.01)*(1+F21*0.01)*(1+F19*0.01)*(1+F17*0.01)*(1+F15*0.01)*(1+F13*0.01)*(1+F11*0.01)*(1+F9*0.01)*(1+F7*0.01)*(1+F5*0.01)*(1+F3*0.01)*F1,3)"
                                ],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND((D35/100)*D34+(E35/100)*E34+(F35/100)*F34,3)', '', '', '', ''],
                                ['مساحة الأرض (م2)',"=C14", '', '', '', ''],
                                ['قيمة الأرض (ريال)','=ROUND(B36*B37,2)', '', '', '', ''],
                        ];
                    handleSheet('comparative_comulative',columns,data);
                    break;
                case 2://جمع
                        //columns for أرض
                        columns =
                        [
                            {
                                type: 'text',
                                title:'خصائص التسويات',
                                width:400,
                                readOnly:true,
                            },
                            {
                                type: 'text',
                                title:'بند',
                                width:100
                            },
                            {
                                type: 'text',
                                title:'عقار التقييم',
                                width:100,
                                // readOnly:true,
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 1',
                                // mask:'0,0 %',
                                width:100
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 2',
                                // mask:'0,0 %',
                                width:100
                            },
                            {
                                type: 'numeric',
                                title:'مقارنة 3',
                                // mask:'0,0 %',
                                width:100
                            },
                        ]
                        data =
                        [
                                ['سعر المتر المربع الواحد (ريال)', '', '', '0', '0', '0'],
                                ['نوع العقار', '', "{{$estate->kind->name}}", "{{$estate->kind->name}}","{{$estate->kind->name}}", "{{$estate->kind->name}}"],
                                ['تسوية نوع العقار','', '', '0', '0', '0'],
                                ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                                ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                                ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                                [' تسوية شروط التمويل','', '', '0', '0', '0'],
                                [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                                [' تسوية شروط البيع','', '', '0', '0', '0'],
                                [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                                [' تسوية ظروف السوق','', '', '0', '0', '0'],
                                [' التخطيط نظام البناء','', 'عمائر', 'تجاري عمائر', 'تجاري عمائر', 'تجاري فيلال'],
                                [' تسوية التخطيط و نظام البناء','', '', '0', '0', '0'],
                                ['المساحة (م2)','', "{{$estate->land_size}}", '0', '0', '0'],
                                ['تسوية المساحة بطريقة الامثال','5,00', '', '=ROUND((D14-C14)/D14*B15*0.01 ,1)', '=ROUND((E14-C14)/E14*B15*0.01 ,1)', '=ROUND((F14-C14)/F14*B15*0.01 ,1)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '=ROUND((D22/D14*100*B23-(C22/C14*100*B23))*-1 ,1)', '=ROUND((E22/E14*100*B23-(C22/C14*100*B23))*-1  ,1)', '=ROUND((F22/F14*100*B23-(C22/C14*100*B23))*-1  ,1)'],
                                ['طبيعة الأرض','', 'مستوية', 'مستوية', 'مستوية', 'مستوية'],
                                ['تسوية طبيعة الأرض','', '', '0', '0', '0'],
                                ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                                ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                                ['موقع العقار سهولة الوصول والاستدلال','', 'جيد', 'متوسط', 'ممتاز', 'ممتاز'],
                                ['تسوية بعد العقار عن مركز المدينة','', '', '0', '0', '0'],
                                ['مميزات العقار','', '', '0', '0', 'لايوجد'],
                                ['تسوية مميزات العقار','', '', '0', '0', '0'],
                                ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                                ['تسوية أخرى','', '', '0', '0', '0'],
                                ['اجمالي التسويات','', '',
                                '=ROUND(D33+D31+D29+D27+D25+D23+D21+D19+D17+D15+D13+D11+D9+D7+D5+D3 ,1)',
                                '=ROUND(E33+E31+E29+E27+E25+E23+E21+E19+E17+E15+E13+E11+E9+E7+E5+E3 ,1)',
                                '=ROUND(F33+F31+F29+F27+F25+F23+F21+F19+F17+F15+F13+F11+F9+F7+F5+F3 ,1)'],
                                ['سعر المتر بعد تسويات خصائص العقار (ريال)','', '', "=ROUND((1+(D34*0.01))*D1 ,3)",
                                "=ROUND((1+(E34*0.01))*E1 ,3)",
                                "=ROUND((1+(F34*0.01))*F1 ,3)",],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND(D36*0.01*D35+E36*0.01*E35+F36*0.01*F35,3)', '', '', '', ''],
                                ['مساحة الأرض (م2)',"{{$estate->land_size}}", '', '', '', ''],
                                ['قيمة الأرض (ريال)','=ROUND(B37*B38,3)', '', '', '', ''],
                        ];
                    handleSheet('comparative_summation',columns,data);
                    break;
                case 3://مفصل استثمار
                        //columns for أرض

                    handleSheet('investment_detailed',columns,data);
                    break;
                case 4://مختصر استثمار
                        //columns for أرض

                    handleSheet('investment_shortened',columns,data);
                    break;

                default:
                    handleSheet('comparative_heuristic',columns,data);
                    break;
            }
        }

    }
    //create rating ways table  جدول طرق التقييم
    // $('#rating_ways_block').css('display','block')
    // $('#value_equalizer_block').css('display','block')
    //add element before table



//         }
    function updateValueEqualizerTable(instance,x,y)
    {
          //update جدول ترجيح
        let table_id = instance.getAttribute('id');
        let row_number = table_id.slice(11,12)

        value_equalizer_table.setRowData(parseInt(row_number),
                        [$(`#value_equalizer_table td[data-x="0"][data-y="${row_number}"]`).text(),parseFloat($(`#${table_id} td[data-x="${x}"][data-y="${y}"]`).text()),0,parseFloat($(`#${table_id} td[data-x="${x}"][data-y="${y}"]`).text())])

        // if(!$(`#value_equalizer_table td[data-x="3"][data-y="${selected_methods.length}"]`).length)
    }
    var SUMCOL = function(instance, columnId) {
                        var total = 0;
                        for (var j = 0; j < instance.options.data.length; j++) {
                            if (Number(instance.records[j][columnId].innerHTML)) {
                                total += Number(instance.records[j][columnId].innerHTML);
                            }
                        }
                        return total;
    }
   function handleSheet(type,columns,data)
   {

    let selected_method_name = $(`#rating_ways_table td[data-x="0"][data-y="${active_row}"]`).text()+'-'+ $(`#rating_ways_table td[data-x="1"][data-y="${active_row}"]`).text()+'-'+
                        $(`#rating_ways_table td[data-x="2"][data-y="${active_row}"]`).text()
        switch (type) {
            case 'comparative_comulative':
                /**
                * 111 means user select أسلوب الاول والطريقة الاولى والتفصيل الأول
                */
                if(selected_methods.indexOf( active_row+'111') != -1) return ;
                //if it is the same row choice by checking if active_row+112 exist
                if(selected_methods.indexOf(active_row+'112') != -1 )
                {
                    $('#spreadsheet'+active_row+'112').parent().remove();
                    selected_methods = selected_methods.filter(item => item != active_row+'112')
                }
                //process if the table doesnt exist
                selected_methods.push(active_row+'111')
                $('#spreadsheet_block').append(`
                    <div>
                        <hr class="my-1">
                        <h6 >جدول طريقة المقارنة - تراكمي - </h6>
                        <div id="spreadsheet${active_row}111"></div>
                    </div>
                `)

                // if(parseInt(active_row) ==0)
                // {
                //     // let last_row_number = $(`#spreadsheet${active_row}111  tbody tr:last-child td`).data('y');
                //       $(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(
                //         selected_method_name
                //       );

                // }else{
                    // $(`#value_equalizer_table td[data-x="1"][data-y="0"]`).text(
                    //     selected_method_name
                    //   );
                value_equalizer_table.setRowData(parseInt(active_row),
                        [selected_method_name,0,0,0]
                    )
                // }
                if("{{$estate->category_id}}" == 2) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة المباني','', '', '=ROUND(D1/D2*C2 , 3)', '=ROUND(E1/E2*C2 , 3)', '=ROUND(F1/F2*C2 , 3)'],
                            ['نوع العقار', '', "{{$estate->kind->name}}", "{{$estate->kind->name}}","{{$estate->kind->name}}", "{{$estate->kind->name}}"],
                            ['تسوية نوع العقار','', '','0','0','0'],
                            ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                            ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                            ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                            [' تسوية شروط التمويل','', '', '0', '0', '0'],
                            [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            [' تسوية شروط البيع','', '', '0', '0', '0'],
                            [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                            [' تسوية ظروف السوق','', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "=C2", "=D2","=E2", "=F2"],
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,1)', '=ROUND((E14-C14)/E14*B15 ,1)', '=ROUND((F14-C14)/F14*B15 ,1)'],
                            ['الطابق','', '0', '0', '0', '0'],
                            ['تسوية الطابق','', '', '0', '0', '0'],
                            ['موقع العقار من المبنى','', 'أمامية', 'أمامية', 'أمامية', 'أمامية'],
                            ['تسوية موقع العقار من المبنى','', '', '0', '0', '0'],
                            ['واجهة العمارة','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                            ['تسوية واجهة العمارة','', '', '0', '0', '0'],
                            ['مستوى التشطيب','', 'فاخر',	'فاخر',	'جيد',	'فاخر'],
                            ['تسويات مستوى التشطيب','', '', '0', '0', '0'],
                            ['عمر العقار','', '0 سنة','0 سنة','0 سنة','0 سنة'],
                            ['تسوية عمر العقار','', '','','',''],
                            ['توفر موقف خاص','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر موقف خاص','', '', '0', '0', '0'],
                            ['توفر غرفة سائق','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر غرفة سائق','', '', '0', '0', '0'],
                            ['توفر سطح خاص/بلكونة','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر سطح خاص/بلكونة','', '', '0', '0', '0'],
                            ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                            ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                            ['مميزات الموقع العام','','لايوجد','0','0','0'],
                            ['تسوية مميزات العقار','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                            "=ROUND((1+D37*0.01)*(1+D35*0.01)*(1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,3)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,3)",
                            "=ROUND((1+F37*0.01)*(1+F35*0.01)*(1+F33*0.01)*(1+F31*0.01)*(1+F29*0.01)*(1+F27*0.01)*(1+F25*0.01)*(1+F23*0.01)*(1+F21*0.01)*(1+F19*0.01)*(1+F17*0.01)*(1+F15*0.01)*(1+F13*0.01)*(1+F11*0.01)*(1+F9*0.01)*(1+F7*0.01)*(1+F5*0.01)*F3,3)",
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND((D39*0.01)*D38+(E39*0.01)*E38+(F39*0.01)*F38 ,3)','', ''],
                    ];

                    var percentged_rows =Array.from(Array(40).keys()).filter(function(i){ return i%2 ==0 && i > 2;})
                    var currency_rows =[0,2,37,39]
                    var area_rows =[1,13]
                    choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
                    data:data,
                    columns: columns,
                    mergeCells:{
                        B40:[2,1]
                    },
                    style: {
                        C40:'background-color: #EEECE1;color:#000;font-weight:bold',
                        D40:'background-color: #EEECE1;color:#000;font-weight:bold',
                    },
                    onload:function(instance, cell, x, y, value) {

                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////

                        percentged_rows.forEach(y => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                         //update جدول ترجيح
                         updateValueEqualizerTable(instance,3,39)
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                          //update جدول ترجيح
                          updateValueEqualizerTable(instance,3,39)

                    },
                    onchange:function(instance, cell, x, y, value) {
                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////

                        if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                       //update جدول ترجيح
                       updateValueEqualizerTable(instance,3,39)
                    }
                })
                return;
                }
                if("{{$estate->category_id}}" == 1) //فيلا
                {

                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة العقار لمساحة الأرض','', '', '=ROUND(D1/D2*C2 , 3)', '=ROUND(E1/E2*C2 , 3)', '=ROUND(F1/F2*C2 , 3)'],
                            ['نوع العقار', '', "فيلا سكنية", "فيلا سكنية","فيلا سكنية", "فيلا سكنية"],
                            ['تسوية نوع العقار','', '', '0','0','0'],
                            ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                            ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                            ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                            [' تسوية شروط التمويل','', '', '0', '0', '0'],
                            [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            [' تسوية شروط البيع','', '', '0', '0', '0'],
                            [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                            [' تسوية ظروف السوق','', '', '0', '0', '0'],
                            [' التخطيط نظام البناء','', 'سكني', 'سكني', 'سكني', 'سكني'],
                            [' تسوية التخطيط ونظام البناء','', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "=C2", "=D2","=E2", "=F2"],
                            ['تسوية مساحة الأرض بطريقة الامثال','5', '','=ROUND((D16-C16)/D16*B17 ,3)', '=ROUND((E16-C16)/E16*B17 ,3)', '=ROUND((F16-C16)/F16*B17 ,3)'],
                            ['عدد طوابق العقار','', '1', '0', '0', '0'],
                            ['تسوية عدد طوابق العقار','', '', '0', '0', '0'],
                            ['عدد الشوارع','', '1', '0', '0', '0'],
                            ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                            ['واجهة المبنى','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                            ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                            ['مستوى التشطيب','', 'فاخر',	'فاخر',	'جيد',	'فاخر'],
                            ['تسويات مستوى التشطيب','', '', '0', '0', '0'],
                            ['عمر العقار','', '0 سنة','0 سنة','0 سنة','0 سنة'],
                            ['تسوية عمر العقار','', '','','',''],
                            ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                            ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                            ['مميزات الموقع العام','','لايوجد','0','0','0'],
                            ['تسوية مميزات العقار','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,3)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,3)",
                            "=ROUND((1+F33*0.01)*(1+F31*0.01)*(1+F29*0.01)*(1+F27*0.01)*(1+F25*0.01)*(1+F23*0.01)*(1+F21*0.01)*(1+F19*0.01)*(1+F17*0.01)*(1+F15*0.01)*(1+F13*0.01)*(1+F11*0.01)*(1+F9*0.01)*(1+F7*0.01)*(1+F5*0.01)*F3,3)",
                            ],
                            ['مسبح'	,	'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            '=ROUND(D34+D36*0.01+D38*0.01+D40*0.01,3)',
                            '=ROUND(E34+E36*0.01+E38*0.01+E40*0.01,3)',
                            '=ROUND(F34+F36*0.01+F38*0.01+F40*0.01,3)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح','','=ROUND(D42*D41+E42*E41+F42*F41 ,3)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i > 2;})
                    percentged_rows = percentged_rows.concat([35,37,39,41]);
                    var currency_rows =[0,2,33,40,42]
                    var area_rows =[1,15]
                    choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
                        data:data,
                        columns: columns,
                        tableOverflow: true,
                        mergeCells:{
                            B43:[2,1]
                        },
                        style: {
                            C43:'background-color: #EEECE1;color:#000;;font-weight:bold',
                            D43:'background-color: #EEECE1;color:#000;;font-weight:bold',
                        },
                        onload:function(instance, cell, x, y, value) {
                            //if there is not inner span
                            //////////////////////////
                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            ///////////////////////////////


                            percentged_rows.forEach(y => {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                            updateValueEqualizerTable(instance,3,42)
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                             //////////////////////////
                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            ///////////////////////////////
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                            updateValueEqualizerTable(instance,3,42)

                        },
                        onchange:function(instance, cell, x, y, value) {
                            //////////////////////////
                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            ///////////////////////////////
                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                            updateValueEqualizerTable(instance,3,42)


                        }
                    })
                    return;
                }
                //default for comulative is أرض
                var percentged_rows =Array.from(Array(36).keys()).filter(function(i){ return i%2 ==0 && i > 0;})
                var currency_rows =[0,33,35,37]
                var area_rows =[13,36]
                choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
                    data:data,
                    columns: columns,
                    mergeCells:{
                        C36:[4,3]
                    },
                    style: {
                        A36:'background-color: #EEECE1;color:#000;',
                        B36:'background-color: #EEECE1;color:#000;',
                        A37:'background-color: #EEECE1;color:#000;',
                        B37:'background-color: #EEECE1;color:#000;',
                        A38:'background-color: #EEECE1;color:#000;',
                        B38:'background-color: #EEECE1;color:#000;',
                    },
                    onload:function(instance, cell, x, y, value) {
                        //if there is not inner span



                        percentged_rows.forEach(y => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }
                            if(y ==35 || y ==37)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }


                        })
                        area_rows.forEach((y,i) => {
                            if(i == area_rows.length -1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })
                        updateValueEqualizerTable(instance,1,37)
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }
                             if(y ==35 || y ==37)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i == area_rows.length -1)
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                                if(!$(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })
                        updateValueEqualizerTable(instance,1,37)

                    },
                    onchange:function(instance, cell, x, y, value) {
                            if(!$(`#spreadsheet${active_row}111 td[data-x="3"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="4"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="4"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}111 td[data-x="5"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}111 td[data-x="5"][data-y="14"]`).append("<span  class='ml-1'>%</span>");

                            updateValueEqualizerTable(instance,1,37)

                    }
                })
                break;
            case 'comparative_summation':
                /**
                * 112 means user select أسلوب الاول والطريقة الاولى والتفصيل الثاني الدي هو جمع
                */
                if(selected_methods.indexOf(active_row+'112') != -1) return ;
                //if it is the same row choice by checking if active_row+111 exist
                if(selected_methods.indexOf(active_row+'111') != -1 )
                {
                    $('#spreadsheet'+active_row+'111').parent().remove();
                    selected_methods = selected_methods.filter(item => item != active_row+'111')
                }
                //process if the table doesnt exist
                selected_methods.push(active_row+'112')
                $('#spreadsheet_block').append(`
                    <div>
                        <hr class="my-1">
                        <h6 >جدول طريقة المقارنة - جمع</h6>
                        <div id="spreadsheet${active_row}112"></div>
                    </div>
                `)


                // if(parseInt(active_row) ==0)
                // {
                //     // let last_row_number = $(`#spreadsheet${active_row}111  tbody tr:last-child td`).data('y');
                //       $(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(
                //         selected_method_name
                //       );

                // }else{

                    value_equalizer_table.setRowData(active_row,
                        [selected_method_name,0,0,0]
                    )
                // }
                if("{{$estate->category_id}}" == 1) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة ', '', '', '0', '0', '0'],
                            ['نوع العقار', '', "{{$estate->kind->name}}", "{{$estate->kind->name}}","{{$estate->kind->name}}", "{{$estate->kind->name}}"],
                            ['تسوية نوع العقار','', '','0','0','0'],
                            ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                            ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                            ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                            [' تسوية شروط التمويل','', '', '0', '0', '0'],
                            [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            [' تسوية شروط البيع','', '', '0', '0', '0'],
                            [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                            [' تسوية ظروف السوق','', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "{{$estate->build_size}}","{{$estate->build_size}}", "{{$estate->build_size}}"],
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D12-C12)/D12*B13 ,1)', '=ROUND((E12-C12)/E12*B13 ,1)', '=ROUND((F12-C12)/F12*B13 ,1)'],
                            ['الطابق','', '0', '0', '0', '0'],
                            ['تسوية الطابق','', '', '0', '0', '0'],
                            ['موقع العقار من المبنى','', 'أمامية', 'أمامية', 'أمامية', 'أمامية'],
                            ['تسوية موقع العقار من المبنى','', '', '0', '0', '0'],
                            ['واجهة العمارة','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                            ['تسوية واجهة العمارة','', '', '0', '0', '0'],
                            ['مستوى التشطيب','', 'فاخر',	'فاخر',	'جيد',	'فاخر'],
                            ['تسويات مستوى التشطيب','', '', '0', '0', '0'],
                            ['عمر العقار','', '0 سنة','0 سنة','0 سنة','0 سنة'],
                            ['تسوية عمر العقار','', '','','',''],
                            ['توفر موقف خاص','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر موقف خاص','', '', '0', '0', '0'],
                            ['توفر غرفة سائق','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر غرفة سائق','', '', '0', '0', '0'],
                            ['توفر سطح خاص/بلكونة','', 'لا', 'لا', 'لا', 'لا'],
                            ['تسوية توفر سطح خاص/بلكونة','', '', '0', '0', '0'],
                            ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                            ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                            ['مميزات الموقع العام','','لايوجد','0','0','0'],
                            ['تسوية مميزات العقار','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['اجمالي التسويات','', '',
                                '=ROUND(D33+D31+D29+D27+D25+D23+D21+D19+D17+D15+D13+D11+D9+D7+D5+D3 ,3)',
                                '=ROUND(E33+E31+E29+E27+E25+E23+E21+E19+E17+E15+E13+E11+E9+E7+E5+E3 ,3)',
                                '=ROUND(F33+F31+F29+F27+F25+F23+F21+F19+F17+F15+F13+F11+F9+F7+F5+F3 ,3)'],
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                                '=ROUND((1 +( D36 * 0.01)) * D1 ,3)',
                                '=ROUND((1 +( E36 * 0.01)) * E1 ,3)',
                                '=ROUND((1 + (F36 * 0.01)) * F1 ,3)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND((D38/100)*D37+(E38/100)*E37+(F38/100)*F37 ,3)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(36).keys()).filter(function(i){ return i%2 ==0 && i >1;})
                    percentged_rows = percentged_rows.concat([35,37]);
                    var currency_rows =[0,36,38]
                    var area_rows =[11]
                    choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
                        data:data,
                        columns: columns,tableOverflow: true,
                        mergeCells:{
                            B39:[2,1]
                        },
                        style: {
                            C39:'background-color: #EEECE1;color:#000;font-weight:bold',
                            D39:'background-color: #EEECE1;color:#000;font-weight:bold',
                        },
                        onload:function(instance, cell, x, y, value) {
                             //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).append("<span  class='ml-1'>%</span>");

                            percentged_rows.forEach(y => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                            updateValueEqualizerTable(instance,3,38)
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).append("<span  class='ml-1'>%</span>");

                            //if there is not inner span
                            percentged_rows.forEach(y => {

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                            //update value equalizer table
                            updateValueEqualizerTable(instance,3,38)

                        },
                        onchange:function(instance, cell, x, y, value) {
                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="12"]`).append("<span  class='ml-1'>%</span>");

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            //update جدول ترجيح
                            updateValueEqualizerTable(instance,3,38)
                        }
                    })
                    return;
                }
                if("{{$estate->category_id}}" == 2) //فيلا
                {
                    data =
                    [
                            ['قيمة الوحدة ', '', '', '0', '0', '0'],
                            ['نوع العقار', '', "{{$estate->kind->name}}", "{{$estate->kind->name}}","{{$estate->kind->name}}", "{{$estate->kind->name}}"],
                            ['تسوية نوع العقار','', '','0','0','0'],
                            ['نوع المعاملة','', 'بيع', 'بيع', 'بيع', 'عرض'],
                            ['تسوية نوع المعاملة','', '', '0', '0', '0'],
                            ['شروط التمويل','', '', '', 'نقدا', 'دفعات'],
                            [' تسوية شروط التمويل','', '', '0', '0', '0'],
                            [' شروط البيع','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            [' تسوية شروط البيع','', '', '0', '0', '0'],
                            [' ظروف السوق','تاريخ التقييم', new Date().toJSON().slice(0, 10), 'الان', 'الان', 'الان'],
                            [' تسوية ظروف السوق','', '', '0', '0', '0'],
                            [' التخطيط نظام البناء','', 'سكني', 'سكني', 'سكني', 'سكني'],
                            [' تسوية التحطيط ونظام البناء','', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة', '', "{{$estate->build_size}}", "{{$estate->build_size}}","{{$estate->build_size}}", "{{$estate->build_size}}"],
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15,1)', '=ROUND((E14-C14)/E14*B15 ,1)', '=ROUND((F14-C14)/F14*B15 ,1)'],
                            ['عدد طوابق العقار','', '0', '0', '0', '0'],
                            ['تسوية عدد طوابق العقار','', '', '0', '0', '0'],
                            ['عدد الشوارع','', '1', '0', '0', '0'],
                            ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                            ['واجهة المبنى','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                            ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                            ['مستوى التشطيب','', 'فاخر',	'فاخر',	'جيد',	'فاخر'],
                            ['تسويات مستوى التشطيب','', '', '0', '0', '0'],
                            ['عمر العقار','', '0 سنة','0 سنة','0 سنة','0 سنة'],
                            ['تسوية عمر العقار','', '','','',''],
                            ['منطقة العقار (الحي)','', "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}", "{{$estate->city->zone->name}}"],
                            ['تسوية منطقة العقار (الحي)','', '', '0', '0', '0'],
                            ['مميزات الموقع العام','','لايوجد','0','0','0'],
                            ['تسوية مميزات العقار','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],

                            ['اجمالي التسويات','', '',
                                '=ROUND(D31+D29+D27+D25+D23+D21+D19+D17+D15+D13+D11+D9+D7+D5+D3 ,3)',
                                '=ROUND(E31+E29+E27+E25+E23+E21+E19+E17+E15+E13+E11+E9+E7+E5+E3 ,3)',
                                '=ROUND(F31+F29+F27+F25+F23+F21+F19+F17+F15+F13+F11+F9+F7+F5+F3 ,3)'],
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                                '=ROUND((1 +( D32 * 0.01)) * D1 ,3)',
                                '=ROUND((1 +( E32 * 0.01)) * E1 ,3)',
                                '=ROUND((1 + (F32 * 0.01)) * F1 ,3)'
                            ],
                            ['مسبح'	,	'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية قيمة أخرى','', '', '0', '0', '0'],
                            ['اجمالي التسويات','', '',
                                '=ROUND(D39+D37+D35 ,3)',
                                '=ROUND(E39+E37+E35 ,3)',
                                '=ROUND(F39+F37+F35 ,3)',
                            ]
                            ['قيمة العقار بعد التسويات (ريال)','', '',
                                '=ROUND(D40 + D33 ,3)',
                                '=ROUND(E40 + E33 ,3)',
                                '=ROUND(F40 + F33 ,3)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND((D42/100)*D41+(E42/100)*E41+(F42/100)*F41 ,3)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i!= 32 && i >1;})
                    percentged_rows = percentged_rows.concat([35,37]);
                    var currency_rows =[0,32,34,36,38,39,40,42]
                    var area_rows =[13]
                    choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
                        data:data,
                        columns: columns,
                        tableOverflow: true,
                        mergeCells:{
                            B42:[2,1]
                        },
                        style: {
                            C42:'background-color: #EEECE1;color:#000;;font-weight:bold',
                            D42:'background-color: #EEECE1;color:#000;;font-weight:bold',
                        },
                        onload:function(instance, cell, x, y, value) {
                            //if there is not inner span

                            //تسوية المساحة نسبة مئوية
                            if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");

                            percentged_rows.forEach(y => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })

                            currency_rows.forEach((y,i) => {

                                    if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    //the last total cell has no x-4,x-5
                                    if(i != currency_rows.length-1)
                                    {
                                        if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                        if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                             updateValueEqualizerTable(instance,3,41)
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                             //تسوية المساحة نسبة مئوية
                             if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                            updateValueEqualizerTable(instance,3,41)

                        },
                        onchange:function(instance, cell, x, y, value) {
                             //تسوية المساحة نسبة مئوية
                             if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="16"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                            updateValueEqualizerTable(instance,3,41)
                        }
                    })
                    return;
                }
                //default for summation is  أرض
                var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i != 0;})
                percentged_rows = percentged_rows.concat([33,35])
                var currency_rows =[0,34,36,38]
                var area_rows =[13,19,21,37]
                choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
                    data:data,
                    columns: columns,
                    tableOverflow:true,
                    tableWidth:'950px',
                    mergeCells:{
                        C37:[4,3]
                    },
                    style: {
                        A37:'background-color: #EEECE1;color:#000;',
                        B37:'background-color: #EEECE1;color:#000;',
                        A38:'background-color: #EEECE1;color:#000;',
                        B38:'background-color: #EEECE1;color:#000;',
                        A39:'background-color: #EEECE1;color:#000;',
                        B39:'background-color: #EEECE1;color:#000;',
                    },
                    onload:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////

                        percentged_rows.forEach(y => {

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }
                            if(y ==36 || y ==38)
                            {
                                if(!$(`#spreadsheet${active_row}112  td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i ==area_rows.length -1)
                            {
                                if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })
                        updateValueEqualizerTable(instance,1,38)
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }
                            if(y ==36 || y ==38)
                            {
                                if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(i ==area_rows.length -1)
                            {
                                if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                            updateValueEqualizerTable(instance,1,38)


                    },
                    onchange:function(instance, cell, x, y, value) {
                        //////////////////////////
                        //تسوية المساحة نسبة مئوية
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="1"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                        ///////////////////////////////
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="3"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="3"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="4"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="4"][data-y="22"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`#spreadsheet${active_row}112 td[data-x="5"][data-y="22"]`).find("span").length) $(`#spreadsheet${active_row}112 td[data-x="5"][data-y="22"]`).append("<span  class='ml-1'>%</span>");

                            updateValueEqualizerTable(instance,1,38)

                    }
                })
                break;
            case 'investment_detailed':

                 /**
                * 211 means user select أسلوب الثاني والطريقة الاولى والتفصيل الاول الدي هو جمع
                */
                if(selected_methods.indexOf(active_row+'211') != -1) return ;
                //if it is the same row choice by checking if active_row+111 exist
                if(selected_methods.indexOf(active_row+'212') != -1 )
                {
                    $('#spreadsheet'+active_row+'212').parent().remove();
                    selected_methods = selected_methods.filter(item => item != active_row+'212')
                }
                //process if the table doesnt exist
                selected_methods.push(active_row+'211')
                $('#spreadsheet_block').append(`
                    <div>
                        <hr class="my-1">
                        <h6  class="d-flex justify-content-between align-items-center"><span>جدول طريقة الاستثمار - مفصل</span>
                            <button class="btn btn-sm  text-dark " style="     font-size: 13px;
                            background: #f3f3f3;
                            border: 1px solid #d4d4d4;
                            padding: 6px 1rem;margin-left: 1.5rem;" id="add_investement_row" > + سطر جديد</button>
                            </h6>
                        </h6>
                        <div id="spreadsheet${active_row}211"></div>
                    </div>
                `)
                if(parseInt(active_row) ==0)
                {
                    // let last_row_number = $(`#spreadsheet${active_row}211  tbody tr:last-child td`).data('y');
                      $(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(
                        selected_method_name
                      );

                }else{

                    value_equalizer_table.insertRow(
                        [selected_method_name,0,0,0]
                    )
                }
                data =[[1,'','','','','','','','','','','','','','','','','','','','','','','','','','']
                ,['الإجمالي',0,0,0,'',0,0,'','','','','',0,'',0,'',0,0,'','','','','','','',0,0]
                    ];
                    columns=[
                        {    type: 'text',        title:'رقم الوحدة' ,readonly:true        },
                        {    type: 'number',        title:'المساحة التأجيرية (م2)'    , mask:"0.00"       },
                        {    type: 'number',        title:'اجمالي الايجار السنوي' ,  mask:"0.00 ريال"        },
                        {    type: 'number',        title:'الايجار للمتر المربع',  mask:"0.00  ريال"             },
                        {    type: 'number',        title:'نسبةالمصاريف التشغيلية',  mask:"0.00 %"    },
                        {    type: 'number',        title:'اجمالي المصاريف التشغيلية' ,  mask:"0.00 ريال"               },
                        {    type: 'number',        title:'صافي الايجار السنوي' ,  mask:"0.00 ريال"              },
                        {    type: 'number',        title:'صافي الايجار السنوي للمتر المربع' ,  mask:"0.00 ريال"              },
                        {    type: 'calendar',        title:'تاريخ انتهاء العقد'          },
                        {    type: 'number',        title:'الفترة المتبقية لانتهاء العقد'  , mask:"0.00 سنة"       },
                        {    type: 'number',        title:'معدل العائد للأبدية قبل انتهاء العقد',     mask:"0.00%"        },
                        {    type: 'number',        title:'عامل شراء السنوات لفترة محددة',mask:'0.00'        },
                        {    type: 'text',        title:'القيمة السوقية',  mask:"0.00 ريال"  },
                        {    type: 'text',        title:'الايجار للمتر المربع بعد التجديد',  mask:"0.00 ريال"  },
                        {    type: 'text',        title:'اجمالي الايجار السنوي 2',  mask:"0.00 ريال"  },
                        {    type: 'number',        title:'نسبةالمصاريف التشغيلية2',     mask:"0.00%"        },
                        {    type: 'text',        title:'اجمالي المصاريف التشغيلية2',  mask:"0.00 ريال"  },
                        {    type: 'text',        title:'صافي الايجار السنوي2' ,  mask:"0.00 ريال"  ,decimal:','},
                        {    type: 'text',        title:'صافي الايجار السنوي للمتر المربع2',  mask:"0.00 ريال"  },
                        {    type: 'number',        title:'معدل الأشغال',    mask:"0.00%" ,       },
                        {    type: 'text',        title:'الايجار السنوي للمتر المربع',  mask:"0.00 ريال"  },
                        {    type: 'number',        title:'معدل الأشغال2',     mask:"0.00%" ,       },
                        {    type: 'text',        title:'معدل العائد للأبدية بعد تجديد العقد' ,mask:'0.00' },
                        {    type: 'text',        title:'القيمة الحالية' ,mask:'0.00' },
                      {    type: 'text',        title:'عامل سنوات الشراء للأبد' ,mask:'0.00' },
                        {    type: 'text',        title:'القيمة السوقية2' ,  mask:"0.00 ريال"  ,decimal:','},
                        {    type: 'number',        title:'اجمالي القيمة السوقية (ريال)',  mask:"0.00 ريال"        },
                    ]


                    choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'211'), {
                        data:data,
                        columns: columns,
                    //     footers: [['الإجمالي',`=SUM(B0:B${TABLE().getData().length - 1})`,`=SUM(C0:C${TABLE().getData().length - 1})`,`=SUM(D0:D${TABLE().getData().length - 1})`,'',
                    //     `=SUM(F1:F${TABLE().getData().length - 1})`,`=SUM(G1:G${TABLE().getData().length - 1})`,`=SUM(H1:H${TABLE().getData().length - 1})`,'','','','','','',
                    // `=SUM(M1:M${TABLE().getData().length - 1})`,'', `=SUM(O1:O${TABLE().getData().length - 1})`,'',`=SUM(Q1:Q${TABLE().getData().length - 1})`,`=SUM(R1:R${TABLE().getData().length - 1})`,
                    //    '','','','','','','',`=SUM(Z1:Z${TABLE().getData().length - 1})`,`=SUM(AA1:AA${TABLE().getData().length - 1})`
                    //     ]],

                        mergeCells:{
                            // B40:[2,1]
                        },
                        defaultColWidth: 200,
                        tableOverflow: true,
                        tableWidth: `950px`,
                        tableOverflow:true,
                        style: {
                            // C40:'background-color: #EEECE1;color:#000;font-weight:bold',
                            // D40:'background-color: #EEECE1;color:#000;font-weight:bold',
                        },
                        onload:function(instance, cell, x, y, value,label,cellName) {
                        //if there is not inner span
                            let id=instance.getAttribute('id')
                            let rows_count = $('#'+instance.getAttribute('id')).find('div.jexcel_content > table > tbody tr').length - 1 ;


                            // change footer background
                            $('#'+id).find('div.jexcel_content > table > tbody tr:last-child').css({'color':'#000','background-color':'#B6DDE8'})

                        },
                        oneditionend:function(instance, cell, x, y, value) {

                            let rows_count = $('#'+instance.getAttribute('id')).find('div.jexcel_content > table > tbody tr').length - 1 ;
                            let column_type =$(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${rows_count}"]`).text().split(' ')[1]

                            column_count=0;
                            for (let index = 0; index < rows_count; index++) {
                                  column_count+= ~~parseFloat( $(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${index}"]`).text())
                            }
                            $(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${rows_count}"]`).text(column_count+` ${column_type}`)
                            //from basic assumptions table
                            w_record_value = parseFloat($('#basic_assumptions_table td[data-x="1"][data-y="3"]').text())
                            l_record_value = parseFloat($('#basic_assumptions_table td[data-x="1"][data-y="2"]').text())
                            n_record_value = parseFloat($('#basic_assumptions_table td[data-x="1"][data-y="4"]').text())
                            t_record_value = parseFloat($('#basic_assumptions_table td[data-x="1"][data-y="0"]').text())
                            //from basic assumptions table

                            for (let index = 0; index <  instance.jexcel.getData().length; index++) {
                                instance.jexcel.setValue('D'+index+"",`=C${index}/B${index}`);
                                instance.jexcel.setValue('F'+index+"",`=E${index}*C${index}*0.01`);
                                instance.jexcel.setValue('G'+index+"",`=C${index}-F${index}`);
                                instance.jexcel.setValue('H'+index+"",`=G${index}/B${index}`);
                                instance.jexcel.setValue('L'+index+"",`=(1-(1/((1+${l_record_value}*0.01)^J${index})))/${l_record_value}`);
                                instance.jexcel.setValue('M'+index+"",`=L${index}*G${index}`);
                                instance.jexcel.setValue('N'+index+"",`=(1+${n_record_value}*0.01)*D${index}`);
                                instance.jexcel.setValue('O'+index+"",`=N${index}*B${index}`);
                                instance.jexcel.setValue('Q'+index+"",`=O${index}*P${index}*0.01`);
                                instance.jexcel.setValue('R'+index+"",`=O${index}-Q${index}`);
                                instance.jexcel.setValue('S'+index+"",`=R${index}/B${index}`);
                                instance.jexcel.setValue('T'+index+"",`=1-${t_record_value}*0.01`);
                                instance.jexcel.setValue('U'+index+"",`=R${index}/B${index}`);
                                instance.jexcel.setValue('W'+index+"",`=100/(${w_record_value})`);
                                instance.jexcel.setValue('X'+index+"",`=ROUND(1/((1+${w_record_value*0.01})^(J${index})),2)`);
                                instance.jexcel.setValue('Y'+index+"",`=X${index}*W${index}`);
                                instance.jexcel.setValue('Z'+index+"",`=Y${index}*V${index}*R${index}`);
                                instance.jexcel.setValue('AA'+index+"",`=Z${index}+M${index}`);
                            }
                            //تحديث عدد الوحدات في جدول الافتراضات
                            $('#basic_assumptions_table td[data-x="1"][data-y="6"]').text(parseInt(rows_count))
                            //
                            // $('#value_calculator td[data-x="1"][data-y="12"]').text( $(`#${instance.getAttribute('id')} td[data-x="26"][data-y="${rows_count}"]`).text())
                             //merge cells
                             if(x==1 && !window.localStorage.getItem('investement_methods_cell_merged'))
                            {

                                let row_number_in_selected_methods = instance.getAttribute('id').slice(11,12)
                                choosen_tables_data[parseInt(row_number_in_selected_methods)].setMerge(`H${rows_count+1}`,5,1)
                                choosen_tables_data[parseInt(row_number_in_selected_methods)].setMerge(`S${rows_count+1}`,7,1)
                                //update localstorage value
                                window.localStorage.setItem('investement_methods_cell_merged',1)
                            }

                            //setting the calculated values
                            // $(`#${instance.getAttribute('id')} td[data-x="3"][data-y="${rows_count}"]`).text(column_count+` ${column_type}`)


                        },
                        onchange:function(instance, cell, x, y, value) {

                            rows_count = $('#'+instance.getAttribute('id')).find('div.jexcel_content > table > tbody tr').length - 1 ;
                            let column_type =x==1 ? 'م2' : $(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${rows_count}"]`).text().split(' ')[1]

                            column_count=0;
                            for (let index = 0; index < rows_count; index++) {
                                  column_count+= ~~parseFloat( $(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${index}"]`).text())
                            }
                           $(`#${instance.getAttribute('id')} td[data-x="${x}"][data-y="${rows_count}"]`).text(column_count+` ${column_type}`)
                            //تحديث عدد الوحدات في جدول الافتراضات
                            $('#basic_assumptions_table td[data-x="1"][data-y="6"]').text(parseInt(rows_count))

                        }
                    })
                    var percentged_rows =[1,4,7]
                var currency_rows =[0,2,3,5,6,9]
                $('#spreadsheet'+active_row+'211').parent().append(`
                <div id="investement_method_calculator" class="d-flex justify-content-between py-2">
                    <div>
                        <h6>الافتراضات الأساسية</h6>
                        <div id="basic_assumptions_table"></div>
                    </div>
                    <div>
                        <h6  class="d-flex justify-content-between align-items-center"><span>حساب قيمة العقار</span>
                            <button class="btn btn-sm  text-dark " style="       font-size: 13px;
                        background: #00a1b5;
                        border: 1px solid #d4d4d4;
                        padding: 6px 1rem;
                        margin-left: 1.5rem;
                        color: white !important;" id="show_investement_table_result" >  عرض النتيجة</button>
                            </h6>
                        <div id="value_calculator"></div>
                    </div>
                    </div>`)
                setTimeout(() => {

                    //assumption table
                    var basic_assumptions = jspreadsheet(document.querySelector('#basic_assumptions_table'), {
                            data:[
                                ['نسبة خسائر الائتمان والأشغار',1],
                                ['نسبة  المصاريف التشغيلية من الايجار',1],
                                ['معدل العائد الى تاريخ انتهاء العقد',1],
                                ['معدل العائد عند تجديد العقد',1],
                                ['نسبة زيادة الايجار عند تجديد العقد',1],
                                ['تاريخ التقييم','Y/MM/dd'],
                                ['اجمالي عدد الوحدات في العقار',1],
                            ],
                            columns:   columns=[
                                {    type: 'text',        title:'بيان' ,width:'280px'  ,readonly:true        },
                                {    type: 'number',        title:'القيمة',width:'120px'       }
                            ],

                            mergeCells:{
                                // B40:[2,1]
                            },
                            tableWidth: `470px`,
                            tableOverflow:true,
                            allowDeleteRow:false,
                            allowInsertColumn:false,
                            allowInsertRow:false,
                            style: {
                                // C40:'background-color: #EEECE1;color:#000;font-weight:bold',
                                // D40:'background-color: #EEECE1;color:#000;font-weight:bold',
                            },
                            onload:function(instance, cell, x, y, value) {
                                Array.from(Array(5).keys()).forEach((y,i) => {
                                    if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                })
                            },
                            oneditionend:function(instance, cell, x, y, value) {
                                Array.from(Array(5).keys()).forEach((y,i) => {
                                    if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                })

                            },
                            onchange:function(instance, cell, x, y, value) {

                            }
                    })
                    //value calculator table
                    var value_calculator = jspreadsheet(document.querySelector('#value_calculator'), {
                            data:[
                                ['اجمالي المساحة التأجيرية',0],
                                ['التقييم الى نهاية العقد الحالي',0],
                                ['اجمالي الايجار السنوي',0],
                                ['متوسط الايجار للمتر المربع',0],
                                ['اجمالي المصاريف التشغيلية',0],
                                ['صافي الايجار السنوي',0],
                                ['القيمة السوقية قبل تجديد العقود',0],
                                ['التقييم عند تجديد العقد',0],
                                ['اجمالي الايجار السنوي',0],
                                ['اجمالي المصاريف التشغيلية السنوية',0],
                                ['اجمالي صافي الايجار السنوي',0],
                                ['اجمالي القيمة السوقية بعد تجديد العقود',0],
                                ['اجمالي القيمة السوقية للعقار',0],
                            ],
                            columns:   columns=[
                                {    type: 'text',        title:'البيان' ,width:'250px' ,readonly:true       },
                                {    type: 'number',        title:'المجموع',width:'120px'       }
                            ],

                            mergeCells:{
                                A2:[2,1],
                                A8:[2,1],
                            },
                            tableWidth: `450px`,
                            tableOverflow:true,
                            allowDeleteRow:false,
                            allowInsertColumn:false,
                            allowInsertRow:false,
                            style: {
                                A2:'background-color: #B6DDE8;color:#000;font-weight:bold',
                                A8:'background-color: #B6DDE8;color:#000;font-weight:bold',
                                A13:'background-color: #B6DDE8;color:#000;font-weight:bold',
                                B13:'color:#000;font-weight:bold',
                            },
                            onload:function(instance, cell, x, y, value) {
                                //set the signs
                                [2,4,5,6,8,9,10,11,12].forEach((y,i) => {
                                    if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال </span>");
                                })
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>م2 </span>");
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).append("<span  class='ml-1'>ريال.م2 </span>");

                            },
                            oneditionend:function(instance, cell, x, y, value) {

                                let items = selected_methods.filter(item=> item.substring(1,4)=='211');

                                 if ( items.length){
                                    let table_id = `#spreadsheet${items[0]}`
                                    let length = $(table_id).find('div.jexcel_content > table > tbody tr').length - 1 ;
                                    //from the investement detailied method table
                                    b_record_value = parseFloat($(`${table_id} td[data-x="1"][data-y="${length}"]`).text())
                                    c_record_value = parseFloat($(`${table_id} td[data-x="2"][data-y="${length}"]`).text())
                                    d_record_value = parseFloat($(`${table_id} td[data-x="3"][data-y="${length}"]`).text())
                                    f_record_value = parseFloat($(`${table_id} td[data-x="5"][data-y="${length}"]`).text())
                                    g_record_value = parseFloat($(`${table_id} td[data-x="6"][data-y="${length}"]`).text())
                                    m_record_value = parseFloat($(`${table_id} td[data-x="13"][data-y="${length}"]`).text())
                                    o_record_value = parseFloat($(`${table_id} td[data-x="15"][data-y="${length}"]`).text())
                                    q_record_value = parseFloat($(`${table_id} td[data-x="17"][data-y="${length}"]`).text())
                                    r_record_value = parseFloat($(`${table_id} td[data-x="18"][data-y="${length}"]`).text())
                                    z_record_value = parseFloat($(`${table_id} td[data-x="26"][data-y="${length}"]`).text())
                                    aa_record_value = parseFloat($(`${table_id} td[data-x="27"][data-y="${length}"]`).text())

                                    instance.jexcel.setValue('B1',`${b_record_value}`);
                                    instance.jexcel.setValue('B3',`${c_record_value}`);
                                    instance.jexcel.setValue('B4',`${d_record_value}`);
                                    instance.jexcel.setValue('B5',`${f_record_value}`);
                                    instance.jexcel.setValue('B6',`${g_record_value}`);
                                    instance.jexcel.setValue('B7',`${m_record_value}`);
                                    instance.jexcel.setValue('B9',`${o_record_value}`);
                                    instance.jexcel.setValue('B10',`${q_record_value}`);
                                    instance.jexcel.setValue('B11',`${r_record_value}`);
                                    instance.jexcel.setValue('B12',`${z_record_value}`);
                                    instance.jexcel.setValue('B13',`${aa_record_value}`);
                                 }
                                 //set the signs ريال والمساحة
                                 [2,4,5,6,8,9,10,11,12].forEach((y,i) => {
                                    if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال </span>");
                                })
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>م2 </span>");
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).append("<span  class='ml-1'>ريال.م2 </span>");
                                //update value equalizer table

                                value_equalizer_table.setRowData(0,
                                        [$(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(),
                                        parseFloat($(`#${instance.getAttribute('id')} td[data-x="1"][data-y="12"]`).text()),0,
                                        parseFloat($(`#${instance.getAttribute('id')} td[data-x="1"][data-y="12"]`).text())])
                            },
                            onchange:function(instance, cell, x, y, value) {
                                //set the signs ريال والمساحة
                                [2,4,5,6,8,9,10,11,12].forEach((y,i) => {
                                    if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال </span>");
                                })
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="0"]`).append("<span  class='ml-1'>م2 </span>");
                                if(!$(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).find("span").length) $(`#${instance.getAttribute('id')} td[data-x="1"][data-y="3"]`).append("<span  class='ml-1'>ريال.م2 </span>");
                                //update value equalizer table
                                value_equalizer_table.setRowData(0,
                                        [$(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(),
                                        parseFloat($(`#${instance.getAttribute('id')} td[data-x="1"][data-y="12"]`).text()),0,
                                        parseFloat($(`#${instance.getAttribute('id')} td[data-x="1"][data-y="12"]`).text())])
                            }
                    })
                    }, 3500);
                    return;
            break
            case 'investment_shortened':
                 /**
                * 212 means user select أسلوب الاول والطريقة الاولى والتفصيل الثاني الدي هو جمع
                */
                if(selected_methods.indexOf(active_row+'212') != -1) return ;
                //if it is the same row choice by checking if active_row+111 exist
                if(selected_methods.indexOf(active_row+'211') != -1 )
                {
                    $('#spreadsheet'+active_row+'211').parent().remove();
                    selected_methods = selected_methods.filter(item => item != active_row+'211')
                }
                //process if the table doesnt exist
                selected_methods.push(active_row+'212')
                $('#spreadsheet_block').append(`
                    <div>
                        <hr class="my-1">
                        <h6 >جدول طريقة الاستثمار - مختصر</h6>
                        <div id="spreadsheet${active_row}212"></div>
                    </div>
                `)
                if(parseInt(active_row) ==0)
                {
                    // let last_row_number = $(`#spreadsheet${active_row}111  tbody tr:last-child td`).data('y');
                      $(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(
                        selected_method_name
                      );

                }else{

                    value_equalizer_table.setRowData(
                        ["sddd",0,0,0]
                    )
                }
                var percentged_rows =[1,4,7]
                var currency_rows =[0,2,3,5,6,9]

                choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'+active_row+'212'), {
                        data:[
                            ['إجمالي الدخل السنوي','0'],
                            ['نسبة خسائر الائتمان والاشغار','0'],
                            ['خسائر الاشغار','=ROUND(B1*B2*0.01,0)'],
                            ['إجمالي الدخل الفعلي','=(B1 -B3)'],
                            ['نسبة المصاريف التشغيلية من اجمالي الدخل السنوي','0'],
                            ['النفقات التشغيلية','=ROUND(B5 * B4 * 0.01 ,0)'],
                            ['صافي الدخل التشغيلي NOI','=(B4-B6)'],
                            ['معدل الرسملة','0'],
                            ['معامل الشراء الى الأبد','=(1/B8) * 100'],
                            ['قيمة العقار','=ROUND(B9 * B7 , 3)'],
                        ],
                        columns:   columns=[
                            {    type: 'text',        title:'البند'         },
                            {    type: 'number',        title:'القيمة'       }
                        ],

                        mergeCells:{
                            // B40:[2,1]
                        },
                        tableWidth: `950px`,
                        tableOverflow:true,
                        defaultColWidth:'450px',
                        style: {
                            // C40:'background-color: #EEECE1;color:#000;font-weight:bold',
                            // D40:'background-color: #EEECE1;color:#000;font-weight:bold',
                        },
                        onload:function(instance, cell, x, y, value) {
                            percentged_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            })
                            currency_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            })
                             updateValueEqualizerTable(instance,1,9)
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            percentged_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            })
                            currency_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            })
                             updateValueEqualizerTable(instance,1,9)

                        },
                        onchange:function(instance, cell, x, y, value) {
                            percentged_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            })
                            currency_rows.forEach(y => {
                                if(!$(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).find("span").length) $(`#spreadsheet${active_row}212 td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            })
                             updateValueEqualizerTable(instance,1,9)
                        }
                    })
                break
            default:
            choosen_tables_data[parseInt(active_row)] =jspreadsheet(document.getElementById('spreadsheet'), {
                    data:data,
                    columns: columns,
                    mergeCells:{
                    },
                    style: {
                    },
            })
            break;
        }



//    })
    }
    $(function () {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //get saved data
        $.ajax({
                url: `{{route('getSavedTables',['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')])}}`,
                type: 'GET',
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    rating_ways_table.setData(response.rating_ways_table_data)
                    value_equalizer_table.setData(response.value_equalizer_table_data)
                    value_edit_table.setData(response.value_edit_table_data)

                    response.rating_ways_table_data.forEach((item,index)=>{
                        let concat = item.toString().replaceAll(',','')
                        switch (concat) {
                            case '111':
                                prepareSheet(1,true);
                                choosen_tables_data[index].setData(response.choosen_tables_data[index])
                                active_row++;
                                break;
                            case '112':
                                console.log('ind',index)
                                prepareSheet(2,true);
                                choosen_tables_data[index].setData(response.choosen_tables_data[index])
                                active_row++;
                                break;


                            default:
                                break;
                        }
                    })
                },
                error: function(error) {
                    // Handle an error response
                }
        });

        $('#save-copy').click(function (e) {
        e.preventDefault();
            let rating_ways_table_data = rating_ways_table.getData();
            let value_equalizer_table_data = value_equalizer_table.getData();
            let value_edit_table_data = value_edit_table.getData();
            // send ajax
            let choosen_tables_data_final = choosen_tables_data.map(item => item.getData())
            $.ajax({
                url: `{{route('save_estate_rating_tables',['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')])}}`,
                type: 'POST',
                dataType: "json",
                data: {
                    rating_ways_table_data,
                   value_equalizer_table_data,
                   value_edit_table_data,
                   choosen_tables_data:choosen_tables_data_final
                },
                success: function(response) {
                    console.log(response)
                },
                error: function(error) {
                    // Handle an error response
                }
            });

        })
        //add new row on rating_ways_table
        $(document).on('click','#add_rating_way_row',function(e){
            e.preventDefault()
           if(rating_ways_table.getData().length ==3 || selected_methods.length ==3)
           {
            alert('انتهى عدد الأسطر المحدد')
            return ;
           }
           rating_ways_table.insertRow();
        })
        $(document).on('click','#add_investement_row',function(e){
            e.preventDefault()

            selected_methods.forEach(item =>{
                new_row_number =choosen_tables_data[parseInt(item.substr(0,1))].getData().length-1;
                if(item.substring(1,4) =='211') choosen_tables_data[parseInt(item.substr(0,1))].insertRow([]
                ,new_row_number,
                new_row_number);
            })

        })
        $(document).on('click','#show_investement_table_result',function(e){
            e.preventDefault()
            let items = selected_methods.filter(item=> item.substring(1,4)=='211');

            if ( items.length){
                let table_id = `#spreadsheet${items[0]}`
                let length = $(table_id).find('div.jexcel_content > table > tbody tr').length - 1 ;
                //from the investement detailied method table
                b_record_value = parseFloat($(`${table_id} td[data-x="1"][data-y="${length}"]`).text())
                c_record_value = parseFloat($(`${table_id} td[data-x="2"][data-y="${length}"]`).text())
                d_record_value = parseFloat($(`${table_id} td[data-x="3"][data-y="${length}"]`).text())
                f_record_value = parseFloat($(`${table_id} td[data-x="5"][data-y="${length}"]`).text())
                g_record_value = parseFloat($(`${table_id} td[data-x="6"][data-y="${length}"]`).text())
                m_record_value = parseFloat($(`${table_id} td[data-x="12"][data-y="${length}"]`).text())
                o_record_value = parseFloat($(`${table_id} td[data-x="14"][data-y="${length}"]`).text())
                q_record_value = parseFloat($(`${table_id} td[data-x="16"][data-y="${length}"]`).text())
                r_record_value = parseFloat($(`${table_id} td[data-x="17"][data-y="${length}"]`).text())
                z_record_value = parseFloat($(`${table_id} td[data-x="25"][data-y="${length}"]`).text())
                aa_record_value = parseFloat($(`${table_id} td[data-x="26"][data-y="${length}"]`).text())

                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="0"]`).text(b_record_value+'م2')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="2"]`).text(c_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="3"]`).text(d_record_value+' ريال.م2 ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="4"]`).text(f_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="5"]`).text(g_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="6"]`).text(m_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="8"]`).text(o_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="9"]`).text(q_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="10"]`).text(r_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="11"]`).text(z_record_value+' ريال ')
                $(`#investement_method_calculator #value_calculator td[data-x="1"][data-y="12"]`).text(aa_record_value+' ريال ')

                //update value equalizer table
                value_equalizer_table.setRowData(0,
                                        [$(`#value_equalizer_table td[data-x="0"][data-y="0"]`).text(),
                                        parseFloat($(`#investement_method_calculator #value_calculator  td[data-x="1"][data-y="12"]`).text()),0,
                                        parseFloat($(`#investement_method_calculator #value_calculator  td[data-x="1"][data-y="12"]`).text())])
            }


        })
    })

        // function change(instance, cell, x, y, value) {
        //     console.log('x is '+x)
        //     if((x != 0) && (parseInt(x) % 2 == 0))
        //     {

        //         cellName = jspreadsheet.getColumnNameFromId([x,y]);

        //         ["D","E","F"].forEach(letter=>{
        //             compare_table.setReadOnly(`${letter+x}`,true)
        //         })
        //     }
        //             // var cellName = jspreadsheet.getColumnNameFromId([x,y]);
        //             // console.log('New change on cell ' + cellName + ' to: ' + value + '');

        //             // compare_table.updateProperty(0,0, {mask: '0.00%' });
        // }
</script>
@endsection