<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Company\Store;
use App\Http\Requests\SuperAdmin\Company\Update;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    /**
     * Display a listing of the companies.
     */

    public function index()
    {
        $companies = Company::withCount(['users','admins', 'members'])
            ->latest()
            ->paginate(5); // PER PAGE = 5

        // AJAX request → return partial HTML

        if (request()->ajax()) {
            return view('super-admin.company.table', compact('companies'))->render();
        }

        return view('super-admin.company.index', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Store $request)
    {
        $company = Company::create($request->validated());

        return response()->json([
            'message'  => 'Company created successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Update $request, Company $company)
    {
        $company->update($request->validated());

        return response()->json([
            'message' => 'Company updated successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }

    /**
     * Soft delete company
     *
     */

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }
}
