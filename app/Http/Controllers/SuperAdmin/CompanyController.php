<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Company\Store;
use App\Http\Requests\SuperAdmin\Company\Update;
use App\Mail\AdminInvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        $companies = Company::withCount(['users', 'admins', 'members'])
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

        $company = new Company();
        $company->name = $request->validated('name');
        $company->save();

        if (!$request->boolean('skip_invite') && $request->validated('admin_email')) {
            $this->createAdminInvitation($company, $request->validated('admin_email'));
        }

        return response()->json([
            'message' => 'Company created successfully.',
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
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }

    protected function createAdminInvitation(Company $company, string $email): void
    {

        // Prevent inviting existing admin

        if ($company->users()->where('email', $email)->exists()) {

            throw ValidationException::withMessages([
                'admin_email' => 'User already belongs to this company.',
            ]);

        }

        $rawToken = Str::random(40);

        Invitation::create([
            'company_id' => $company->id,
            'email' => $email,
            'role' => 'admin',
            'token' => Hash::make($rawToken),
            'expires_at' => now()->addDays(3),
            'created_by' => Auth::user()->id,
        ]);

        Mail::to($email)->send(
            new AdminInvitationMail($company, $rawToken)
        );
    }
}
