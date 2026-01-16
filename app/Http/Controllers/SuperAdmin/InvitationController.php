<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Invitation\Complete;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{

    public function show(string $token)
    {
        $invite = $this->resolveInvitation($token);

        // Case 1: User already logged in

        if (Auth::check()) {

            if (Auth::user()->email !== $invite->email) {

                abort(403, 'This invitation was sent to a different email.');
            }

            return view('invitations.confirm', compact('invite', 'token'));
        }

        // Case 2: Not logged in

        $existingUser = User::where('email', $invite->email)->first();

        if ($existingUser) {

            // force login first

            return redirect()
                ->route('login')
                ->with('invite_token', $token);

        }

        // Case 3: New user -> set password

        return view('invitations.set-password', compact('invite', 'token'));

    }

    public function accept(Request $request, string $token)
    {
        $invite = $this->resolveInvitation($token);

        $user = User::findOrFail(Auth::id());

        if ($user->email !== $invite->email) {
            abort(403);
        }

        // Prevent overwriting existing company

        if ($user->company_id !== null) {
            abort(403, 'User already belongs to another company.');
        }

        $user->update([
            'company_id' => $invite->company_id,
            'role' => 'admin',
        ]);

        $invite->update([
            'accepted_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Invitation accepted successfully.',
            'redirect' => route('dashboard'),
        ]);

    }

    public function complete(Complete $request, string $token)
    {

        $invite = $this->resolveInvitation($token);

        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $invite->email,
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'role' => 'admin',
            'company_id' => $invite->company_id,
            'email_verified_at' => now(),
        ]);

        $invite->update([
            'accepted_at' => now(),
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Account created successfully.',
            'redirect' => route('dashboard'),
        ]);
    }

    /**
     * Display the specified invitation.
     */

    protected function resolveInvitation(string $rawToken): Invitation
    {
        $invitations = Invitation::whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->get();

        foreach ($invitations as $invite) {

            if (Hash::check($rawToken, $invite->token)) {

                return $invite;

            }

        }

        abort(403, 'Invalid or expired invitation.');

    }

}
