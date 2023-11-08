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
                    <h4 class="card-title">عمليات الخاصة بالعقار " {{ $estate->name }} "</h4>
                    <div style="display: flex;justify-content: space-between;">
                        <a href="{{ route('infos.create') }}" class="btn btn-success mb-2">
                            <i class="mdi mdi-plus mr-2"></i>
                            اضافة جديد</a>
                    </div>
                    <hr>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>اللون</th>
                            <th>الطابق</th>
                            <th>الشقة</th>
                            <th>قيمة المبلغ</th>
                            <th>ملف مرفق</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->date }}</td>
                                <td style="background: {{ $report->color }}"></td>
                                <td>{{ $report->floor ?? '----' }}</td>
                                <td>{{ $report->flat ?? '----' }}</td>
                                <td>{{ $report->price ?? '----' }}</td>
                                <td>
                                    @if(isset($report->file))
                                        <a target="_blank" class="mt-3" alt="الملف" href="{{ asset('pictures/reports/' . $report->file->file) }}"><i class="fa fa-file"></i> </a>
                                    @else
                                        لا يوجد
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('infos.edit' , $report->slug) }}"
                                       class="mr-3 text-primary"><i class="mdi mdi-pencil font-size-18"></i></a>
                                    <a href="{{ route('infos.show' , $report->slug) }}"
                                       class="mr-3 text-success"><i class="mdi mdi-eye font-size-18"></i></a>
                                    <a style="color: #5c1623" href="{{ route('info_log' , $report->slug) }}" title="تغييرات على العملية"
                                       class="mr-3"><i class="fas fa-clipboard-list font-size-18"></i></a>
                                    <a title="" onclick="return false;" object_id="{{ $report->id }}"
                                       delete_url="/infos/" class="text-danger remove-alert" href="#"><i
                                                class="mdi mdi-trash-can font-size-18"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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