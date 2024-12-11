<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) //Optional
            return redirect('login');

        $user = Auth::user();
        if($user->role == $role)    // this $role coming from Controller to verify role authority
        {
            return $next($request);
        }
        else    // If not matched goto login then there will be redirected to correct path
        {
            return redirect('login');
        }
    }
}
