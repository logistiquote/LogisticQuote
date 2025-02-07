<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Closure;

class checkRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            if ($user->role === 'user') {
                return redirect('/quotation');
            }
            return redirect()->back()->with('error', 'You do not have access to this section.');
        }

        return $next($request);
    }
}
