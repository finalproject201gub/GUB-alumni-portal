<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationDetail;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function jobApplicationList()
    {
        $userId = auth()->user()->id;

        $jobApplications = JobApplicationDetail::query()
            ->with([
                'jobBoard'
            ])
            ->where('applied_by', $userId)
            ->latest()
            ->paginate(10);

        return view('backend.job-board.job-applications-list', compact('jobApplications'));
    }
}
