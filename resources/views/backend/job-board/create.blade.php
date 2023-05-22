@extends('skeleton.admin.app')

@section('title', 'Job Board | Create')

@section('body')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card my-3">
                    <h3 class="card-header">Job Board Create</h3>
                    <div class="card-body">
                        @if (auth()->user()->role->name == "Admin")
                            <form action="{{ url('/admin/job-board') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="">Company Name</label>
                                    <input class="form-control" type="text" name="company_name" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input class="form-control" type="text" name="title" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" rows="3" name="description"
                                              id=""> </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Vacancy</label>
                                    <input class="form-control" rows="3" name="vacancy" id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Experience Requirements</label>
                                    <input class="form-control" rows="3" name="experience_requirements"
                                           id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Education Requirements</label>
                                    <input class="form-control" rows="3" name="education_requirements"
                                           id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Company Information</label>
                                    <textarea class="form-control" rows="3" name="company_information"
                                              id=""> </textarea>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Attachment(Image only)</label>--}}
{{--                                    <input class="form-control" type="file" name="image" id="">--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="">Job Type</label>
                                    <select class="form-control" name="job_type">
                                        <option value="">---Select---</option>
                                        <option value="intern">Intern</option>
                                        <option value="part-time">Part Time</option>
                                        <option value="fulltime">Full Time</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Salary</label>
                                    <input class="form-control" type="text" name="salary" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Location</label>
                                    <input class="form-control" type="text" name="location" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Application Deadline</label>
                                    <input class="form-control" type="date" name="application_deadline" id="">
                                </div>

                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>

                        @else
                            <form action="{{ route('job-board.store') }}" method="POST"
                                  enctype="multipart/form-data">

                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="">Company Name</label>
                                    <input class="form-control" type="text" name="company_name" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input class="form-control" type="text" name="title" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" rows="3" name="description"
                                              id=""> </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Vacancy</label>
                                    <input class="form-control" rows="3" name="vacancy" id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Experience Requirements</label>
                                    <input class="form-control" rows="3" name="experience_requirements"
                                           id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Education Requirements</label>
                                    <input class="form-control" rows="3" name="education_requirements"
                                           id=""> </input>
                                </div>
                                <div class="form-group">
                                    <label for="">Company Information</label>
                                    <textarea class="form-control" rows="3" name="company_information"
                                              id=""> </textarea>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Attachment(Image only)</label>--}}
{{--                                    <input class="form-control" type="file" name="image" id="">--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="">Job Type</label>
                                    <select class="form-control" name="job_type">
                                        <option value="">---Select---</option>
                                        <option value="intern">Intern</option>
                                        <option value="part-time">Part Time</option>
                                        <option value="fulltime">Full Time</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Salary</label>
                                    <input class="form-control" type="text" name="salary" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Location</label>
                                    <input class="form-control" type="text" name="location" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Application Deadline</label>
                                    <input class="form-control" type="date" name="application_deadline" id="">
                                </div>

                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
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
