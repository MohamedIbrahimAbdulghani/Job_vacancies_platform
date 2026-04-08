<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        // Last 30 days active users (job-seeker role)
        $activeUsers = User::whereNotNull('last_login_at')
        ->where('last_login_at', '>=', now()->subDays(30))
        ->where('role', 'job_seeker')
        ->count();

        // Total Jobs ( not deleted )
        $totalJobs = JobVacancy::whereNull('deleted_at')
        ->count();

        // Total Applications ( not deleted )
        $totalApplications = JobApplication::whereNull('deleted_at')
        ->count();

        // Most Applied Jobs
        $mostAppliedJobs = JobVacancy::withCount('jobapplications as totalCountJobApplication')
        ->whereNull('deleted_at')
        ->orderByDesc('totalCountJobApplication')
        ->limit(5)
        ->get();

        // Top Converting Job Posts
        $conversionJobRates = JobVacancy::withCount('jobapplications as totalCountJobApplication')
        ->whereNull('deleted_at')
        ->having('totalCountJobApplication', '>', 0)
        ->limit(5)
        ->orderByDesc('totalCountJobApplication')
        ->get()
        ->map(function($job) {
            if($job->view_count > 0) {
                $job->conversionRate = round(( $job->totalCountJobApplication / $job->view_count ) * 100 , 2);
            } else {
                $job->conversionRate = 0;
            }
            return $job;
        });

        return view('dashboard.index', compact('activeUsers', 'totalJobs', 'totalApplications','mostAppliedJobs', 'conversionJobRates'));
    }
}
