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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">سبب الرفض</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('level_refuse' , ['estate_id'=>$estate->id,'type'=>'rater','subdomain'=>Route::current()->parameter('subdomain')]) }}">
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
                    <h4 class="card-title"> مستندات  </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{ route('level_inputs' , ['estate_id'=>$estate->id,'type'=>auth()->user()->membership_level,'subdomain'=>Route::current()->parameter('subdomain')]) }}" id="myform"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
                            {{--<div class="form-row">--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<div class="row" id="prices">--}}
                                        {{--<div class="col-md-6 col-6 mb-3">--}}
                                            {{--<label>الاسم</label>--}}
                                            {{--<input type="text" name="infos[0][key]" class="form-control"--}}
                                                   {{--placeholder="الاسم" value="{{$estate->price}}" required>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6 col-6 mb-3">--}}
                                            {{--<label>القيمة</label>--}}
                                            {{--<input type="text" name="infos[0][value]" class="form-control"--}}
                                                   {{--placeholder="القيمة" value="{{$estate->price}}" required>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group col-md-12 col-xs-12">--}}
                                            {{--<hr>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--@error('product_price_list')--}}
                                    {{--<div class="alert" style="color:#a94442">{{ $message }}</div>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                                {{--<div class="col-md-12 col-12 mb-3">--}}
                                    {{--<button type="button" onclick="addPrice();"--}}
                                            {{--class="vendor-btn-xs industrial-area-btn btn btn-info w-100">اضافة جديد</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<hr>--}}




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
                                        <div class="form-row">
                                            <div class="col-sm-12 col-12">
                                                <label for="assessment">
                                                    اسلوب التقييم
                                                </label>
                                                <div class="form-group">
                                                    <select name="assessment" id="assessment"
                                                            class="select2 form-control" required>
                                                        <option selected hidden disabled value="">اختر اسلوب التقييم</option>
                                                        <optgroup label="- اسلوب الدخل">
                                                            <option value="investment">--- الاستثمار</option>
                                                        </optgroup>
                                                        <!--<option disabled value=""><hr> </option>-->
                                                        <optgroup label="- اسلوب التكلفة">
                                                                <optgroup label="-- طريقة الاحلال">
                                                                    <option value="land">--- ارض مخطط مطور</option>
                                                                    <option value="parking">--- مواقف سيارات</option>
                                                                    <option value="petrol">--- محطة وقود</option>
                                                                    <option value="estate">--- فيلا - عمارة</option>
                                                                    <option value="farm">--- مزرعة </option>
                                                                </optgroup>
                                                        </optgroup>

                                                    </select>
                                                </div>
                                                @error('assessment')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                    <!--                        <option value="نعم">نعم</option>-->
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
                                    <div class="mb-3 px-2 flex-column d-flex flex-md-row justify-content-between align-items-center " style="    gap: 1%;" >
                                        <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">إرسال الطلب للمراجع</button>
                                        <span class="btn btn-warning w-50 mb-1 mb-md-0 "  id="return_coordinator">إعادة الطلب للمنسق</span>
                                        <span class="btn btn-danger w-50 mb-1 mb-md-0 "  id="return_previewer">إعادة الطلب للمعاين</span>
                                    </div>
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
});
    </script>
@endsection