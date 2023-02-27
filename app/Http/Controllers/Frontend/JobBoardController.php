<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;

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
}
