@extends('backend.layout.master')
@section('backend-head')
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
                    <br>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">عمليات الخاصة بالعقار </h4>
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
                                        <th>اللون المميز</th>
                                        <th>الطابق</th>
                                        <th>الشقة</th>
                                        <th>قيمة المبلغ</th>
                                        <th>ملف مرفق</th>
                                        <th>الخيارات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($estate->reports as $report)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $report->name }}</td>
                                            <td>{{ $report->date }}</td>
                                            <td style="background: {{ $report->color }}"></td>
                                            <td>{{ $report->floor ?? '----' }}</td>
                                            <td>{{ $report->flat ?? '----' }}</td>
                                            <td>{{ $report->price ?? '----' }} ريال </td>
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
                    <a href="{{ route('estates.index') }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                </div>
            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('backend-footer')
@endsection