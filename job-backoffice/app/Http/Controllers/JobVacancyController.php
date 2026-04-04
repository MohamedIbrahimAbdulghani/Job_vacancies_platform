<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JobVacancy;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobVacancy::latest();

        // // Archived
        if($request->input('archived') == 'true') {
            $query->onlyTrashed();  // use it in archived mode when use softDeletes()
        }

        $job_vacancies = $query->paginate(10)->onEachSide(1); // this is to get the last hob category will added it in database and make it paginate by one side or one button
        return view('job_vacancy.index', compact('job_vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('job_vacancies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job_vacancy = JobVacancy::findOrFail($id);
        $job_vacancy->delete();
        return redirect()->route('job_vacancy.index')->with('success', 'Job Vacancy Deleted Successfully!');
    }

    public function restore(string $id)
    {
        $job_vacancy = JobVacancy::withTrashed()->findOrFail($id);
        $job_vacancy->restore();
        return redirect()->route('job_vacancy.index')->with('success', ['archived'=>'true'])->with('success', 'Job Vacancy Restored Successfully!');
    }
}
