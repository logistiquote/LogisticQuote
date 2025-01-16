<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $sessionData = session('quote_data');

            if (!empty($sessionData) && isset($sessionData['incoterms'])) {
                return redirect(route('store_pending_form'));
            }

            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role === 'user') {
                return redirect('/user');
            }
        }

        return $next($request);
    }
}
