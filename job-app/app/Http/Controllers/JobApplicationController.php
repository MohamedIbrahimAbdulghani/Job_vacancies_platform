<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function index() {
        $jobApplications = JobApplication::where('user_id', Auth::user()->id)->latest()->paginate(5);
        return view('job_applications.index', compact('jobApplications'));
    }
}