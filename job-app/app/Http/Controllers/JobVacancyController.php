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
    public function apply($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.apply', compact('job_vacancies'));
    }
    public function processing($id) {

    }
}
