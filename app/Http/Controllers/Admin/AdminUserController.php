<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invitation\Send;
use App\Mail\AdminUserInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    // Display a listing of the users and pending invitations.

    public function index(Request $request)
    {

        $admin = Auth::user();

        // Fetch paginated users and invitations

        $users = $admin->company
            ->users()
            ->withUrlStatsVisibleTo($admin)
            ->latest()
            ->paginate(5, ['*'], 'users_page');

        $pendingInvitations = $admin->company
            ->pendingInvitations()
            ->latest()
            ->paginate(5, ['*'], 'pending_invitations_page');

        // AJAX request -> return partial HTML

        if ($request->ajax()) {

            // Determine which table to return

            if ($request->has('users_page')) {

                return view('admin.users.tables.active-users', compact('users'))->render();

            }

            if ($request->has('pending_invitations_page')) {

                return view('admin.users.tables.pending-invitations', compact('pendingInvitations'))->render();

            }

        }

        return view('admin.users.index', compact('users', 'pendingInvitations'));
    }

    // Handle user invitation.

    public function inviteUser(Send $request)
    {

        $requestData = $request->validated();

        $admin = Auth::user();

        $company = $admin->company;

        $rawToken = Str::random(40);

        // Create invitation

        $invitation = $company->invitations()->create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'role' => $requestData['role'],
            'token' => Hash::make($rawToken),
            'expires_at' => now()->addDays(3),
            'created_by' => $admin->id,
        ]);

        // Send invitation email

        Mail::to($requestData['email'])->send(
            new AdminUserInvitationMail($company, $rawToken, $requestData['role'])
        );

        return response()->json([
            'status' => 'success',
            'message' => "Invitation sent successfully!",
            'redirect' => route('admin.users.index'),
        ]);

    }
}
