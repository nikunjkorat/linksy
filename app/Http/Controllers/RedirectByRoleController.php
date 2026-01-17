<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectByRoleController extends Controller
{

    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isMember()) {
            return redirect()->route('member.dashboard');
        }

        abort(403);
    }
}
