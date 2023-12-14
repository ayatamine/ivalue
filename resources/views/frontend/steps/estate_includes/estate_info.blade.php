<div class="container">
    <h1>عرض تفاصيل طلب التقييم</h1>

    <div class="card">
        <div class="card-body">

            <h5 class="card-title">الصورة</h5>
            <h5 class="card-text">
                <img height="80" width="80" src="{{ $estate->image_url }}">
            </h5>
            <hr>
            <div class="row m-0">
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">اسم طالب التقييم:</h5>
                    <p class="card-text col-md-6">{{ $estate->name_arabic }}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">كود التقرير:</h5>
                    <p class="card-text col-md-6">{{ $estate->id }}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">النوع</h5>
                    <p class="card-text col-md-6">{{ $estate->kind->name }}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">صاحب التقييم</h5>
                    <p class="card-text col-md-6">{{ $estate->user->name }}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">مساحة الأرض</h5>
                    <p class="card-text col-md-6">{{$estate->land_size}}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">التصنيف:</h5>
                    <p class="card-text col-md-6">{{$estate->category? $estate->category->name: 'غير محدد'}}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">مساحة المبنى:</h5>
                    <p class="card-text col-md-6">{{$estate->build_size ?? 'غير محدد'}}</p>
                </div>
                @if(auth()->user()->hasAnyRole(['previewer','rater','reviewer','approver']))
                <div class="col-md-6 row" style="padding:0.3rem">
                    @if(auth()->user()->membership_level == 'previewer')
                    <h5  class="card-title col-md-6">موعد تسليم المرحلة </h5>
                    @elseif(auth()->user()->membership_level == 'rater')
                    <h5  class="card-title col-md-6">موعد تسليم المرحلة </h5>
                    @elseif(auth()->user()->membership_level == 'reviewer')
                    <h5  class="card-title col-md-6">موعد تسليم المرحلة </h5>
                    @elseif(auth()->user()->membership_level == 'approver')
                    <h5  class="card-title col-md-6">موعد تسليم المرحلة </h5>
                    @endif

                    @if(auth()->user()->membership_level == 'previewer')
                    <p class="card-text col-md-6"> {{ $estate->perviewer_date ?: '----' }}</p>
                    @elseif(auth()->user()->membership_level == 'rater')
                    <p class="card-text col-md-6">
                        {{ $estate->rater_date ?: '----' }}
                    </p>
                    @elseif(auth()->user()->membership_level == 'reviewer')
                    <p class="card-text col-md-6">
                        {{ $estate->reviewer_date ?: '----' }}
                    </p>
                    @elseif(auth()->user()->membership_level == 'approver')
                    <p class="card-text col-md-6">
                        {{ $estate->approver_date ?: '----' }}
                    </p>

                    @endif

                </div>
                @endif
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">العمر:</h5>
                    <p class="card-text col-md-6">{{$estate->age ? $estate->age . ' سنة ' : ''}}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">وحدة القياس:</h5>
                    <p class="card-text col-md-6">{{ $estate->size_kind == 1 ? 'المتر المربع' : 'المتر المكعب'}}</p>
                </div>
                <div class="col-md-6 row" style="padding:0.3rem">
                    <h5 class="card-title col-md-6">مدر للدخل:</h5>
                    <p class="card-text col-md-6">{{ $estate->diuretic ? 'نعم' : 'لا'}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@if($estate->drafted_by)
<div class="card mt-1">
    <div class="card-body">
        <div class=" " style="padding:0.3rem">
            <h5 class="card-title  text-danger">ملاحظة (سبب الرفض):</h5>
            <p class="card-text ">{{$estate->draft_note}}</p>
        </div>
    </div>
</div>
@endif
{{-- notes from the previous step --}}
@php
    $note = null;
@endphp
@if(auth()->user()->membership_level == 'manager' || auth()->user()->hasRole('manager'))
@php
$note = \App\Models\OrderProcessingNote::whereEstateId($estate->id)->where('step_number',6)->first()
@endphp
@elseif(auth()->user()->membership_level == 'rater_manager' || auth()->user()->hasRole('rater_manager'))
@php
$note = \App\Models\OrderProcessingNote::whereEstateId($estate->id)->whereIn('step_number',[4,5,7])->first()
@endphp
@endif
@if($note)
<div class="card mt-1">
    <div class="card-body">
        <div class=" " style="padding:0.3rem">
            <h5 class="card-title  text-danger">ملاحظة :</h5>
            <p class="card-text">{{$note->note}}</p>
        </div>
    </div>
</div>
@endif
{{-- <div class="table-responsive">




    <table class="table data-thumb-view">
        <thead>
            <tr>
                <th>#</th>
                <th>#</th>
                <th>اسم طالب التقييم</th>
                <th>كود التقرير </th>
                <th>نوع </th>
                <th>صاحب </th>
                <th>مساحة الارض</th>
                <th>تصنيف </th>
                <th>مساحة المبنى</th>
                @if(auth()->user()->membership_level == 'previewer')
                <th>موعد تسليم المرحلة </th>
                @elseif(auth()->user()->membership_level == 'rater')
                <th>موعد تسليم المرحلة </th>
                @elseif(auth()->user()->membership_level == 'reviewer')
                <th>موعد تسليم المرحلة </th>
                @elseif(auth()->user()->membership_level == 'approver')
                <th>موعد تسليم المرحلة </th>
                @endif

                <th>العمر</th>
                <th>وحدة القياس</th>
                <th> مدر للدخل</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td class="product-img">
                    <img src="{{ $estate->image_url }}">
                </td>
                <td class="product-name">{{ $estate->name_arabic }}</td>
                <td>{{ $estate->id }}</td>
                <td>{{ $estate->kind->name }}</td>
                <td>{{ $estate->user->name }}</td>
                <td>{{$estate->land_size}}</td>
                <td>{{$estate->category? $estate->category->name: ''}}</td>
                <td>{{$estate->build_size}}</td>
                <td>{{$estate->age ? $estate->age . ' سنة ' : ''}}</td>

                @if(auth()->user()->membership_level == 'previewer')
                <td> {{ $estate->perviewer_date ?: '----' }}</td>
                @elseif(auth()->user()->membership_level == 'rater')
                <td>
                    {{ $estate->rater_date ?: '----' }}
                </td>
                @elseif(auth()->user()->membership_level == 'reviewer')
                <td>
                    {{ $estate->reviewer_date ?: '----' }}
                </td>
                @elseif(auth()->user()->membership_level == 'approver')
                <td>
                    {{ $estate->approver_date ?: '----' }}
                </td>

                @endif
                </td>
                <td>{{ $estate->size_kind == 1 ? 'المتر المربع' : 'المتر المكعب'}}</td>
                <td>{{ $estate->diuretic ? 'نعم' : 'لا'}}</td>
            </tr>
        </tbody>
    </table>
</div> --}}

<div class="card">
    <div class="card-header">
        معلومات الطلب الاولية
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table data-thumb-view">
                <tbody>
                    @foreach($estate->inputs as $inp)
                    <tr>
                        @if($inp->key == 'سبب التقييم')
                        <th>الغرض من التقييم</th>
                        @else
                        <th>{{ $inp->key ?: ''}}</th>
                        @endif
                        <td>

                            {{$inp->value ?: ''}}

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@if($estate->directions->count() > 0)
<div class="card">
    <div class="card-header">
        الحدود
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table data-thumb-view">
                <thead>
                    <tr style="background: #fff">
                        <th>الاتجاة</th>
                        <th>الحد</th>
                        <th>الطول</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estate->directions as $inp)
                    <tr>
                        <th>{{ $inp->direction ?: ''}}</th>
                        <td>{{$inp->limit ?: ''}}</td>
                        <td>{{$inp->length ?: ''}} متر</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@if($estate->payments->count() > 0)
<div class="card">
    <div class="card-header">
        عمليات الدفع
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table data-thumb-view">
                <tbody>
                    @foreach($estate->payments as $payment)
                    <tr style="color:{{ $payment->done == 1 ? 'green' : 'red'}}">
                        <th>{{ $payment->price ?: ''}}</th>
                        <td>{{ $payment->done == 1 ? 'تمت' : 'لم تتم'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
{{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
        {{--<div class="form-row">--}}
            {{--<div class="col-md-12">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">الموقع على الخريطة</h3>--}}
                        {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div id="map-canvas"></div>--}}
                                {{--<input type="hidden" id="lat" name="lat" value="{{ $estate->lat }}">--}}
                                {{--<input type="hidden" id="lng" name="lng" value="{{ $estate->lng }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--
                <hr>--}}
                {{--
            </div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3>وصف العقار</h3>
                {{$estate->about ?$estate->about :'لا يوجد' }}
            </div>
            <div class="col-md-6">
                <h3>العنوان تفصيليا</h3>
                {{$estate->address ?$estate->address :'لا يوجد' }}
            </div>
        </div>
    </div>
</div>
@if($estate->file_urls)
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3>مستندات العقار</h3>
                @foreach($estate->file_urls as $file_url)
                <a target="_blank" href="{{ $file_url }}">
                    <i class="fa fa-file"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif