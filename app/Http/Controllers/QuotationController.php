<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function __construct()
    {
        //Specify required role for this controller here in checkRole:xyz
        // $this->middleware(['auth', 'checkRole:user']); 
        $this->middleware(['auth', 'verified']); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quotations'] = Quotation::where('user_id', Auth::user()->id)
        ->latest()
        ->get();
        
        $data['page_name'] = 'quotations';
        $data['page_title'] = 'View quotations | LogistiQuote';
        return view('panels.quotation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_name'] = 'create_quotation';
        $data['page_title'] = 'Create quotation | LogistiQuote';
        return view('panels.quotation.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'incoterms' => ['required', 'string', 'min:3', 'max:255'],
            'origin_city' => ['required', 'string', 'min:3', 'max:255'],
            // 'origin_state' => ['required', 'string', 'min:3', 'max:255'],
            'origin_country' => ['required', 'string', 'min:3', 'max:255'],
            'origin_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'destination_city' => ['required', 'string', 'min:3', 'max:255'],
            // 'destination_state' => ['required', 'string', 'min:3', 'max:255'],
            'destination_country' => ['required', 'string', 'min:3', 'max:255'],
            'destination_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255'],
            'ready_to_load_date' => ['required', 'string', 'min:3', 'max:255'],
            'value_of_goods' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'calculate_by' => ['required', 'string', 'min:3', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $quotation = new Quotation;
        $quotation->user_id = Auth::user()->id;
        $quotation->quotation_id = mt_rand();
        $quotation->origin = $request->origin_city.', '.$request->origin_state.', '.$request->origin_country.'. '.$request->origin_zip;
        $quotation->destination = $request->destination_city.', '.$request->destination_state.', '.$request->destination_country.'. '.$request->destination_zip;
        $quotation->origin_zip = $request->origin_zip;
        $quotation->destination_zip = $request->destination_zip;
        $quotation->transportation_type = $request->transportation_type;
        $quotation->type = $request->type;
        $ready_to_load_date = Carbon::createFromFormat('d-m-Y', $request->ready_to_load_date );
        $quotation->ready_to_load_date = $ready_to_load_date->addMinutes(1);
        $quotation->incoterms = $request->incoterms;
        if($request->incoterms == 'EXW')
        {
            $quotation->pickup_address = $request->pickup_address;
            $quotation->destination_address = $request->final_destination_address;
        }
        
        $quotation->value_of_goods = $request->value_of_goods;
        $quotation->description_of_goods = $request->description_of_goods;
        $quotation->isStockable = $request->isStockable ? $request->isStockable : 'No';
        $quotation->isDGR = $request->isDGR ? $request->isDGR : 'No';
        $quotation->calculate_by = $request->calculate_by;
        $quotation->remarks = $request->remarks;
        $quotation->isClearanceReq = $request->isClearanceReq ? $request->isClearanceReq : 'No';
        $quotation->insurance = $request->insurance ? $request->insurance : 'No';
        
        // Store file
        if($request->file('attachment'))
        {
            $file_name = rand().'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->merge(['attachment_file' => $file_name]);
            $isStore = Storage::disk('public')->putFileAs('files/', $request->file('attachment'), $file_name);
            $quotation->attachment = $file_name;
        }

        if($request->transportation_type == 'ocean' && $request->type == 'fcl')
        {   
            $total_containers = count($request->container_size);
            for($c=0 ;$c<count($request->container_size); $c++)
            {
                $container_size[] = [
                    'container_no' => $c+1,
                    'size' => $request->container_size[$c],
                    'weight' => $request->container_weight[$c],
                ];
            }
            $quotation->containers = $container_size;
            $quotation->total_containers = $total_containers;
        }

        if($request->calculate_by == 'units')
        {
            $pallets = [];
            $quantity = count($request->l);
            $total_weight = 0;
            for($i=0; $i<count($request->l); $i++)
            {
                $volumetric_weight = 
                ( (float)$request->l[$i] * (float)$request->w[$i] * (float)$request->h[$i] ) / 6000;
                $pallets[] = [
                    'length' => $request->l[$i],
                    'width' => $request->w[$i],
                    'height' => $request->h[$i],
                    'volumetric_weight' => $volumetric_weight,
                    'gross_weight' => $request->gross_weight[$i],
                ];
                $total_weight += $volumetric_weight;
            }
            $quotation->pallets = $pallets;
            $quotation->quantity = $quantity;
            $quotation->total_weight = number_format($total_weight, 2);
        }
        else
        {
            $quotation->quantity = $request->quantity;
            $quotation->total_weight = $request->total_weight;
        }
        $quotation->save();

        // Send quotation to vendors
        notify_vendor_for_new_quotation($quotation->user_id, $quotation->id);

        return redirect(route('quotation.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['quotation'] = Quotation::where('id', $id)->first();
        if($data['quotation']->attachment != null)
        {
            $data['attachment_url'] = asset( 'public/storage/files/'.$data['quotation']->attachment);
        }
        $data['page_name'] = 'view_quotation';
        $data['page_title'] = 'View quotation | LogistiQuote';

        return view('panels.quotation.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['quotation'] = Quotation::where('id', $id)->first();
        if($data['quotation']->user_id != Auth::user()->id)
        {
            return redirect(route('quotation.index'));
        }
        $data['page_name'] = 'edit_quotation';
        $data['page_title'] = 'Edit quotation | LogistiQuote';
        return view('panels.quotation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'incoterms' => ['required', 'string', 'min:3', 'max:255'],
            'origin' => ['required', 'string', 'min:3', 'max:255'],
            // 'origin_state' => ['required', 'string', 'min:3', 'max:255'],
            // 'origin_country' => ['required', 'string', 'min:3', 'max:255'],
            // 'origin_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'destination' => ['required', 'string', 'min:3', 'max:255'],
            // 'destination_state' => ['required', 'string', 'min:3', 'max:255'],
            // 'destination_country' => ['required', 'string', 'min:3', 'max:255'],
            // 'destination_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255'],
            'ready_to_load_date' => ['required', 'string', 'min:3', 'max:255'],
            'value_of_goods' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'calculate_by' => ['required', 'string', 'min:3', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $quotation = Quotation::findOrFail($request->id);
        $quotation->origin = $request->origin;
        $quotation->destination = $request->destination;
        $quotation->transportation_type = $request->transportation_type;
        $quotation->type = $request->type;
        $ready_to_load_date = Carbon::createFromFormat('d-m-Y', $request->ready_to_load_date );
        $quotation->ready_to_load_date = $ready_to_load_date->addMinutes(1);
        $quotation->incoterms = $request->incoterms;
        if($request->incoterms == 'EXW')
        {
            $quotation->pickup_address = $request->pickup_address;
            $quotation->destination_address = $request->final_destination_address;
        }

        
        // Delete existing 

        // Store file
        if($request->file('attachment'))
        {
            $file_name = rand().'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->merge(['attachment_file' => $file_name]);
            $isStore = Storage::disk('public')->putFileAs('files/', $request->file('attachment'), $file_name);
            $quotation->attachment = $file_name;
        }
        
        $quotation->value_of_goods = $request->value_of_goods;
        $quotation->description_of_goods = $request->description_of_goods;
        $quotation->isStockable = $request->isStockable ? $request->isStockable : 'No';
        $quotation->isDGR = $request->isDGR ? $request->isDGR : 'No';
        $quotation->calculate_by = $request->calculate_by;
        $quotation->remarks = $request->remarks;
        $quotation->isClearanceReq = $request->isClearanceReq ? $request->isClearanceReq : 'No';
        $quotation->insurance = $request->insurance ? $request->insurance : 'No';
        
        $quotation->total_weight = $request->total_weight;

        if($request->transportation_type == 'sea' && $request->type == 'fcl')
        {
            $total_containers = count($request->container_size);
            for($c=0 ;$c<count($request->container_size); $c++)
            {
                $container_size[] = [
                    'container_no' => $c+1,
                    'size' => $request->container_size[$c],
                    'weight' => $request->container_weight[$c],
                ];
            }
            $quotation->containers = $container_size;
            $quotation->total_containers = $total_containers;
        }
        if($request->calculate_by == 'units')
        {
            $pallets = [];
            $quantity = count($request->l);
            $total_weight = 0;
            for($i=0; $i<count($request->l); $i++)
            {
                $volumetric_weight = 
                ( (float)$request->l[$i] * (float)$request->w[$i] * (float)$request->h[$i] ) / 6000;
                $pallets[] = [
                    'length' => $request->l[$i],
                    'width' => $request->w[$i],
                    'height' => $request->h[$i],
                    'volumetric_weight' => $volumetric_weight,
                    'gross_weight' => $request->gross_weight[$i],
                ];
                $total_weight += $volumetric_weight;
            }
            $quotation->pallets = $pallets;
            $quotation->quantity = $quantity;
            $quotation->total_weight = number_format($total_weight, 2);
        }
        else
        {
            $quotation->total_weight = $request->total_weight;
            $quotation->quantity = $request->quantity;
        }
        $quotation->save();
        return redirect(route('quotation.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id); 
        $quotation->status = 'withdrawn';
        $quotation->save();
        return redirect(route('quotation.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_all()
    {
        $data['quotations'] = Quotation::latest()->get();
        $data['page_name'] = 'quotations';
        $data['page_title'] = 'View quotations | LogistiQuote';
        return view('panels.quotation.search_quotations', $data);
    }
    public function search(Request $request)
    {
        // dd( $request->all() );

        $origin = $request->origin;
        $destination = $request->destination;
        $isStockable = $request->isStockable;
        $isDGR = $request->isDGR;
        $transportation_type = $request->transportation_type;
        $type = $request->type;
        $isClearanceReq = $request->isClearanceReq;

        $data['quotations'] = Quotation::
        where(function ($q) use($origin) {
            if ($origin) {
                $q->where('origin', 'LIKE', "%{$origin}%");
            }
        })
        ->orWhere(function ($q) use($destination) {
            if ($destination) {
                $q->where('destination', 'LIKE', "%{$destination}%");
            }
        })
        ->orWhere(function ($q) use($isStockable) {
            if ($isStockable) {
                $q->where('isStockable', 'LIKE', "%{$isStockable}%" );
            }
        })
        ->orWhere(function ($q) use($isDGR) {
            if ($isDGR) {
                $q->where('isDGR', 'LIKE', "%{$isDGR}%" );
            }
        })
        ->orWhere(function ($q) use($transportation_type) {
            if ($transportation_type) {
                $q->where('transportation_type', 'LIKE', "%{$transportation_type}%" );
            }
        })
        ->orWhere(function ($q) use($type) {
            if ($type) {
                $q->where('type', 'LIKE', "%{$type}%" );
            }
        })
        ->orWhere(function ($q) use($isClearanceReq) {
            if ($isClearanceReq) {
                $q->where('isClearanceReq', 'LIKE', "%{$isClearanceReq}%" );
            }
        })
        ->latest()
        ->get();

        $data['page_name'] = 'quotations';
        $data['page_title'] = 'View quotations | LogistiQuote';
        return view('panels.quotation.search_quotations', $data);
    }

    public function store_pending_form()
    {
        if(Auth::user()->role != 'user')
        {
            $isDelete = Storage::disk('public')->delete('store_pending_form.json');
            return redirect(route('quotations.view_all'));
        }

        $fileContents = Storage::disk('public')->get('store_pending_form.json');
        $fileContents = json_decode($fileContents);

        // if(!Auth::check())
        // {
        //     Cache::put('pending_task', 'store_pending_form');
        //     return redirect(route('login'));
        // }
        
        $quotation = new Quotation;
        $quotation->user_id = Auth::user()->id;
        $quotation->quotation_id = mt_rand();
        $quotation->origin = $fileContents->origin;
        $quotation->destination = $fileContents->destination;
        $quotation->transportation_type = $fileContents->transportation_type;
        $quotation->type = $fileContents->type;
        $quotation->incoterms = $fileContents->incoterms;

        // Store file
        if(isset($fileContents->attachment_file))
        {
            $move = Storage::disk('public')->move( 'temp/'.$fileContents->attachment_file, 'files/'.$fileContents->attachment_file );

            $quotation->attachment = $fileContents->attachment_file;
        }

        if($fileContents->incoterms == 'EXW')
        {
            $quotation->pickup_address = $fileContents->pickup_address;
            $quotation->destination_address = $fileContents->final_destination_address;
        }

        $ready_to_load_date = Carbon::createFromFormat('d-m-Y', $fileContents->ready_to_load_date );
        $quotation->ready_to_load_date = $ready_to_load_date->addMinutes(1);

        $quotation->value_of_goods = $fileContents->value_of_goods;
        $quotation->description_of_goods = $fileContents->description_of_goods;
        $quotation->isStockable = isset($fileContents->isStockable) ? $fileContents->isStockable : 'No';
        $quotation->isDGR = isset($fileContents->isDGR) ? $fileContents->isDGR : 'No';
        $quotation->calculate_by = $fileContents->calculate_by;
        $quotation->remarks = $fileContents->remarks;
        $quotation->isClearanceReq = isset($fileContents->isClearanceReq) ? $fileContents->isClearanceReq : 'No';
        $quotation->insurance = isset($fileContents->insurance) ? $fileContents->insurance : 'No';
        

        if($fileContents->transportation_type == 'sea' && $fileContents->type == 'fcl')
        {
            $total_containers = count($fileContents->container_size);
            for($c=0 ;$c<count($fileContents->container_size); $c++)
            {
                $container_size[] = [
                    'container_no' => $c+1,
                    'size' => $fileContents->container_size[$c],
                    'weight' => $fileContents->container_weight[$c],
                ];
            }
            $quotation->containers = $container_size;
            $quotation->total_containers = $total_containers;
        }
        if($fileContents->calculate_by == 'units')
        {
            $pallets = [];
            $quantity = count($fileContents->l);
            $total_weight = 0;
            for($i=0; $i<count($fileContents->l); $i++)
            {
                $volumetric_weight = 
                ( (float)$fileContents->l[$i] * (float)$fileContents->w[$i] * (float)$fileContents->h[$i] ) / 6000 ;
                $pallets[] = [
                    'length' => $fileContents->l[$i],
                    'width' => $fileContents->w[$i],
                    'height' => $fileContents->h[$i],
                    'volumetric_weight' => $volumetric_weight,
                    'gross_weight' => $fileContents->gross_weight[$i],
                ];
                $total_weight += $volumetric_weight;
            }
            $quotation->pallets = $pallets;
            $quotation->quantity = $quantity;
            $quotation->total_weight = number_format($total_weight, 2);
        }
        else
        {
            $quotation->quantity = $fileContents->quantity;
            $quotation->total_weight = $fileContents->total_weight;
        }
        $quotation->save();
        $isDelete = Storage::disk('public')->delete('store_pending_form.json');

        
        // Send quotation to vendors
        notify_vendor_for_new_quotation($quotation->user_id, $quotation->id);

        return redirect(route('quotation.index'));
    }
}
