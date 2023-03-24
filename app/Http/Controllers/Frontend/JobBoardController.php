<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationDetail;
use App\Models\JobBoard;
use Illuminate\Http\Request;

class JobBoardController extends Controller
{
    public function index(Request $request)
    {
        $jobBoards = JobBoard::query()
            ->with('user')
            ->search($request->search)
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

    public function applyJobView(Request $request, $id)
    {
        $jobPostId = $id ?? null;
        $userId = $request->get('user_id') ?? null;

        return view('frontend.job-board.apply-job', [
            'jobPostId' => $jobPostId,
            'userId' => $userId,
        ]);
    }

    public function applyJob(Request $request)
    {
        $resumePath = $request->get("resume_path") ?? null;
        $linkedinUrl = $request->get("linkedin_url") ?? null;
        $githubUrl = $request->get("github_url") ?? null;
        $portfolioUrl = $request->get("portfolio_url") ?? null;
    }
}
