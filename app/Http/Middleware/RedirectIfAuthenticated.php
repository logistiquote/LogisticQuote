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
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        if (Auth::guard($guard)->check()) 
        {
            if(Storage::disk('public')->exists('store_pending_form.json'))
            {
                $fileContents = Storage::disk('public')->get('store_pending_form.json');
                $fileContents = json_decode($fileContents);
                if(isset($fileContents->incoterms) != null)
                {
                    return redirect(route('store_pending_form'));
                } 
            }
            if(Auth::user()->role == 'admin')
            {
                return redirect('/admin');
            }
            else if(Auth::user()->role == 'user')
            {
                return redirect('/user');
            }
            else if(Auth::user()->role == 'vendor')
            {
                return redirect('/ven');
            }
        }
        return $next($request);
    }
}
