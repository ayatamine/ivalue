@extends('backend.layout.master')
@section('backend-head')
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">العقارات الخاصة بــ {{ $user->name }}</h4>
                    <hr>
                    <div class="row">
                        @foreach($user->estates as $estate)
                            <div class="col-md-6 col-xl-3">
                                <!-- Simple card -->
                                <div class="card">
                                    @if(isset($estate->mainImage))
                                        <img class="card-img-top img-fluid" alt="الصورة" src="{{ asset('pictures/estates/' . $estate->mainImage->file) }}"/>
                                    @else
                                        <img class="card-img-top img-fluid" alt="الصورة" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                    <div class="card-body">
                                        <h4 class="card-title mt-0">{{ $estate->name }}</h4>
                                        <p class="card-text">{{ $estate->address }}</p>
                                        <a title="زيارة" style="width: 100%" href="{{ route('estates.show' , $estate->slug) }}" class="btn btn-primary waves-effect waves-light"><i class="fa fa-eye"></i> </a>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <br>
                    <a href="{{ route('users.index') }}" style="width: 100%" class="btn btn-success">الرجوع</a>
                </div>
            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('backend-footer')
@endsection