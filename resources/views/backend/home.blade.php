@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css"/>
    <style>
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
@section('backend-main')
    <div class="row">
        <div class="col-12">
            @include('common.done')
            @include('common.errors')
        </div>
    </div>
    <!-- start page title -->
    <div class="row">

        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">لوحة التحكم الرئيسية</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"> لوحة تحكم "{{ Auth::user()->name }}"</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">اصحاب العقارات</p>
                                    <h4 class="mb-0">{{ \App\User::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-user-line font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('users.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">العقارات</p>
                                    <h4 class="mb-0">{{ \App\Models\Estate::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-store-2-line font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('estates.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">عمليات العقارات</p>
                                    <h4 class="mb-0">{{ \App\Models\Report::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-briefcase-4-line font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('estates.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">صفحات العرض لاصحاب العقارات</p>
                                    <h4 class="mb-0">{{ \App\Models\Page::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-file-2-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('pages.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">عدد شرائح السلايدر الاعلاني</p>
                                    <h4 class="mb-0">{{ \App\Models\Slider::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-image-2-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('sliders.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">المدن</p>
                                    <h4 class="mb-0">{{ \App\Models\City::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-earth-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted">
                                    <a style="width: 100%" href="{{ route('cities.index') }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <main class="container">
                        <h2>الايرادات</h2>
                        <div>
                            <canvas id="barChart"></canvas>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <main class="container">
                        <h2>المصروفات</h2>
                        <div>
                            <canvas id="barrChart"></canvas>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>فعال</th>
                            <th>عدد العقارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\User::orderBy('id','desc')->get() as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->getActive() }}</td>
                                <td>{{ $user->estates->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/calendar/main.min.js"></script>
    <script src="{{ asset('backend') }}/assets/calendar/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var initialLocaleCode = 'ar';
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                locale: initialLocaleCode,
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                        <?php foreach (\App\Models\Report::all() as $report): ?>
                    {
                        title: '<?php echo $report->name ?> / <?php echo $report->estate->name ?>',
                        start: '<?php echo $report->date ?>',
                        color: '<?php echo $report->color ?>',
                        url: '<?php echo route('infos.show', $report->slug) ?>',
                    },
                    <?php endforeach; ?>
                ],
                eventClick: function (event) {
                    if (event.event.url) {
                        event.jsEvent.preventDefault()
                        window.open(event.event.url, "_blank");
                    }
                }
            });
            calendar.render();
            // build the locale selector's options
            calendar.getAvailableLocaleCodes().forEach(function (localeCode) {
                var optionEl = document.createElement('option');
                optionEl.value = localeCode;
                optionEl.selected = localeCode == initialLocaleCode;
                optionEl.innerText = localeCode;
                localeSelectorEl.appendChild(optionEl);
            });
            // when the selected option changes, dynamically change the calendar option
            localeSelectorEl.addEventListener('change', function () {
                if (this.value) {
                    calendar.setOption('locale', this.value);
                }
            });

        });
    </script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/datatables.init.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("barChart").getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس ", "سبتمبر ", "أكتوبر ", "نوفمبر ", "ديسمبر "],
                datasets: [{
                    label: 'عمارة الستين',
                    data: [<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['1'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['2'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['3'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['4'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['5'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['6'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['7'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['8'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['9'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['10'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['11'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['12'];
                            }
                        }
                        ?>],
                    backgroundColor: "rgba(255,0,0,1)"
                }, {
                    label: 'عمارة البوادى',
                    data: [<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['1'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['2'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['3'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['4'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['5'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['6'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['7'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['8'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['9'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['10'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['11'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Import::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['12'];
                            }
                        }
                        ?>],
                    backgroundColor: "rgba(0,0,255,1)"
                },
                    {
                        label: 'عمارة المنجف\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 99, 71)"
                    },
                    {
                        label: 'عمارة السلامة\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 207, 71)"
                    },
                    {
                        label: 'عمارة قريش\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 207, 185)"
                    },
                    {
                        label: 'عمارة الربوة\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(129, 207, 185)"
                    },
                    {
                        label: ' عمارة عيادة\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(16, 218, 11)"
                    },
                    {
                        label: '  مبنى  حراء\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(106, 90, 205)"
                    },
                    {
                        label: 'محلات السبعين\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(238, 130, 238)"
                    },
                    {
                        label: 'محلات الشمال\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 165, 0)"
                    },
                    {
                        label: 'بسطات الشامل\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 10) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(16, 110, 93)"
                    },
                    {
                        label: 'مبني الامير سلطان\n',
                        data: [<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Import::all() as $key => $import) {
                                if ($key == 11) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 110, 93)"
                    },
                ]
            }
        });
    </script>
    <script>
        var ctx = document.getElementById("barrChart").getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس ", "سبتمبر ", "أكتوبر ", "نوفمبر ", "ديسمبر "],
                datasets: [{
                    label: 'عمارة الستين',
                    data: [<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['1'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['2'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['3'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['4'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['5'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['6'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['7'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['8'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['9'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['10'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['11'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 0) {
                                echo $import['12'];
                            }
                        }
                        ?>],
                    backgroundColor: "rgba(255,0,0,1)"
                }, {
                    label: 'عمارة البوادى',
                    data: [<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['1'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['2'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['3'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['4'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['5'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['6'];
                            }
                        }
                        ?>, <?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['7'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['8'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['9'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['10'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['11'];
                            }
                        }
                        ?>,<?php
                        foreach (\App\Models\Export::all() as $key => $import) {
                            if ($key == 1) {
                                echo $import['12'];
                            }
                        }
                        ?>],
                    backgroundColor: "rgba(0,0,255,1)"
                },
                    {
                        label: 'عمارة المنجف\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 2) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 99, 71)"
                    },
                    {
                        label: 'عمارة السلامة\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 3) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 207, 71)"
                    },
                    {
                        label: 'عمارة قريش\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 4) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 207, 185)"
                    },
                    {
                        label: 'عمارة الربوة\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 5) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(129, 207, 185)"
                    },
                    {
                        label: ' عمارة عيادة\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 6) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(16, 218, 11)"
                    },
                    {
                        label: '  مبنى  حراء\n',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 7) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(106, 90, 205)"
                    },
                    {
                        label: 'الأمير سلطان',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 8) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(238, 130, 238)"
                    },
                    {
                        label: 'مصاريف عامة',
                        data: [<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['1'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['2'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['3'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['4'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['5'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['6'];
                                }
                            }
                            ?>, <?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['7'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['8'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['9'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['10'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['11'];
                                }
                            }
                            ?>,<?php
                            foreach (\App\Models\Export::all() as $key => $import) {
                                if ($key == 9) {
                                    echo $import['12'];
                                }
                            }
                            ?>],
                        backgroundColor: "rgb(255, 165, 0)"
                    },
                ]
            }
        });
    </script>
@endsection