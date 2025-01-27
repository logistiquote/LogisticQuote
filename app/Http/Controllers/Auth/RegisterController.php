<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Services\RecaptchaService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
    public function __construct(private RecaptchaService $recaptchaService)
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'f_name' => ['required', 'string', 'regex:/^[a-zA-Z0-9 ]+$/', 'min:3', 'max:50'],
            'l_name' => ['required', 'string', 'regex:/^[a-zA-Z0-9 ]+$/', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) {
                $disposableDomains = ['mailinator.com', 'yopmail.com', 'tempmail.com'];
                $emailDomain = substr(strrchr($value, "@"), 1);

                if (in_array($emailDomain, $disposableDomains)) {
                    $fail('Disposable email addresses are not allowed.');
                }
            },],
            'role' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^\d{10,15}$/', function ($attribute, $value, $fail) {
                if (preg_match('/(\d)\1{6,}/', $value)) {
                    $fail('Invalid phone number.');
                }
            }],
            'company_name' => ['required', 'string', 'regex:/^[a-zA-Z0-9 ]+$/', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'min:6'],
            'g-recaptcha-response' => ['required'],
            'extra_field' => function ($attribute, $value, $fail) {
                if (!empty($value)) {
                    $fail('Bot detected.');
                }
            },
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (config('services.recaptcha.enabled')) {
            $token = $request->all()['g-recaptcha-response'];
            $recaptchaKey = env('RECAPTCHA_SITE_KEY');
            $projectId = env('RECAPTCHA_PROJECT_ID');
            $action = 'register';

            $score = $this->recaptchaService->validateToken($recaptchaKey, $token, $projectId, $action);

            if (is_null($score) || $score < 0.5) {
                return redirect()->back()->withErrors(['captcha' => 'Captcha validation failed or suspicious activity detected.']);
            }
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['f_name']. ' '.$data['l_name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'company_name' => $data['company_name'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
