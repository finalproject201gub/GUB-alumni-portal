@extends('skeleton.admin.app')

@section('title', 'Job Board | List')

@section('body')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card my-3">
                    <h3 class="card-header">Job Board List</h3>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Job Type</th>
                                <th>Salary</th>
                                <th>Location</th>
                                <th>Application Deadline</th>
                                <th>Approve Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody style="text-align: center;">
                            @foreach($jobBoardList as $jobBoard)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($jobBoard->title) }}</td>
                                    <td>{{ \Illuminate\Support\Str::words($jobBoard->description, 20, '...') }}</td>
                                    <td>{{ ucfirst($jobBoard->job_type) }}</td>
                                    <td>{{ $jobBoard->salary }}</td>
                                    <td>{{ ucfirst($jobBoard->location) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jobBoard->application_deadline)->format('d-M-Y') }}</td>
                                    @if($jobBoard->approve_status == 'no')
                                        <td>
                                            <span
                                                style="color: white;font-weight: bold;background: red;padding: 1px 3px;border-radius: 5px;">
                                                {{ ucfirst($jobBoard->approve_status) }}
                                            </span>
                                        </td>
                                    @else
                                        <td>
                                            <span
                                                style="color: white;font-weight: bold;background: green;padding: 1px 3px;border-radius: 5px;;">
                                                {{ ucfirst($jobBoard->approve_status) }}
                                            </span>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-sm btn-info"
                                           href="{{ route('job-board.edit', $jobBoard->id) }}">Edit</a>
                                        |
                                        <button id="delete" onclick="document.getElementById({{ $jobBoard->id }}).submit();"
                                                class="btn btn-sm btn-danger"
                                        >
                                            Delete
                                        </button>
                                        <form id="{{$jobBoard->id}}" method="POST"
                                              action="{{ route('job-board.destroy', $jobBoard->id) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
