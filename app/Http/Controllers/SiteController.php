<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use App\Models\Quotation;
use App\Services\QuotationService;
use App\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function __construct(private RouteService $routeService, private QuotationService $quotationService)
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

    public function contact(Request $request)
    {
        $data = array(
            'to' => array('malickateeq@gmail.com'),
            'subject' => $request->subject,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'msg' => (string)$request->message,
        );
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
            ]
        ]);

        session()->save();

        return redirect(route('get_quote_step2'));
    }

    public function getQuoteStepOneTwo()
    {
        $sessionData = session('quote_data');

        if (!$sessionData || empty($sessionData['ready_to_load_date'])) {
            return redirect(route('index'));
        }

        $data['page_title'] = 'Request a quote | LogistiQuote';
        $data['page_name'] = 'get_quote_step2';

        if ($sessionData['type'] === 'lcl' || $sessionData['transportation_type'] === 'air') {
            return view('frontend.get_quote_lcl', $data);
        } elseif ($sessionData['transportation_type'] === 'sea' && $sessionData['type'] === 'fcl') {
            $data['containers'] = $sessionData['route_containers'];
            return view('frontend.get_quote_fcl', $data);
        } else {
            return redirect()->back();
        }
    }

    public function getQuoteStepThree(Request $request)
    {
        if ($request->file('attachment')) {
            $file_name = rand() . '.' . $request->file('attachment')->getClientOriginalExtension();
            $request->merge(['attachment_file' => $file_name]);
            Storage::disk('public')->putFileAs('temp/', $request->file('attachment'), $file_name);
        }

        $sessionData = session('quote_data', []);


        $updatedData = array_merge($sessionData, $request->all());

        session(['quote_data' => $updatedData]);

        $currentContainers = $this->quotationService->getFormatedContainersData($updatedData);
        $updatedData['current_containers'] = $currentContainers;
        $updatedData['page_title'] = 'Request a quote | LogistiQuote';
        $updatedData['page_name'] = 'get_quote_step3';

        if (!empty($updatedData)) {
            return view('frontend.quotation-summary', $updatedData);
        } else {
            return redirect()->back();
        }
    }

    public function formQuoteFinalStep()
    {
        if (Auth::check()) {
            if (Auth::user()->role != 'user') {
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
