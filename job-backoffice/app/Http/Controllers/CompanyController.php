<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();

        // Archived
        if($request->input('archived') == 'true') {
            $query->onlyTrashed();  // use it in archived mode when use softDeletes()
        }

        $companies = $query->paginate(5)->onEachSide(1); // this is to get the last hob category will added it in database and make it paginate by one side or one button
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request)
    {
        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'industry' => $request->industry,
            'website' => $request->website,
            'owner_id' => Auth::user()->id
        ]);
        return redirect()->route('company.index')->with('success', 'Company Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, string $id)
    {
        $company = Company::findOrFail($id);
        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'industry' => $request->industry,
            'website' => $request->website,
        ]);
        return redirect()->route('company.index')->with('success', 'Company Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company Deleted Successfully!');
    }
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index', ['archived'=>'true'])->with('success', 'Company Restored Successfully!');
    }
}