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
    </style>
@endsection
@section('frontend-main')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- Data list view starts -->
        <section id="data-thumb-view" class="data-thumb-view-header">
        {{-- @include('frontend.steps.estate_includes.estate_info') --}}
            <!-- dataTable ends -->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> مدخلات المنسق </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{ route('level_inputs' , ['estate_id'=>$estate->id,'subdomain'=>Route::current()->parameter('subdomain')]) }}" id="myform"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="row mx-0 col-12">
                                <div class="col-md-6 pl-0">
                                    <div class="form-group">
                                        <label for="process_start_date">
                                            بداية معاملة التقييم
                                        </label>
                                        <input placeholder="بداية معاملة التقييم" name="process_start_date" id="process_start_date"
                                                class="form-control" type="datetime-local" required>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group">
                                        <label for="process_end_date">
                                           انتهاء المعاملة
                                        </label>
                                        <input placeholder="انتهاء المعاملة " name="process_end_date" id="process_end_date"
                                                class="form-control" type="datetime-local" required>
                                    </div>
                                </div>
                            </div>
                            <h4 class="col-sm-12 col-12">
                                المدة المستغرقة :
                                <span class="mr-2">
                                    <b class="text-danger  ml-1" id="elapsed_days">0</b> يوم ،
                                    <b class="text-danger  ml-1" id="elapsed_hours">0</b> ساعة
                                </span>
                            </h4>
                            <br>
                            <div class="form-row">
                                <div class="col-md-4 col-12 mb-3">
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
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}"  @selected($estate->city->zone->country_id == $country->id)>{{ $country->name }} </option>
*                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-12">
                                            <label for="zone_id">
                                                المنطقة
                                            </label>
                                            <div class="form-group">
                                                <select name="zone_id" id="zone_id"
                                                        class="select2 form-control">
                                                    <option selected hidden disabled value="">اختر منطقة
                                                        العقار
                                                    </option>
                                                    @foreach($zones as $zone)
                                                        <option value="{{ $zone->id }}" @selected($estate->city->zone_id ==$zone->id)>{{ $zone->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('zone_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 mb-3">
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
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" @selected($estate->city_id ==$city->id)>{{ $city->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12 mb-3">
                                    <label for="address">العنوان تفصيليا + (الحي )  </label>
                                    <input type="text" name="address"
                                                    class="form-control" id="address" placeholder=""
                                                    value="{{$estate->address}}">
                                </div> --}}
                            </div>
                            <div class="form-row">

                                <div class="col-sm-12 col-12">
                                    <label for="previewer_id">
                                        المعاين
                                    </label>
                                    <div class="form-group">
                                        <select name="previewer_id" id="previewer_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار المعاين</option>
                                            @foreach($previewers as $previewer)
                                                <option value="{{ $previewer->id }}">{{ $previewer->name ?: '----' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('previewer_reason')->whereDraftedBy(null)->wherePreviewerId($previewer->id)->count()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمعاين" name="previewer_date" id="previewer_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->previewer_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->previewer_reason ? $estate->previewer_reason : '' }}</textarea>
                                    @endif
                                    @error('previewer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <br>
                            <div class="form-row">
                                <div class="col-sm-12 col-12">
                                    <label for="rater_id">
                                        المقيم
                                    </label>
                                    <div class="form-group">
                                        <select name="rater_id" id="rater_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار المقيم</option>
                                            @foreach($raters as $rater)
                                                <option value="{{ $rater->id }}">{{ $rater->name ?: '----' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('rater_reason')->whereDraftedBy(null)->whereRaterId($rater->id)->count()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمقيم" name="rater_date" id="rater_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->rater_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->rater_reason ? $estate->rater_reason : '' }}</textarea>
                                    @endif
                                    @error('rater_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-sm-12 col-12">
                                    <label for="reviewer_id">
                                        المراجع
                                    </label>
                                    <div class="form-group">
                                        <select name="reviewer_id" id="reviewer_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار المراجع</option>
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{ $reviewer->id }}">{{ $reviewer->name ?: '----' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('reviewer_reason')->whereDraftedBy(null)->whereReviewerId($reviewer->id)->count()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمراجع" name="reviewer_date" id="reviewer_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->reviewer_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->reviewer_reason ? $estate->reviewer_reason : '' }}</textarea>
                                    @endif
                                    @error('reviewer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-sm-12 col-12">
                                    <label for="approver_id">
                                        المعتمد
                                    </label>
                                    <div class="form-group">
                                        <select name="approver_id" id="approver_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار المعتمد</option>
                                            @foreach($approvers as $approver)
                                                <option value="{{ $approver->id }}">{{ $approver->name ?: '----' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('approver_reason')->whereDraftedBy(null)->whereApproverId($approver->id)->count()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمعتمد" name="approver_date" id="approver_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->approver_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->approver_reason ? $estate->approver_reason : '' }}</textarea>
                                    @endif
                                    @error('approver_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-sm-12 col-12">
                                    <label for="value_approver_id">
                                        معتمد قيمة
                                    </label>
                                    <div class="form-group">
                                        <select name="value_approver_id" id="value_approver_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار معتمد قيمة</option>
                                            @foreach($value_approvers as $value_approver)
                                                <option value="{{ $value_approver->id }}">{{ $value_approver->name ?: '----' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('value_approver_reason')->whereDraftedBy(null)->whereValueApproverId($value_approver->id)->count()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمعتمد" name="value_approver_date" id="value_approver_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->value_approver_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->value_approver_reason ? $estate->value_approver_reason : '' }}{{'------  عدد العمليات :'.\App\Models\Estate::whereActive(1)->whereNull('value_approver_reason')->whereDraftedBy(null)->whereValueApproverId($value_approver->id)->count()}}</textarea>
                                    @endif
                                    @error('value_approver_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr id="last_hr">
                            <div class="mb-3 px-2 flex-column d-flex flex-md-row justify-content-between align-items-center " style="    gap: 1%;" >
                                <button class="btn btn-primary w-50 mb-1 mb-md-0" type="submit" id="submit_order">تحويل الطلب إلى المعاين</button>
                                <span class="btn btn-danger w-50 mb-1 mb-md-0" id="return_order">إعادة الطلب للادخال</span>
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
        $('#return_order').click(function (e) {
                e.preventDefault();

                $(this).text('انقر للتأكيد ...')
                $('#myform').append('<input type="text" class="d-none" name="return" id="order_return" value="return" >')
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
        $('#submit_order').click(function (e) {
               e.preventDefault();
               $('#order_return').remove();
               $('#reject_note').remove();
               $('#myform').submit();
        });
        $(document).on('change','#process_start_date',function(e){
            if(!$('#process_end_date').val()) return

            let endDate = $('#process_end_date').val();
            //get elapsed days and time
            var startDate = new Date($(this).val())

            var difference = Math.abs((new Date(endDate) - startDate) / 1000);
           console.log(difference);
            var seconds = Math.floor(difference);
            var minutes = Math.floor(difference / 60);
            var hours = Math.floor(minutes / 60);

            $('#elapsed_days').html(`${Math.ceil(difference / (24 *
                60 * 60))}`) ;
            $('#elapsed_hours').html(`${Math.floor(hours) % 24}`);
                // $('#elapsed_days').html(`${Math.round(((hours + 1
                //     ) * 24)- Math.floor(seconds / (24*60*
                //     60)))}`);

        })
        $(document).on('change','#process_end_date',function(e){
            if(!$('#process_end_date').val()) return

            let endDate = $('#process_end_date').val();
            //get elapsed days and time
            var startDate = new Date($(this).val())

            var difference = Math.abs((new Date(endDate) - startDate) / 1000);
           console.log(difference);
            var seconds = Math.floor(difference);
            var minutes = Math.floor(difference / 60);
            var hours = Math.floor(minutes / 60);

            $('#elapsed_days').html(`${Math.ceil(difference / (24 *
                60 * 60))}`) ;
            $('#elapsed_hours').html(`${Math.floor(hours) % 24}`);
                // $('#elapsed_days').html(`${Math.round(((hours + 1
                //     ) * 24)- Math.floor(seconds / (24*60*
                //     60)))}`);

        });
        // $(document).on('change','#country_id',function()
        // {
        //     $.ajax({
        //         url:"/zones/by-country/"+$(this).val(),
        //         method:'get',
        //         data:"_token={{csrf_token()}}",
        //         success:function(data){
        //             $('')
        //         }
        //     })
        // })
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
@endsection