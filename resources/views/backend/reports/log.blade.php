@extends('backend.layout.master')
@section('backend-head')
    <style>
        .heado{
            background: #505050;color: white; display: flex;justify-content: space-between;
        }
        @media print {
            .print-hdn{
                display: none;

            }
            footer{
                display:none!important;
            }
            .heado{
                color: black; display: flex;justify-content: space-between;
            }
        }
    </style>
    @endsection
@section('backend-main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">العملية {{ $report->name }}
                    الخاصة بــ
                        العقار {{ $report->estate->name }}
                    </h4>
                    <hr>
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                        <tr>
                            <th class="heado">
                                <span>تاريخ تسجيل العملية</span>
                                <span>{{$report->created_at->format('d/m/Y')}}</span>
                            </th>
                        </tr>
                        @forelse ($audits as $audit)
                            <tr style="border: 2px solid;text-align: center">
                                <?php
                                    $time=  date('d/m/Y ---- h:i A',strtotime('+3 hour +00 minutes',strtotime($audit->created_at)));
                                ?>
                                <th style="color: #5c1623">التوقيت :  {{ $time }}</th>
                            </tr>
                            @foreach ($audit->getModified() as $attribute => $modified)
                                <tr>
                                    <th style="display: flex;justify-content: space-between;"> @lang('article.'.$audit->event.'.modified.'.$attribute, $modified)</th>
                                </tr>
                            @endforeach
                        @empty
                            <p>@lang('article.unavailable_audits')</p>
                        @endforelse
                    </table>
                    <div class="print-hdn">
                        <br>
                        <a href="{{ route('estates.show' , $report->estate->slug) }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                        <br>
                        <br>
                        <a style="width: 100%" class="btn btn-primary text-white" onClick="window.print();return false">طباعة</a>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
