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
                            <h6>جدول طرق التقييم</h6>
                            <div id="rating_ways_table"></div>
                        </div>
                        <div id="spreadsheet_block">

                        </div>
                        <div id="spreadsheet"></div>

                        <div id="value_equalizer_block" style="display: none">
                            <hr>
                            <h6>جدول ترجيح القيمة</h6>
                            <div id="value_equalizer_table"></div>
                        </div>
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
    var value_equalizer = [['','قيمة العقار بعد الترجيح','0','']];
    var selected_methods=[]
    var  active_row = 0;
    var sheets = [ ];



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
    function prepareSheet(value,isDetailed){
    // $(document).on('change','#market_way',function(){
        // selected_ways.push(
        //     [
        //         "أسلوب السوق",$(this).find("option:selected").text(),""
        //     ]
        // )
        value_equalizer =  value_equalizer.slice(0,-1);
        value_equalizer.push(
            [
                $(this).find("option:selected").text(),"0","0","0"
            ],
            ['','قيمة العقار بعد الترجيح','0','']
        )

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
                                ['تسوية المساحة بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '=ROUND((D22/D14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1 ,2)', '=ROUND((E22/E14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)', '=ROUND((F22/F14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)'],
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
                                "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*(3+D5*0.01)*(1+D3*0.01)*D1,2)",
                                "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*(1+E3*0.01)*E1,2)",
                                "=ROUND((1+F33*0.01)*(1+F31*0.01)*(1+F29*0.01)*(1+F27*0.01)*(1+F25*0.01)*(1+F23*0.01)*(1+F21*0.01)*(1+F19*0.01)*(1+F17*0.01)*(1+F15*0.01)*(1+F13*0.01)*(1+F11*0.01)*(1+F9*0.01)*(1+F7*0.01)*(1+F5*0.01)*(1+F3*0.01)*F1,2"
                                ],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND(D35/100*D34+E35/100*E34+F35/100*F34,2)', '', '', '', ''],
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
                                [' تسوية التخطيط نظام البناء','', '', '0', '0', '0'],
                                ['المساحة (م2)','', "{{$estate->land_size}}", '0', '0', '0'],
                                ['تسوية المساحة بطريقة الامثال','5,00', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '=ROUND((D22/D14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1 ,2)', '=ROUND((E22/E14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)', '=ROUND((F22/F14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)'],
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
                                '=ROUND(D33*0.01+D31*0.01+D29*0.01+D27*0.01+D25*0.01+D23*0.01+D21*0.01+D19*0.01+D17*0.01+D15*0.01+D13*0.01+D11*0.01+D9*0.01+D7*0.01+D5*0.01+D3 ,2)',
                                '=ROUND(E33*0.01+E31*0.01+E29*0.01+E27*0.01+E25*0.01+E23*0.01+E21*0.01+E19*0.01+E17*0.01+E15*0.01+E13*0.01+E11*0.01+E9*0.01+E7*0.01+E5*0.01+E3 ,2)',
                                '=ROUND(F33*0.01+F31*0.01+F29*0.01+F27*0.01+F25*0.01+F23*0.01+F21*0.01+F19*0.01+F17*0.01+F15*0.01+F13*0.01+F11*0.01+F9*0.01+F7*0.01+F5*0.01+F3 ,2)'],
                                ['سعر المتر بعد تسويات خصائص العقار (ريال)','', '', "=(1+D34*0.01)*D1",
                                "=(1+E34*0.01)*E1",
                                "=(1+F34*0.01)*F1",],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND(D35/100*D34+E35/100*E34+F35/100*F34,2)', '', '', '', ''],
                                ['مساحة الأرض (م2)',"{{$estate->land_size}}", '', '', '', ''],
                                ['قيمة الأرض (ريال)','=ROUND(B37*B38,2)', '', '', '', ''],
                        ];
                    handleSheet('comparative_summation',columns,data);
                    break;
                case 3://مفصل استثمار
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
                                ['تسوية المساحة بطريقة الامثال','5,00', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '=ROUND((D22/D14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1 ,2)', '=ROUND((E22/E14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)', '=ROUND((F22/F14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)'],
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
                                '=ROUND(D33*0.01+D31*0.01+D29*0.01+D27*0.01+D25*0.01+D23*0.01+D21*0.01+D19*0.01+D17*0.01+D15*0.01+D13*0.01+D11*0.01+D9*0.01+D7*0.01+D5*0.01+D3 ,2)',
                                '=ROUND(E33*0.01+E31*0.01+E29*0.01+E27*0.01+E25*0.01+E23*0.01+E21*0.01+E19*0.01+E17*0.01+E15*0.01+E13*0.01+E11*0.01+E9*0.01+E7*0.01+E5*0.01+E3 ,2)',
                                '=ROUND(F33*0.01+F31*0.01+F29*0.01+F27*0.01+F25*0.01+F23*0.01+F21*0.01+F19*0.01+F17*0.01+F15*0.01+F13*0.01+F11*0.01+F9*0.01+F7*0.01+F5*0.01+F3 ,2)'],
                                ['سعر المتر بعد تسويات خصائص العقار (ريال)','', '', "=(1+D34*0.01)*D1",
                                "=(1+E34*0.01)*E1",
                                "=(1+F34*0.01)*F1",],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND(D35/100*D34+E35/100*E34+F35/100*F34,2)', '', '', '', ''],
                                ['مساحة الأرض (م2)',"{{$estate->land_size}}", '', '', '', ''],
                                ['قيمة الأرض (ريال)','=ROUND(B37*B38,2)', '', '', '', ''],
                        ];
                    handleSheet('investment_detailed',columns,data);
                    break;
                case 4://مختصر استثمار
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
                                ['تسوية المساحة بطريقة الامثال','5,00', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
                                ['عددالشوارع','', '2', '0', '0', '0'],
                                ['تسوية عدد الشوارع','', '', '0', '0', '0'],
                                ['واجهات الشوارع','', 'شمالي', 'شمالي', 'شمالي', 'شمالي'],
                                ['تسوية واجهات الشوارع','', '', '0', '0', '0'],
                                ['عرض الشارع الرئيس','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الشارع الرئيسي','', '', '0', '0', '0'],
                                ['عرض الواجهة الرئيسية','', '0', '0,0', '0,0', '0,0'],
                                ['تسوية عرض الواجهة الرئيسية مقارنة بالعمق','5', '',
                                '=ROUND((D22/D14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1 ,2)', '=ROUND((E22/E14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)', '=ROUND((F22/F14*100*B23*0.01-(C22/C14*100*B23*0.01))*-1  ,2)'],
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
                                '=ROUND(D33*0.01+D31*0.01+D29*0.01+D27*0.01+D25*0.01+D23*0.01+D21*0.01+D19*0.01+D17*0.01+D15*0.01+D13*0.01+D11*0.01+D9*0.01+D7*0.01+D5*0.01+D3 ,2)',
                                '=ROUND(E33*0.01+E31*0.01+E29*0.01+E27*0.01+E25*0.01+E23*0.01+E21*0.01+E19*0.01+E17*0.01+E15*0.01+E13*0.01+E11*0.01+E9*0.01+E7*0.01+E5*0.01+E3 ,2)',
                                '=ROUND(F33*0.01+F31*0.01+F29*0.01+F27*0.01+F25*0.01+F23*0.01+F21*0.01+F19*0.01+F17*0.01+F15*0.01+F13*0.01+F11*0.01+F9*0.01+F7*0.01+F5*0.01+F3 ,2)'],
                                ['سعر المتر بعد تسويات خصائص العقار (ريال)','', '', "=(1+D34*0.01)*D1",
                                "=(1+E34*0.01)*E1",
                                "=(1+F34*0.01)*F1",],
                                ['نسب الترجيح','', '', '0', '0', '0'],
                                ['سعر المتر المربع بعد الترجيح (ريال)','=ROUND(D35/100*D34+E35/100*E34+F35/100*F34,2)', '', '', '', ''],
                                ['مساحة الأرض (م2)',"{{$estate->land_size}}", '', '', '', ''],
                                ['قيمة الأرض (ريال)','=ROUND(B37*B38,2)', '', '', '', ''],
                        ];
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
   function handleSheet(type,columns,data)
   {
        $('#value_equalizer_block').css('display','block')

        //value_equalizer_table
        if($('#value_equalizer_table').html() == '')
        {
        var value_equalizer_table =jspreadsheet(document.getElementById('value_equalizer_table'), {
                data:value_equalizer,
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
                            // mask:"0.00",
                            // decimal:',',
                            width:200,
                            // readOnly:true,
                    },
                    {
                            type: 'numeric',
                            title:'نسبةالترجيح',
                            mask:"0.00%",
                            decimal:',',
                            width:200
                    },
                    {
                            type: 'numeric',
                            title:'الوزن',
                            mask:"0.00",
                            decimal:',',
                            width:200
                    }
                ],
                mergeCells:{
                },
                style: {
                },
        })
        }

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
                if("{{$estate->category_id}}" == 1) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة المباني','', '', '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
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
                            "=ROUND((1+D37*0.01)*(1+D35*0.01)*(1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND(D39*D38+E39*E38+F39*F38 ,2)','', ''],
                    ];

                    var percentged_rows =Array.from(Array(38).keys()).filter(function(i){ return i%2 ==0 && i > 2;})
                    var currency_rows =[0,2,37,39]
                    var area_rows =[1,13]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
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
                        //if there is not inner span



                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })

                    },
                    onchange:function(instance, cell, x, y, value) {
                        if(!$(`td[data-x="3"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`td[data-x="4"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                        if(!$(`td[data-x="5"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");

                    }
                })
                return;
                }
                if("{{$estate->category_id}}" == 2) //فيلا
                {

                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة العقار لمساحة الأرض','', '', '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة الأرض بطريقة الامثال','5', '','=ROUND((D16-C16)/D16*B17 ,2)', '=ROUND((E16-C16)/E16*B17 ,2)', '=ROUND((F16-C16)/F16*B17 ,2)'],
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
                            "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            ],
                            ['مسبح'	,	'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'','لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', '0', '0', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            '=ROUND(D34+D36*0.01+D38*0.01+D40*0.01,2)',
                            '=ROUND(E34+E36*0.01+E38*0.01+E40*0.01,2)',
                            '=ROUND(F34+F36*0.01+F38*0.01+F40*0.01,2)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح','','=ROUND(D42*D41+E42*E41+F42*F41 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i > 2;})
                    percentged_rows = percentged_rows.concat([35,37,39,41]);
                    var currency_rows =[0,2,33,40,42]
                    var area_rows =[1,15]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
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



                            percentged_rows.forEach(y => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })

                        },
                        onchange:function(instance, cell, x, y, value) {
                            if(!$(`td[data-x="3"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                        }
                    })
                    return;
                }
                //default for comulative is أرض
                var percentged_rows =Array.from(Array(36).keys()).filter(function(i){ return i%2 ==0 && i != 0;})
                var currency_rows =[0,33,35,37]
                var area_rows =[13,36]
                var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'111'), {
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

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i == area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i == area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })

                    },
                    onchange:function(instance, cell, x, y, value) {
                            if(!$(`td[data-x="3"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="14"]`).find("span").length) $(`td[data-x="3"][data-y="14"]`).append("<span  class='ml-1'>%</span>");

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
                if("{{$estate->category_id}}" == 1) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة المباني','', '', '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
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
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                            "=ROUND((1+D37*0.01)*(1+D35*0.01)*(1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND(D39/100*D38+E39/100*E38+F39*F38 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(40).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    var currency_rows =[0,2,37,39]
                    var area_rows =[1,13]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
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
                        //if there is not inner span



                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })

                    }
                    })
                    return;
                }
                if("{{$estate->category_id}}" == 2) //فيلا
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة العقار لمساحة الأرض','', '',, '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة الأرض بطريقة الامثال','5', '', '=ROUND((D16-C16)/D16*B17 ,2)', '=ROUND((E-C16)/E*B17 ,2)', '=ROUND((F16-C16)/F16*B17 ,2)'],
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
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            ],
                            ['مسبح'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            '=ROUND(D34+D36*0.01+D38*0.01+D40*0.01,2)',
                            '=ROUND(E34+E36*0.01+E38*0.01+E40*0.01,2)',
                            '=ROUND(F34+F36*0.01+F38*0.01+F40*0.01,2)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح','','=ROUND(D42/100*D41+E42/100*E41+F42/100*F41 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    percentged_rows = percentged_rows.concat([35,37,39,41]);
                    var currency_rows =[0,2,33,40,42]
                    var area_rows =[1,15]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
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



                            percentged_rows.forEach(y => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })

                        },
                        onchange:function(instance, cell, x, y, value) {
                            if(!$(`td[data-x="3"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                        }
                    })
                    return;
                }
                //default for summation is  أرض
                var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i != 0;})
                percentged_rows = percentged_rows.concat([33,35])
                var currency_rows =[0,34,36,38]
                var area_rows =[13,19,21,37]
                var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'112'), {
                    data:data,
                    columns: columns,
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


                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })

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
                        <h6 >جدول طريقة الاستثمار - مفصل</h6>
                        <div id="spreadsheet${active_row}211"></div>
                    </div>
                `)
                if("{{$estate->category_id}}" == 1) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة المباني','', '', '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
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
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                            "=ROUND((1+D37*0.01)*(1+D35*0.01)*(1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND(D39/100*D38+E39/100*E38+F39*F38 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(40).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    var currency_rows =[0,2,37,39]
                    var area_rows =[1,13]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'211'), {
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
                        //if there is not inner span



                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })

                    }
                    })
                    return;
                }
                if("{{$estate->category_id}}" == 2) //فيلا
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة العقار لمساحة الأرض','', '',, '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة الأرض بطريقة الامثال','5', '', '=ROUND((D16-C16)/D16*B17 ,2)', '=ROUND((E-C16)/E*B17 ,2)', '=ROUND((F16-C16)/F16*B17 ,2)'],
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
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            ],
                            ['مسبح'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            '=ROUND(D34+D36*0.01+D38*0.01+D40*0.01,2)',
                            '=ROUND(E34+E36*0.01+E38*0.01+E40*0.01,2)',
                            '=ROUND(F34+F36*0.01+F38*0.01+F40*0.01,2)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح','','=ROUND(D42/100*D41+E42/100*E41+F42/100*F41 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    percentged_rows = percentged_rows.concat([35,37,39,41]);
                    var currency_rows =[0,2,33,40,42]
                    var area_rows =[1,15]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'211'), {
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



                            percentged_rows.forEach(y => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })

                        },
                        onchange:function(instance, cell, x, y, value) {
                            if(!$(`td[data-x="3"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                        }
                    })
                    return;
                }
                //default for summation is  أرض
                var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i != 0;})
                percentged_rows = percentged_rows.concat([33,35])
                var currency_rows =[0,34,36,38]
                var area_rows =[13,19,21,37]
                var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'211'), {
                    data:data,
                    columns: columns,
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


                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })

                    }
                })
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
                if("{{$estate->category_id}}" == 1) //شقة
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة المباني (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة المباني','', '', '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة المباني بطريقة الامثال','5', '', '=ROUND((D14-C14)/D14*B15 ,2)', '=ROUND((E14-C14)/E14*B15 ,2)', '=ROUND((F14-C14)/F14*B15 ,2)'],
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
                            ['قيمة العقار بعد تسوية خصائص العقار (ريال)','', '',
                            "=ROUND((1+D37*0.01)*(1+D35*0.01)*(1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            "=ROUND((1+E37*0.01)*(1+E35*0.01)*(1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3 ,2)",
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح (ريال)','','=ROUND(D39/100*D38+E39/100*E38+F39*F38 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(40).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    var currency_rows =[0,2,37,39]
                    var area_rows =[1,13]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'212'), {
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
                        //if there is not inner span



                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if(i != currency_rows.length-1)
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                        })

                    }
                    })
                    return;
                }
                if("{{$estate->category_id}}" == 2) //فيلا
                {
                    data =
                    [
                            ['قيمة الوحدة (ريال)', '', '', '0', '0', '0'],
                            ['مساحة الأرض للوحدة (م2)', '', "{{$estate->build_size}}", "","", ""],
                            ['تسوية قيمة العقار لمساحة الأرض','', '',, '=ROUND(D1/D2*C2 , 2)', '=ROUND(E1/E2*C2 , 2)', '=ROUND(F1/F2*C2 , 2)'],
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
                            ['تسوية مساحة الأرض بطريقة الامثال','5', '', '=ROUND((D16-C16)/D16*B17 ,2)', '=ROUND((E-C16)/E*B17 ,2)', '=ROUND((F16-C16)/F16*B17 ,2)'],
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
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            "=ROUND((1+D33*0.01)*(1+D31*0.01)*(1+D29*0.01)*(1+D27*0.01)*(1+D25*0.01)*(1+D23*0.01)*(1+D21*0.01)*(1+D19*0.01)*(1+D17*0.01)*(1+D15*0.01)*(1+D13*0.01)*(1+D11*0.01)*(1+D9*0.01)*(1+D7*0.01)*(1+D5*0.01)*D3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            "=ROUND((1+E33*0.01)*(1+E31*0.01)*(1+E29*0.01)*(1+E27*0.01)*(1+E25*0.01)*(1+E23*0.01)*(1+E21*0.01)*(1+E19*0.01)*(1+E17*0.01)*(1+E15*0.01)*(1+E13*0.01)*(1+E11*0.01)*(1+E9*0.01)*(1+E7*0.01)*(1+E5*0.01)*E3,2)",
                            ],
                            ['مسبح'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المسبح','', '', '0', '0', '0'],
                            ['مصعد'	,'',	'لا','لا',	'لا',	'لا'],
                            ['تسوية قيمة المصعد','', '', '0', '0', '0'],
                            ['أخرى ...','', 'لايوجد', 'لايوجد', 'لايوجد', 'لايوجد'],
                            ['تسوية أخرى','', '', '0', '0', '0'],
                            ['قيمة العقار بعد تسوية خصائص العقار','', '',
                            '=ROUND(D34+D36*0.01+D38*0.01+D40*0.01,2)',
                            '=ROUND(E34+E36*0.01+E38*0.01+E40*0.01,2)',
                            '=ROUND(F34+F36*0.01+F38*0.01+F40*0.01,2)'
                            ],
                            ['نسب الترجيح','', '', '0', '0', '0'],
                            ['','قيمة العقار بعد الترجيح','','=ROUND(D42/100*D41+E42/100*E41+F42/100*F41 ,2)','', ''],
                    ];
                    var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i >2;})
                    percentged_rows = percentged_rows.concat([35,37,39,41]);
                    var currency_rows =[0,2,33,40,42]
                    var area_rows =[1,15]
                    var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'212'), {
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



                            percentged_rows.forEach(y => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            })
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })
                        },
                        oneditionend:function(instance, cell, x, y, value) {
                            //if there is not inner span
                            if(percentged_rows.indexOf(y) != -1)
                            {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                            }
                            currency_rows.forEach((y,i) => {

                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                //the last total cell has no x-4,x-5
                                if(i != currency_rows.length-1)
                                {
                                    if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                    if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                }

                            })
                            area_rows.forEach((y,i) => {

                                if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");

                            })

                        },
                        onchange:function(instance, cell, x, y, value) {
                            if(!$(`td[data-x="3"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="16"]`).find("span").length) $(`td[data-x="3"][data-y="16"]`).append("<span  class='ml-1'>%</span>");

                        }
                    })
                    return;
                }
                //default for summation is  أرض
                var percentged_rows =Array.from(Array(34).keys()).filter(function(i){ return i%2 ==0 && i != 0;})
                percentged_rows = percentged_rows.concat([33,35])
                var currency_rows =[0,34,36,38]
                var area_rows =[13,19,21,37]
                var compare_table =jspreadsheet(document.getElementById('spreadsheet'+active_row+'212'), {
                    data:data,
                    columns: columns,
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


                        percentged_rows.forEach(y => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        })
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {
                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                        })
                    },
                    oneditionend:function(instance, cell, x, y, value) {
                        //if there is not inner span
                        if(percentged_rows.indexOf(y) != -1)
                        {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>%</span>");

                        }
                        currency_rows.forEach((y,i) => {

                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            //the last total cell has no x-4,x-5
                            if((i != currency_rows.length-1) && (i != currency_rows.length-2))
                            {
                                if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }else{//second
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                                // if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>ريال</span>");
                            }

                        })
                        area_rows.forEach((y,i) => {

                            if(i ==area_rows.length -1)
                            {
                                if(!$(`td[data-x="1"][data-y="${y}"]`).find("span").length) $(`td[data-x="1"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }
                            else
                            {
                            if(!$(`td[data-x="2"][data-y="${y}"]`).find("span").length) $(`td[data-x="2"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="3"][data-y="${y}"]`).find("span").length) $(`td[data-x="3"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="4"][data-y="${y}"]`).find("span").length) $(`td[data-x="4"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            if(!$(`td[data-x="5"][data-y="${y}"]`).find("span").length) $(`td[data-x="5"][data-y="${y}"]`).append("<span  class='ml-1'>م2</span>");
                            }

                        })

                    }
                })
                break
            default:
            var compare_table =jspreadsheet(document.getElementById('spreadsheet'), {
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