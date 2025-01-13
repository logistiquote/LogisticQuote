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
            'to'      => array('malickateeq@gmail.com'),
            'subject' => $request->subject,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'msg' => (string)$request->message,
        );
        Mail::to($data['to'])->send(new ContactUs($data));

        return redirect()->back();
    }

    public function get_quote_step1(Request $request)
    {
        $data = [
            'type' => $request->type,
            'transportation_type' => $request->transportation_type,
            'route_id' => $request->route_id,
            'ready_to_load_date' => $request->date,
            'route_containers' => $request->route_containers,
        ];

        dd($data);
        $isDelete = Storage::disk('public')->delete('store_pending_form.json');
        Storage::disk('public')->put('store_pending_form.json', json_encode($data));

        session([
            'transportation_type' => $request->transportation_type
        ]);

        session()->save();

        return redirect(route('get_quote_step2'));
    }
    public function get_quote_step2()
    {
        $fileContents = Storage::disk('public')->get('store_pending_form.json');
        $fileContents = json_decode($fileContents);

        if($fileContents->ready_to_load_date == null)
        {
            return redirect(route('index'));
        }

        $data['page_title'] = 'Request a quote | LogistiQuote';
        $data['page_name'] = 'get_quote_step2';

        if($fileContents->type == 'lcl' || $fileContents->transportation_type == 'air')
        {
            return view('frontend.get_quote_lcl', $data);
        }
        else if($fileContents->transportation_type == 'sea' && $fileContents->type == 'fcl')
        {

            $data['containers'] = $fileContents->route_containers;
            return view('frontend.get_quote_fcl', $data);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function getQuoteStepThree(Request $request)
    {
        if($request->file('attachment'))
        {
            $file_name = rand().'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->merge(['attachment_file' => $file_name]);
            $isStore = Storage::disk('public')->putFileAs('temp/', $request->file('attachment'), $file_name);
        }

        $fileContents = Storage::disk('public')->get('store_pending_form.json');
        $fileContents = json_decode($fileContents, true);
        $merge = array_merge($fileContents, $request->all());

        Storage::disk('public')->delete('store_pending_form.json');
        Storage::disk('public')->put('store_pending_form.json', json_encode($merge));

        $fileContents = Storage::disk('public')->get('store_pending_form.json');
        $data = (array)json_decode($fileContents);
        $currentContainers = $this->quotationService->getFormatedContainersData($data);
        $data['current_containers'] = $currentContainers;
        $data['page_title'] = 'Request a quote | LogistiQuote';
        $data['page_name'] = 'get_quote_step3';

        if (!empty($data)){
            return view('frontend.quotation-summary', $data);
        }else{
            return redirect()->back();
        }
    }

    public function formQuoteFinalStep(Request $request)
    {
        if(Auth::check())
        {
            if(Auth::user()->role != 'user')
            {
                Storage::disk('public')->delete('store_pending_form.json');
                return "You are no allowed to perform this action. Only user can add quotation.";
            }
            else
            {
                return redirect()->route('store_pending_form');
            }
        }
        else
        {
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
        $arabic="";
        foreach(file( url('public/trans/variables.json') ) as $line)
        {
            $arabic=$arabic.$line.'+<br>';
        }
        foreach(file( url('public/trans/arabic_translation.json') ) as $line)
        {
            $from = '/'.preg_quote('+', '/').'/';
            $arabic = preg_replace($from, $line, $arabic, 1);
            // print_r( $arabic);
            // return;
        }
        print_r( $arabic);
    }
}
