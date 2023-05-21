<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationDetail;
use App\Models\JobBoard;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AdminJobBoardController extends Controller
{
    public function index(Request $request)
    {
        $jobBoardList = JobBoard::query()
            ->search($request->search)
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(10);

        return view('backend.job-board.index', [
            'jobBoardList' => $jobBoardList,
        ]);
    }

    public function create()
    {
        return view('backend.job-board.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required',
            "description" => 'required',
            "job_type" => 'required',
            "salary" => 'required',
            "location" => 'required',
            "application_deadline" => 'required',
        ]);

        JobBoard::query()
            ->create($request->all() + ['user_id' => auth()->user()->id]);

        return redirect()->back()->with('success', 'Job Post Created Successfully!');
    }

    public function edit($id)
    {
        $jobBoard = JobBoard::query()
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        return view('backend.job-board.edit', [
            'jobBoard' => $jobBoard,
        ]);
    }

    public function show()
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => 'required',
            "description" => 'required',
            "job_type" => 'required',
            "salary" => 'required',
            "location" => 'required',
            "application_deadline" => 'required',
        ]);

        $jobBoard = JobBoard::query()
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        $jobBoard->update($request->all() + ['user_id' => auth()->user()->id]);

        return redirect()->back()->with('success', 'Job Post Updated Successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $jobBoard = JobBoard::query()
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if($jobBoard) {
            $jobBoard->delete();
            return redirect()->back()->with('success', 'Job Post Deleted Successfully!!');
        }
        else {
            return redirect()->back()->with('error', 'Job Post Delete Failed!!');
        }
    }

    public function applicantsIndex(Request $request)
    {
        $jobApplicantsList = JobApplicationDetail::query()
            ->with([
                'user',
            ])
            ->whereHas('jobBoard', function ($query) {
                $query->where('approve_status', 'yes')
                    ->where('user_id', auth()->user()->id);;
            })
//
            ->get()
            ->map(function ($jobApplication) {

                return [
                    'id' => $jobApplication->id,
                    'company_name' => $jobApplication->jobBoard->company_name,
                    'job_title' => $jobApplication->jobBoard->title,
                    'application_deadline' => Carbon::parse($jobApplication->jobBoard->application_deadline)->format('d-m-Y'),
                    'applicants_name' => $jobApplication->user->name,
                    'applied_date' => Carbon::parse($jobApplication->applied_date)->format('d-m-Y g:i:s a'),
                    'resume_path' => $jobApplication->resume_path,
                ];
            });

//        dd($jobApplicantsList);

        return view('backend.job-board.applicants', [
            'jobApplicantsList' => $jobApplicantsList,
        ]);
    }

    /**
     * @throws FileNotFoundException
     */
    public function downloadCV(Request $request)
    {

        $file = "/job-application/pdf/".$request->get('file');

        $contents = Storage::disk('public')->get($file);
        return Storage::download($contents);
    }
}
