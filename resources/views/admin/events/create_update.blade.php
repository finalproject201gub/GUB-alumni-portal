@extends('skeleton.admin.app')
@section('title', 'Create Event')
@section('body')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Event</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Create Event</li>
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('events.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" value="{{ $event->title ?? old('title') }}" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        placeholder="Enter Title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        rows="3" placeholder="Enter Description">{{ $event->description ?? old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="start_at">Start Date</label>
                                    <input name="start_at" value="{{ $event->start_at ?? old('start_at') }}"
                                        type="date-time" class="form-control @error('start_at') is-invalid @enderror"
                                        id="start_at" placeholder="Enter Start Date">
                                    @error('start_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="end_at">End Date</label>
                                    <input name="end_at" value="{{ $event->end_at ?? old('end_at') }}" type="date-time"
                                        class="form-control @error('end_at') is-invalid @enderror" id="end_at"
                                        placeholder="Enter End Date">
                                    @error('end_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group" id="locationField">
                                    <label for="location">Location</label>
                                    <input name="location" value="{{ $event->location ?? old('location') }}" type="text"
                                        class="form-control @error('location') is-invalid @enderror" id="autocomplete"
                                        placeholder="Enter Location">
                                    @error('location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="event_type">Event Type</label>
                                    <select name="event_type_id" style="padding: 20px"
                                        class="form-control select2-input @error('event_type_id') is-invalid @enderror"
                                        id="event_type">
                                        <option value="">Select Event Type</option>
                                        @foreach ($types as $key => $type)
                                            <option value="{{ $key }}"
                                                @if ($key == $event->event_type_id ?? old('event_type_id')) selected @endif>{{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
