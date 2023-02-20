<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;
use Illuminate\Http\Request;

class AdminJobBoardController extends Controller
{
    public function index()
    {
        return "index";
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

    public function edit()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
