@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">نعديل الصفحة " {{ $page->name }} "</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('pages.update' , $page->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom01">اسم الصفحة</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="اسم الصفحة" value="{{ $page->name }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body">محتوى الصفحة</label>
                                    <textarea rows="10" type="text" name="body" class="form-control summernote" id="body" placeholder="محتوى الصفحة"required>{{ $page->body }}</textarea>
                                    @error('body')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox"
                                           @if($page->active == 1) checked="" @endif
                                           name="active" class="custom-control-input" id="customCheck1" >
                                    <label class="custom-control-label" for="customCheck1">فعال</label>
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
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/summernote/summernote-bs4.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-editor.init.js"></script>
@endsection
