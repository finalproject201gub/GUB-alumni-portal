<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;
use Illuminate\Http\Request;

class AdminJobBoardController extends Controller
{
    public function index()
    {
        $jobBoardList = JobBoard::query()
            ->where('user_id', auth()->user()->id)
            ->get();

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

    public function destroy()
    {

    }
}
