@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">تعديل العقار " {{ $estate->name}} "</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('estates.update' , $estate->id) }}" class="needs-validation"
                          novalidate enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom01">اسم العقار</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="اسم العقار" value="{{ $estate->name }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">عنوان العقار</label>
                                    <textarea type="text" name="address" class="form-control" id="address" placeholder="عنوان العقار" required>{{ $estate->address }}</textarea>
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="floors_count">عدد الطوابق</label>
                                    <input type="number" name="floors_count" class="form-control" id="floors_count" value="{{ $estate->floors_count }}" placeholder="عدد الطوابق" required>
                                    @error('floors_count')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="floors_count">عدد الشقق  في الطابق</label>
                                    <input type="number" name="apartments_count" class="form-control" id="apartments_count" value="{{ $estate->apartments_count }}" placeholder="عدد الشقق في الطابق" required>
                                    @error('apartments_count')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rented_apartments_count">عدد الشقق المأهولة</label>
                                    <input type="number" name="rented_apartments_count" class="form-control" id="rented_apartments_count" value="{{ $estate->rented_apartments_count }}" placeholder="عدد الشقق المأهولة" required>
                                    @error('rented_apartments_count')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empty_apartments_count">عدد الشقق الخالية</label>
                                    <input type="number" name="empty_apartments_count" class="form-control" id="empty_apartments_count" value="{{ $estate->empty_apartments_count }}" placeholder="عدد الشقق الخالية" required>
                                    @error('empty_apartments_count')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected">الواردات المتوقعة للعقار</label>
                                    <input type="number" name="expected" class="form-control" id="expected" value="{{ $estate->expected }}" placeholder="الواردات المتوقعة للعقار" required> ريال
                                    @error('expected')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{--<div class="col-12">--}}
                            {{--<hr>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="paid">ما تم دفعة ( في الشهر - اختياري )</label>--}}
                                    {{--<input type="number" name="paid" class="form-control" id="paid" value="{{ $estate->paid }}" placeholder="ما تم دفعة ( في الشهر )" required>--}}
                                    {{--@error('paid')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="unpaid">ما لم يتم دفعة ( في الشهر - اختياري )</label>--}}
                                    {{--<input type="number" name="unpaid" class="form-control" id="unpaid" value="{{ $estate->unpaid }}" placeholder="ما لم يتم دفعة ( في الشهر )" required>--}}
                                    {{--@error('unpaid')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="imports">الواردات ( في الشهر - اختياري )</label>--}}
                                    {{--<input type="number" name="imports" class="form-control" id="imports" value="{{ $estate->imports }}" placeholder="الواردات ( في الشهر )" required>--}}
                                    {{--@error('imports')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="exports">الصادرات ( في الشهر - اختياري )</label>--}}
                                    {{--<input type="number" name="exports" class="form-control" id="exports" value="{{ $estate->exports }}" placeholder="الصادرات ( في الشهر )" required>--}}
                                    {{--@error('exports')--}}
                                    {{--<span class="text-danger">{{ $message }}</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12">--}}
                            {{--<hr>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom03">المدينة</label>
                                    <select name="city_id" class="form-control select2" id="validationCustom03" required>
                                        @foreach($cities as $city)
                                            <option @if($estate->city_id == $city->id) selected @endif  value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom03">صاحب العقار</label>
                                    <select name="user_id" class="form-control select2" id="validationCustom03" required>
                                        @foreach($users as $user)
                                            <option @if($estate->user_id == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="image">صورة البناية</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile" onchange="readURL(this);">
                                    <label class="custom-file-label" for="customFile">الصورة</label>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    @if(isset($estate->mainImage))
                                        <img id="blah" class="mt-3" alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                                    @else
                                        <img id="blah" class="mt-3" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" @if($estate->active == 1) checked="" @endif name="active" value="1" class="custom-control-input" id="customCheck1" >
                                    <label class="custom-control-label" for="customCheck1">فعال</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">حفظ</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-advanced.init.js"></script>
@endsection
