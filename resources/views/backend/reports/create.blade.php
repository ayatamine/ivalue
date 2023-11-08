@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">مدينة جديدة</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('infos.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">عنوان العملية</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="اسم المدينة" value="" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_id">المستخدم صاحب العقار</label>
                                    <select name="user_id" class="form-control select2" id="user_id"
                                            required>
                                        <option value selected disabled="">----- اختر صاحب العقار -----</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                        <option value selected disabled="">----- اختر صاحب العقار اولا -----</option>
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
                                    <label for="flat">الشقة ( اختياري )</label>
                                    <input type="text" name="flat" class="form-control" id="flat"
                                           placeholder="الشقة" value="">
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
                                           placeholder="الدور" value="">
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
                                           placeholder="قيمة المبلغ" value="" required> ريال
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
                                           placeholder="تاريخ العملية" value="" required>
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
                                        <option value selected disabled="">----- اختر نوع العملية -----</option>
                                        <option value="1">وارد</option>
                                        <option value="2">صادر</option>
                                        <option value="3">تنبية</option>
                                    </select>
                                    @error('kind')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="image">ارفاق ملف</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">الملف</label>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
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
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
@endsection
