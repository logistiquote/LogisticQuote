<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $oceanSessionData = session('quote_data');
        $airSessionData = session('air_quote_data');

        if (!empty($oceanSessionData) && isset($oceanSessionData['incoterms'])) {
            return redirect(route('store_pending_form'));
        }

        if (!empty($airSessionData)) {
            return redirect()->route('dhl.quote')->with([
                'air_quote_data' => $airSessionData
            ]);
        }
    }

    protected function redirectTo()
    {
        if(Auth::user()->role == 'admin')
        {
            return '/admin';
        }
        else if(Auth::user()->role == 'user')
        {
            return '/user';
        }
    }
}
