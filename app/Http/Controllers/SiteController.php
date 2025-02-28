<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUs;
use App\Models\Quotation;
use App\Services\QuotationService;
use App\Services\RecaptchaService;
use App\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function __construct(private RouteService $routeService, private QuotationService $quotationService, private RecaptchaService $recaptchaService)
    {
    }

    public function index()
    {
        $data['page_title'] = 'Homepage | LogistiQuote';
        $data['page_name'] = 'homepage';

        $allRoutes = $this->routeService->getAllRoutes();
        $data['origins'] = $this->routeService->getUniqueOrigins($allRoutes);
        $data['destinations'] = $this->routeService->getUniqueDestinations($allRoutes);

        return view('frontend.index', $data);
    }

    public function contact_us()
    {
        $data['page_title'] = 'Contact Us | LogistiQuote';
        $data['page_name'] = 'contact_us';
        return view('frontend.contact_us', $data);
    }

    public function contact(ContactUsRequest $request)
    {
        $validated = $request->validated();
        $data = [
            'to' => env('MAIL_HOST'),
            'subject' => $validated->subject,
            'name' => $validated->name,
            'phone' => $validated->phone,
            'email' => $validated->email,
            'msg' => $validated->message,
        ];

        if (config('services.recaptcha.enabled')) {
            $token = $request->all()['g-recaptcha-response'];
            $recaptchaKey = env('RECAPTCHA_SITE_KEY');
            $projectId = env('RECAPTCHA_PROJECT_ID');
            $action = 'contact-us';

            $score = $this->recaptchaService->validateToken($recaptchaKey, $token, $projectId, $action);

            if (is_null($score) || $score < 0.5) {
                return redirect()->back()->withErrors(['captcha' => 'Captcha validation failed or suspicious activity detected.']);
            }
        }

        Mail::to($data['to'])->send(new ContactUs($data));

        return redirect()->back();
    }

    public function getQuoteStepOne(Request $request)
    {
        session([
            'quote_data' => [
                'type' => $request->type,
                'transportation_type' => $request->transportation_type,
                'route_id' => $request->route_id,
                'ready_to_load_date' => $request->date,
                'route_containers' => $request->route_containers,
                'is_admin_panels' => str_contains(url()->previous(), '/quotation/create')
            ]
        ]);

        session()->save();

        return redirect(route('get_quote_step2'));
    }

    public function getQuoteStepTwo()
    {
        $sessionData = session('quote_data');

        if (!$sessionData || empty($sessionData['ready_to_load_date'])) {
            return redirect(route('index'));
        }

        $data['page_title'] = 'Request a quote | LogistiQuote';
        $data['page_name'] = 'get_quote_step2';
        $data['type'] = $sessionData['type'];
        if ($sessionData['type'] === 'fcl') {
            $data['containers'] = $sessionData['route_containers'];
        }

        if ($sessionData['type'] === 'lcl' || $sessionData['type'] === 'fcl') {
            if ($sessionData['is_admin_panels']) {
                return view('panels.quotation.quote_info', $data);
            } else {
                return view('frontend.get_quote', $data);
            }
        } else {
            return redirect()->back();
        }
    }

    public function formQuoteFinalStep(Request $request)
    {
        if ($request->file('attachment')) {
            $file_name = rand() . '.' . $request->file('attachment')->getClientOriginalExtension();
            $request->merge(['attachment_file' => $file_name]);
            Storage::disk('public')->putFileAs('temp/', $request->file('attachment'), $file_name);
        }

        $sessionData = session('quote_data', []);

        $updatedData = array_merge($sessionData, $request->all());
        if ($updatedData['type'] === 'fcl') {
            $currentContainers = $this->quotationService->getFormatedContainersData($updatedData);
            $updatedData['current_containers'] = $currentContainers;
        }

        session(['quote_data' => $updatedData]);

        if (Auth::check()) {
            if (Auth::user()->role != 'user') {
                session()->forget('quote_data');
                return "You are no allowed to perform this action. Only user can add quotation.";
            } else {
                return redirect()->route('store_pending_form');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function mail_view_quotation($token)
    {
        $quotation = Quotation::where('quotation_id', $token)->first();
        return redirect(route('quotation.show', $quotation->id));
    }

    public function merge_them()
    {
        $arabic = "";
        foreach (file(url('public/trans/variables.json')) as $line) {
            $arabic = $arabic . $line . '+<br>';
        }
        foreach (file(url('public/trans/arabic_translation.json')) as $line) {
            $from = '/' . preg_quote('+', '/') . '/';
            $arabic = preg_replace($from, $line, $arabic, 1);
        }
        print_r($arabic);
    }
}
