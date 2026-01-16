<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Company\Store;
use App\Http\Requests\SuperAdmin\Company\Update;
use App\Http\Requests\SuperAdmin\Invitation\Send;
use App\Mail\AdminInvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
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
            ->paginate(5);

        // AJAX request → return partial HTML

        if (request()->ajax()) {
            return view('super-admin.company.table', compact('companies'))->render();
        }

        return view('super-admin.company.index', compact('companies'));
    }

    /**
     * Company creation handler.
     */

    public function store(Store $request)
    {

        $company = new Company();
        $company->name = $request->validated('name');
        $company->save();

        // Send admin invite unless skipped

        if (!$request->boolean('skip_invite') && $request->validated('admin_email')) {
            $this->createAdminInvitation($company, $request->validated('admin_email'));
        }

        return response()->json([
            'message' => 'Company created successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }

    /**
     * Company update handler.
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
     * Company deletion handler.
     */

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully.',
            'redirect' => route('superadmin.companies.index'),
        ]);
    }

    // Helper to create admin invitation

    protected function createAdminInvitation(Company $company, string $email): void
    {

        // Prevent inviting existing admin

        if ($company->users()->where('email', $email)->exists()) {

            throw ValidationException::withMessages([
                'admin_email' => 'User already belongs to this company.',
            ]);

        }

        $rawToken = Str::random(40);

        // Create invitation

        Invitation::create([
            'company_id' => $company->id,
            'email' => $email,
            'role' => 'admin',
            'token' => Hash::make($rawToken),
            'expires_at' => now()->addDays(3),
            'created_by' => Auth::user()->id,
        ]);

        // Send invitation email

        Mail::to($email)->send(
            new AdminInvitationMail($company, $rawToken)
        );
    }

    // Redirect to company show > overview

    public function show(Company $company)
    {
        return redirect()
            ->route('superadmin.companies.overview.index', $company);
    }

    // Company Tabs > Overview

    public function companyOverview(Company $company)
    {

        return view('super-admin.company.tabs.overview');

    }

    // Company Tabs > Admins

    public function companyAdmins(Company $company)
    {

        $admins = $company->admins()->paginate(10);

        $pendingInvites = Invitation::where('company_id', $company->id)
            ->whereNull('accepted_at')
            ->where('role', 'admin')
            ->get();

        return view('super-admin.company.tabs.admins', compact('company', 'admins', 'pendingInvites'));

    }

    // Invite Company Admin (Secondary Invite Flow)

    public function inviteCompanyAdmin(Send $request, Company $company)
    {

        $requestData = $request->validated();

        // Already active admin?

        if ($company->users()
            ->where('email', $requestData['email'])
            ->where('role', 'admin')
            ->exists()) {

            return response()->json([
                'status' => 'error',
                'message' => 'User is already an admin of this company.',
            ], 422);
        }

        // Already invited & pending?

        if (Invitation::where('company_id', $company->id)
            ->where('email', $requestData['email'])
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->exists()) {

            return response()->json([
                'status' => 'error',
                'message' => 'An active invitation already exists.',
            ], 422);

        }

        // Existing user belongs to another company?

        $existingUser = User::where('email', $requestData['email'])->first();

        if ($existingUser && $existingUser->company_id !== null) {

            return response()->json([
                'status' => 'error',
                'message' => 'User already belongs to another company.',
            ], 422);

        }

        // Create invitation (reuse same helper as PRIMARY)

        $this->createAdminInvitation($company, $requestData['email']);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin invitation sent successfully.',
            'redirect' => route('superadmin.companies.admins.index', $company),
        ]);

    }
}
