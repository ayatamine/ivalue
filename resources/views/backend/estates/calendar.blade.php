@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/calendar/main.min.css" rel="stylesheet" type="text/css" />
    <style>
        .fc-daygrid-block-event .fc-event-title{
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $estate->name }}</h4>
                    <hr>
                    <div style="height: 200px" class="text-center">
                        @if(isset($estate->mainImage))
                            <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                        @else
                            <img style="height: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                        @endif
                    </div>
                    <hr>
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                        <tr>
                            <th>الاسم</th>
                            <td>{{ $estate->name }}</td>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <td>
                                {{ $estate->address }}
                            </td>
                        </tr>
                        <tr>
                            <th>عدد الطوابق</th>
                            <td>{{ $estate->floors_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق في الطابق</th>
                            <td>{{ $estate->apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق الخالية</th>
                            <td>{{ $estate->empty_apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>عدد الشقق المأهولة</th>
                            <td>{{ $estate->rented_apartments_count }}</td>
                        </tr>
                        <tr>
                            <th>صاحب العقار</th>
                            <td>{{ $estate->user->name}} </td>
                        </tr>
                        <tr>
                            <th>المدينة</th>
                            <td>{{ $estate->city->name}} </td>
                        </tr>
                        <tr class="text-primary">
                            <th>المدفوعات المتوقعة</th>
                            <td>{{ $estate->expected ?? '----' }} ريال </td>
                        </tr>
                        <tr class="text-danger">
                            <th>المدفوعات التي تمت</th>
                            <td>
                                <?php
                                $sum = 0;
                                foreach(\App\Models\Report::where('estate_id' , $estate->id)->get() as $key=>$value)
                                {
                                    $sum+= $value->price;
                                }
                                echo $sum;
                                ?>
                                ريال
                            </td>
                        </tr>
                        <tr style="background: rgba(3,3,3,0.2)" class="text-success">
                            <th>الفرق بين المفدفوعات المتوقعه والتي تمت</th>
                            <td>{{ $estate->expected - $sum }} ريال </td>
                        </tr>
                    </table>

                </div>
            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('estates.index') }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/sweet-alerts.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/jszip/jszip.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/datatables.init.js"></script>
    <script src="{{ asset('backend') }}/custom-sweetalert.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>

    <script src="{{ asset('backend') }}/assets/calendar/main.min.js"></script>
    <script src="{{ asset('backend') }}/assets/calendar/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    <?php foreach ($estate->reports as $report): ?>
                    {
                        title: '<?php echo $report->name ?>',
                        start: '<?php echo $report->date ?>',
                        color: '<?php echo $report->color ?>',
                        url: '<?php echo route('infos.show' , $report->slug) ?>',
                    },
                    <?php endforeach; ?>
                ],
                eventClick: function(event) {
                    if (event.event.url) {
                        event.jsEvent.preventDefault()
                        window.open(event.event.url, "_blank");
                    }
                }
            });

            calendar.render();

            // build the locale selector's options
            calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
                var optionEl = document.createElement('option');
                optionEl.value = localeCode;
                optionEl.selected = localeCode == initialLocaleCode;
                optionEl.innerText = localeCode;
                localeSelectorEl.appendChild(optionEl);
            });

            // when the selected option changes, dynamically change the calendar option
            localeSelectorEl.addEventListener('change', function() {
                if (this.value) {
                    calendar.setOption('locale', this.value);
                }
            });

        });

    </script>
@endsection