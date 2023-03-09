<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        return redirect('/admin/job-board/create')->with('success', 'Job Post Created Successfully!');
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

        return redirect('/admin/job-board')->with('success', 'Job Post Updated Successfully!');
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
}
