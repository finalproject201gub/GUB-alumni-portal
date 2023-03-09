@extends('skeleton.public.app')

@section('title', 'Job Board')

@push('style')

    <style>
        .jobs-wrapper {
            border: 1px solid #000;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            transition: .4s;
        }

        .jobs-wrapper:hover {
            box-shadow: 5px 5px 2px #ccc;
        }

        .jobs-wrapper a {
            color: #000;
            text-decoration: none;
        }

        .jobs-wrapper a:hover {
            color: #000;
            text-decoration: none;
        }
    </style>

@endpush

@section('body')

    <div class="container">
        <div class="row">
                        <div class="col-md-12">
                            <div class="card my-3">
                                <h3 class="card-header">Job Post Details View</h3>
                                <div class="card-body">
                                    <div class="job-list">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="jobs-wrapper">
                                                    <div class="col-md-12">
                                                        <div class="job-title">
                                                            <h4 style="color: #348334; font-weight: bold; font-size: 25px;">{{ $jobBoard->title }}</h4>
                                                        </div>
                                                        <div class="company-name">
                                                            <h5 style=" font-weight: bold; font-size: 18px;">Company: Apple
                                                                Inc.</h5>
                                                        </div>
                                                        <div class="job-info">
                                                            <p><b>Location: </b> {{ $jobBoard->location }}</p>
                                                            <p><b>Job Type: </b> {{ $jobBoard->job_type }}</p>
                                                            <p>
                                                                <span><b>Salary: </b>  {{ $jobBoard->salary }}</span>
                                                                <span style="float: right; overflow: hidden"><b
                                                                        style="color: red; ">Deadline: </b>  {{ \Carbon\Carbon::parse($jobBoard->application_deadline)->format('d-M-Y') }}</span>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">

                                                </div>
                                            </div>
            {{--                                --}}{{--                            @foreach($jobBoards as $jobBoard)--}}
            {{--                                --}}{{--                                <div class="row">--}}
            {{--                                --}}{{--                                    <div class="jobs-wrapper">--}}
            {{--                                --}}{{--                                        <a href="{{ url("jobs?listing_id=$jobBoard->id") }}">--}}
            {{--                                --}}{{--                                            <div class="col-md-12">--}}
            {{--                                --}}{{--                                                <div class="job-title">--}}
            {{--                                --}}{{--                                                    <h4 style="color: #348334; font-weight: bold; font-size: 25px;">{{ $jobBoard->title }}</h4>--}}
            {{--                                --}}{{--                                                </div>--}}
            {{--                                --}}{{--                                                <div class="company-name">--}}
            {{--                                --}}{{--                                                    <h5 style=" font-weight: bold; font-size: 18px;">Company: Apple--}}
            {{--                                --}}{{--                                                        Inc.</h5>--}}
            {{--                                --}}{{--                                                </div>--}}
            {{--                                --}}{{--                                                <div class="job-info">--}}
            {{--                                --}}{{--                                                    <p><b>Location: </b> {{ $jobBoard->location }}</p>--}}
            {{--                                --}}{{--                                                    <p><b>Job Type: </b> {{ $jobBoard->job_type }}</p>--}}
            {{--                                --}}{{--                                                    <p>--}}
            {{--                                --}}{{--                                                        <span><b>Salary: </b>  {{ $jobBoard->salary }}</span>--}}
            {{--                                --}}{{--                                                        <span style="float: right; overflow: hidden"><b--}}
            {{--                                --}}{{--                                                                style="color: red; ">Deadline: </b>  {{ \Carbon\Carbon::parse($jobBoard->application_deadline)->format('d-M-Y') }}</span>--}}
            {{--                                --}}{{--                                                    </p>--}}
            {{--                                --}}{{--                                                    --}}{{----}}{{--                                                <p></p>--}}
            {{--                                --}}{{--                                                </div>--}}
            {{--                                --}}{{--                                            </div>--}}
            {{--                                --}}{{--                                        </a>--}}
            {{--                                --}}{{--                                    </div>--}}
            {{--                                --}}{{--                                </div>--}}
            {{--                                --}}{{--                            @endforeach--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>

    </div>
@endsection

@section('script')
            <script>

                $(document).ready(function () {
                    toastr.options.timeOut = 3000;
                    toastr.options.progressBar = true;
                    @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                    @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                    @endif
                });

            </script>
@endsection
