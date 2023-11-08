@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="card-body">
        <form action="{{ route('export') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control">
            <br>
            <button class="btn btn-success">ادخال ملف المصاريف</button>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">المصاريف</h4>
                    <hr>
                    <table  class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th hidden>
                                #
                            </th>
                            <th>
                                الشهر
                            </th>
                            <th>
                                عمارة الستين
                            </th>
                            <th>
                                عمارة البوادى
                            </th>
                            <th>
                                عمارة المنجف
                            </th>
                            <th>
                                عمارة السلامة
                            </th>
                            <th>
                                عمارة قريش
                            </th>
                            <th>
                                عمارة الربوة
                            </th>
                            <th>
                                عمارة عيادة
                            </th>
                            <th>
                                مبنى  حراء
                            </th>
                            <th>
                                مبني الامير سلطان
                            </th>
                            <th>
                                مصاريف عامة
                            </th>
                            <th>
                               الاجمالي
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $months = array("يناير", "فبراير", "مارس", "ابريل", "مايو" ,"يونيو","يوليو " , "أغسطس " , "سبتمبر " , "أكتوبر " , "نوفمبر " , "ديسمبر ");
                        ?>
                        @foreach($imports as $key => $import)
                            @if($key <= 9)
                            <tr>
                                <td hidden>
                                    {{ $loop->index + 1 }}
                                </td>
                                <td>
                                   {{ $months[$loop->index] }}
                                </td>
                                <td>{{ $import['1'] }}</td>
                                <td>{{ $import['2'] }}</td>
                                <td>{{ $import['3'] }}</td>
                                <td>{{ $import['4'] }}</td>
                                <td>{{ $import['5'] }}</td>
                                <td>{{ $import['6'] }}</td>
                                <td>{{ $import['7'] }}</td>
                                <td>{{ $import['8'] }}</td>
                                <td>{{ $import['9'] }}</td>
                                <td>{{ $import['10'] }}</td>
                                <td>
                                    {{
                                     $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                    + $import['7']+ $import['8']+ $import['9']+ $import['10']
                                    }}
                                </td>
                            </tr>
                            @endif

                        @endforeach
                        <td hidden>
                            13
                        </td>
                        <td>
                            اجمالي
                        </td>
                        <td>
                            <?php
                            $sum = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum+= $value['1'];
                                }

                            }
                            echo $sum;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum1 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum1+= $value['2'];
                                }

                            }
                            echo $sum1;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum2 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum2+= $value['3'];
                                }

                            }
                            echo $sum2;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum3 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum3+= $value['4'];
                                }

                            }
                            echo $sum3;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum4 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum4+= $value['5'];
                                }

                            }
                            echo $sum4;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum5 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum5+= $value['6'];
                                }

                            }
                            echo $sum5;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum6 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum6+= $value['7'];
                                }

                            }
                            echo $sum6;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum7 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum7+= $value['8'];
                                }

                            }
                            echo $sum7;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum8 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum8+= $value['9'];
                                }

                            }
                            echo $sum8;
                            ?>
                        </td>
                        <td>
                            <?php
                            $sum9 = 0;
                            foreach(\App\Models\Export::all() as $key=>$value)
                            {
                                if($key <= 9){
                                    $sum9+= $value['10'];
                                }

                            }
                            echo $sum9;
                            ?>
                        </td>
                        <td>
                            @foreach($imports as $key=> $import)
                                @if($key == 0)
                                    <?php
                                    $import_totals = $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                        + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                    ?>
                                @endif
                                    @if($key == 1)
                                        <?php
                                        $import_totals =$import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 2)
                                        <?php
                                        $import_totals = $import_totals + $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 3)
                                        <?php
                                        $import_totals = $import_totals+  $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 4)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 5)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 6)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 7)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 8)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                                    @if($key == 9)
                                        <?php
                                        $import_totals = $import_totals+ $import['1'] + $import['2']+ $import['3']+ $import['4']+ $import['5']+ $import['6']
                                            + $import['7']+ $import['8']+ $import['9']+ $import['10'];
                                        ?>
                                    @endif
                            @endforeach
                                {{ $import_totals ?? '' }}
                        </td>
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