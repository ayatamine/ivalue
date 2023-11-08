@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">العقارات</h4>
                    <div style="display: flex;justify-content: space-between;">
                        <a href="{{ route('estates.create') }}" class="btn btn-success mb-2">
                            <i class="mdi mdi-plus mr-2"></i>
                            اضافة جديد</a>
                        <a class="btn btn-danger mb-2  delete-all text-white" onclick="return false;"
                           delete_url="/delete_estates/"><i class="mdi mdi-trash-can-outline mr-2"></i>
                            حدف الكل
                        </a>
                    </div>
                    <hr>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>صاحب العقار</th>
                            <th>المصاريف المتوقعة</th>
                            <th>المصاريف المصروفة</th>
                            <th>فعال</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estates as $estate)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td width="100" height="100">
                                    @if(isset($estate->mainImage))
                                        <img style="width: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                                    @else
                                        <img style="width: 100%;border-radius: 10px" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                </td>
                                <td>{{ $estate->name }}</td>
                                <td>{{ $estate->user->name }}</td>
                                <td>{{ $estate->expected }} ريال </td>
                                <td>
                                    <?php
                                        $sum = 0;
                                        foreach(\App\Models\Report::where('estate_id' , $estate->id)->get() as $key=>$value)
                                        {
                                            $sum+= $value->price;
                                        }
                                        echo $sum;
                                    ?>
                                </td>
                                <td>{{ $estate->getActive() }}</td>
                                <td>
                                    <a href="{{ route('estates.edit' , $estate->slug) }}"
                                       class="mr-3 text-primary"><i class="mdi mdi-pencil font-size-18"></i></a>
                                    <a style="color: #0a83ff" href="{{ route('calendar' , $estate->slug) }}" title="عمليات خاصة بالعقار على هيئة نتيجة"
                                       class="mr-3"><i class="mdi mdi-calendar font-size-18"></i></a>
                                    <a style="color: #5c1623" href="{{ route('estate_log' , $estate->slug) }}" title="تغييرات على العقار"
                                       class="mr-3"><i class="fas fa-clipboard-list font-size-18"></i></a>
                                    <a href="{{ route('estates.show' , $estate->slug) }}"
                                       class="mr-3 text-success"><i class="mdi mdi-eye font-size-18"></i></a>
                                    <a title="" onclick="return false;" object_id="{{ $estate->id }}"
                                       delete_url="/estates/" class="text-danger remove-alert" href="#"><i
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
@endsection