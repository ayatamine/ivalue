@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">تعديل العملية " {{ $report->name}} "</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('infos.update' , $report->id) }}" class="needs-validation"
                          novalidate enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_id">المستخدم صاحب العقار</label>
                                    <select name="user_id" class="form-control select2" id="user_id"
                                            required>
                                        @foreach($users as $user)
                                            <option
                                                    @if($user->id == $report->user_id) selected @endif
                                            value="{{ $user->id }}">{{ $user->name }}</option>
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
                                <div class="form-group">
                                    <label for="estate_id">العقار</label>
                                    <select name="estate_id" class="form-control select2" id="estate_id"
                                            required>
                                        @foreach($estates as $state)
                                            <option
                                                    @if($state->id == $report->state_id) selected @endif
                                            value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('estate_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">عنوان العملية (نبذة مختصرة)</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="اسم المدينة" value="{{ $report->name }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="flat">الشقة ( اختياري )</label>
                                    <input type="text" name="flat" class="form-control" id="flat"
                                           placeholder="الشقة" value="{{ $report->flat }}" required>
                                    @error('flat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="floor">الدور ( اختياري )</label>
                                    <input type="text" name="floor" class="form-control" id="floor"
                                           placeholder="الدور" value="{{ $report->floor }}" required>
                                    @error('floor')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="floor">المبلغ المدفوع او المراد دفعة</label>
                                    <input type="number" name="price" class="form-control" id="price"
                                           placeholder="قيمة المبلغ" value="{{ $report->price }}" required> ريال
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">تاريخ العملية</label>
                                    <input type="date" name="date" class="form-control" id="date"
                                           placeholder="تاريخ العملية" value="{{ $report->date }}" required>
                                    @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kind">نوع العملية</label>
                                    <select name="kind" class="form-control select2" id="kind"
                                            required>
                                        <option @if($report->kind == 1) selected @endif value="1">وارد</option>
                                        <option @if($report->kind == 2) selected @endif value="2">صادر</option>
                                        <option @if($report->kind == 3) selected @endif value="3">تنبية</option>
                                    </select>
                                    @error('kind')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="image">ملف العملية</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">الملف</label>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    @if(isset($report->file))
                                        <br>
                                        <a target="_blank" alt="الملف" href="{{ asset('pictures/reports/' . $report->file->file) }}"><i class="fa fa-file fa-3x"></i> </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
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
