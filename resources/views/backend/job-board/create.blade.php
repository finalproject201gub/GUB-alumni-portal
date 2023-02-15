@extends('skeleton.admin.app')

@section('title', 'Job Board | Create')

@section('body')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card my-3">
                    <h3 class="card-header">Job Board Create</h3>
                    <div class="card-body">
                        <form action="{{ url('/admin/job-board/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Title</label>
                                <input class="form-control" type="text" name="title" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea class="form-control" rows="3" name="description" id=""> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Attachment(Image only)</label>
                                <input class="form-control" type="file" name="image" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Job Type</label>
                                <select class="form-control" name="job_type">
                                    <option>---Select---</option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
