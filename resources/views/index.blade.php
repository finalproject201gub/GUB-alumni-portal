@extends('skeleton.public.app')
@push('style')
    <style>
        .status-box {
            font-size: 1.3rem;
            height: 60px;
            border-radius: 20px;
        }
    </style>
@endpush
@section('body')
    <div class="content">
        <div class="container">
            <div class="row m-3">
                <div class="user-block col-md-1 col-2">
                    <img class="img-circle" style="height:  60px; width: 60px; z-index: 2"
                        src="{{ asset('img/user1-128x128.jpg') }}" alt="User Image">
                </div>
                <div class="col-md-11 col-10">
                    <input type="text" class="form-control status-box" name="" id=""
                        placeholder="What's on your mind?">
                </div>
            </div>
            <div id="home-main-content"></div>
        </div>
    </div>

    <script src="{{ mix('js/home/index.js') }}"></script>
@endsection
