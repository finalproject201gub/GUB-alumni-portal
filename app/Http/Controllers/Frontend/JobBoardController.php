<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;
use Illuminate\Http\Request;

class JobBoardController extends Controller
{
    public function index()
    {
        $jobBoards = JobBoard::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('frontend.job-board.index', [
            'jobBoards' => $jobBoards,
        ]);
    }

    public function show(Request $request, $id)
    {
        $jobBoard = JobBoard::query()->findOrFail($id);

        return view('frontend.job-board.single-view', [
            'jobBoard' => $jobBoard,
        ]);
    }
}
