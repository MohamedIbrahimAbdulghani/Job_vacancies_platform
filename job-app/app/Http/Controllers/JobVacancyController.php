<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function show($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('job_vacancies'));
    }
    public function apply(Request $request) {
        return $request;
    }
}