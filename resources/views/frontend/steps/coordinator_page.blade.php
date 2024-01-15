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
                            <div class="form-row">
                                <div class="row mx-0 col-12">
                                    <div class="col-md-6 pl-0">
                                        <div class="form-group">
                                            <label for="process_start_date">
                                                تاريخ بداية الطلب
                                            </label>
                                            <input placeholder="تاريخ بدايةالطلب " name="process_start_date" id="process_start_date"
                                                    class="form-control" type="datetime-local" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group">
                                            <label for="process_end_date">
                                                تاريخ إنتهاء الطلب
                                            </label>
                                            <input placeholder="تاريخ إنهاء الطلب " name="process_end_date" id="process_end_date"
                                                    class="form-control" type="datetime-local" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-12">
                                    <label for="perviewer_id">
                                        المعاين
                                    </label>
                                    <div class="form-group">
                                        <select name="perviewer_id" id="perviewer_id"
                                                class="select2 form-control" required>
                                            <option value="" disabled hidden selected>قم بإختيار المعاين</option>
                                            @foreach($previewers as $previewer)
                                                <option value="{{ $previewer->id }}">{{ $previewer->name ?: '----' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input placeholder="تاريخ التسليم للمعاين" name="perviewer_date" id="perviewer_date"
                                                class="form-control" type="date" required>

                                    </div> --}}
                                    @if($estate->previewer_reason)
                                        <textarea readonly class="form-control"> سبب الرفض : {{ $estate->previewer_reason ? $estate->previewer_reason : '' }}</textarea>
                                    @endif
                                    @error('perviewer_id')
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
                                                <option value="{{ $rater->id }}">{{ $rater->name ?: '----' }}</option>
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
                                                <option value="{{ $reviewer->id }}">{{ $reviewer->name ?: '----' }}</option>
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
                                                <option value="{{ $approver->id }}">{{ $approver->name ?: '----' }}</option>
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