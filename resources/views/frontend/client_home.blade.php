@extends('frontend.layout.master')
@section('frontend-head')
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/vendors-rtl.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/vendors/css/extensions/tether-theme-arrows.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/vendors/css/extensions/tether.min.css">
<link rel="stylesheet" type="text/css"
    href="{{ asset('frontend') }}/app-assets/vendors/css/extensions/shepherd-theme-default.css">
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
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/pages/dashboard-analytics.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/pages/card-analytics.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/plugins/tour/tour.css">
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/app-assets/css-rtl/custom-rtl.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style-rtl.css">
<!-- END: Custom CSS-->

<link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css" />
<style>
    .fc-daygrid-block-event .fc-event-title {
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        font-family: sans;
        color: white;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: #adb5bd;
    }

    .clock {
        color: #fff;
        font-size: 40px;
        font-family: tahoma;
        letter-spacing: 7px;
        text-align: center;
        direction: ltr;
        margin-bottom: 0.5em;
    }
</style>
@endsection
@section('frontend-main')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="{{ asset('frontend') }}/app-assets/images/elements/decore-left.png" class="img-left"
                            alt="
            card-img-left">
                        <img src="{{ asset('frontend') }}/app-assets/images/elements/decore-right.png" class="img-right"
                            alt="
            card-img-right">
                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                            <div class="avatar-content">
                                <i class="feather icon-award white font-large-1"></i>
                            </div>
                        </div>
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                        <div class="text-center">
                            <h1 class="mb-2 text-white">مرحبا بعودتك </h1>
                            <p class="m-auto w-75">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">

        </div>
        <div class="col-lg-3 col-md-3 col-12">
            <div style="padding-bottom: 10px" class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-building-o text-success font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">0</h2>
                    <p class="mb-0">عدد التقارير المنتهية</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12">
            <div style="padding-bottom: 10px" class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-building-o text-success font-medium-5"></i>
                        </div>
                    </div>
                    <?php
                            $estate = \App\Models\Estate::whereUserId(auth()->id())->count();
                            $not_estate = \App\Models\DashNotification::where('user_id' , 11)
                            ->whereIn('estate_id',\App\Models\Estate::whereUserId(auth()->id())->pluck('id'))
                            ->count();
                            $nott_estate = \App\Models\Estate::whereUserId(auth()->id())->whereNotNull('client_reason')->count();
                        ?>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $estate }}</h2>
                    <p class="mb-0">تقرير مازالت تحت المراجعة</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12">
            <div style="padding-bottom: 10px" class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-building-o text-success font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $nott_estate }}</h2>
                    <p class="mb-0">تقارير تم رفضها </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12">
            <div style="padding-bottom: 10px" class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-building-o text-success font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $not_estate }}</h2>
                    <p class="mb-0">تقارير لم يتم الاطلاع عليها بعد</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row match-height">
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>العمليات الخاصة بالعقارات</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="product-order-chart" class="mb-3"></div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">المراد دفعة</span>
                            </div>
                            <div class="product-result">
                                <span>
                                    <?php
                                        $summ = 0;
                                        foreach(\App\Models\Estate::where('user_id' , Auth::user()->id)->get() as $key=>$value)
                                        {
                                            $summ+= $value->expected;
                                        }
                                        echo $summ;
                                        ?> ريال
                                </span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">تم دفعة</span>
                            </div>
                            <div class="product-result">
                                <span>
                                    <?php
                                        $sum = 0;
                                        $user_id = Auth::user()->id;
                                        $estates = \App\Models\Estate::where('user_id' , $user_id)->active()->get();
                                        $report_ids = [];
                                        foreach ($estates as $estate){
                                            foreach ($estate->reports as $report){
                                                array_push($report_ids , $report->id);
                                            }
                                        }
                                        foreach(\App\Models\Report::whereIn('id' , $report_ids)->get() as $key=>$value)
                                        {
                                            $sum+= $value->price;
                                        }
                                        echo $sum;
                                        ?> ريال
                                </span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-75">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">لم يتم دفعة بعد</span>
                            </div>
                            <div class="product-result">
                                <span>
                                    <?php
                                        $sum = 0;
                                        $user_id = Auth::user()->id;
                                        $estates = \App\Models\Estate::where('user_id' , $user_id)->active()->get();
                                        $report_ids = [];
                                        foreach ($estates as $estate){
                                            foreach ($estate->reports as $report){
                                                array_push($report_ids , $report->id);
                                            }
                                        }
                                        foreach(\App\Models\Report::whereIn('id' , $report_ids)->get() as $key=>$value)
                                        {
                                            $sum+= $value->price;
                                        }
                                        echo $sum;
                                        ?> ريال
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">العقارات الخاصة بكـ</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive mt-1">
                        <table class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العقار</th>
                                    <th>النوع</th>
                                    <th>التصنيف</th>
                                    <th>القيمة</th>
                                    {{-- <th>صاحب العقار</th> --}}
                                    <th>زيارة/ تعديل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estates as $estate)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $estate->name }}</td>
                                    <td>{{ $estate->kind->name }}</td>
                                    <td>{{ $estate->category?->name  ?: 'لم يتم التحديد'}}</td>
                                    <td>{{ $estate->qema ?: 'لم يتم التحديد' }}</td>
                                    <td>
                                        <a href="{{ route('client.estates.edit' , $estate->id) }}">
                                            <i class="fa fa-eye text-success"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Dashboard Analytics end -->
@endsection
@section('frontend-footer')
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('frontend') }}/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('frontend') }}/app-assets/vendors/js/charts/apexcharts.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/tether.min.js"></script>
<script src="{{ asset('frontend') }}/app-assets/vendors/js/extensions/shepherd.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('frontend') }}/app-assets/js/core/app-menu.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/core/app.js"></script>
<script src="{{ asset('frontend') }}/app-assets/js/scripts/components.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->

<script src="{{ asset('frontend') }}/app-assets/js/scripts/pages/dashboard-analytics.js"></script>

<!-- END: Page JS-->

<script src="{{ asset('backend') }}/assets/calendar/main.min.js"></script>
<script src="{{ asset('backend') }}/assets/calendar/locales-all.min.js"></script>
<script>
    function showTime(){
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";
            if(h == 0){
                h = 12;
            }
            if(h > 12){
                h = h - 12;
                session = "PM";
            }
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;
            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;
            setTimeout(showTime, 1000);
        }
        showTime();
</script>
@endsection