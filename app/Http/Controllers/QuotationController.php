<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationRequest;
use App\Models\Quotation;
use App\Models\Route;
use App\Services\QuotationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function __construct(private QuotationService $quotationService)
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $data['quotations'] = Quotation::where('user_id', Auth::user()->id)
        ->latest()
        ->get();

        $data['page_name'] = 'quotations';
        $data['page_title'] = 'View quotations | LogistiQuote';
        return view('panels.quotation.index', $data);
    }

    public function create()
    {
        $data['page_name'] = 'create_quotation';
        $data['page_title'] = 'Create quotation | LogistiQuote';
        // Fetch all routes with related origin and destination
        $allRoutes = Route::with(['origin', 'destination'])->get();

        // Get unique origins
        $origins = $allRoutes->unique('origin_id')->map(function ($route) {
            return [
                'id' => $route->origin_id,
                'destination_id' => $route->destination_id,
                'full_location' => $route->origin->full_location,
            ];
        });

        // Get unique destinations
        $destinations = $allRoutes->unique('destination_id')->map(function ($route) {
            return [
                'id' => $route->destination_id,
                'origin_id' => $route->origin_id,
                'full_location' => $route->destination->full_location,
            ];
        });

        $data['origins'] = $origins;
        $data['destinations'] = $destinations;

        return view('panels.quotation.create', $data);
    }

    public function store(QuotationRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->quotationService->createQuotation($request->validated());
            DB::commit();

            return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

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

    public function update(QuotationRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->quotationService->updateQuotation($id, $request->validated());
            DB::commit();

            return redirect()->route('quotation.index')->with('success', 'Quotation updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->quotationService->withdrawQuotation($id);
            DB::commit();

            return redirect()->route('quotation.index')->with('success', 'Quotation withdrawn successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

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
            Storage::disk('public')->delete('store_pending_form.json');
            return redirect(route('quotations.view_all'));
        }

        $fileContents = Storage::disk('public')->get('store_pending_form.json');
        $fileContents = json_decode($fileContents);

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
            Storage::disk('public')->move( 'temp/'.$fileContents->attachment_file, 'files/'.$fileContents->attachment_file );

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
        Storage::disk('public')->delete('store_pending_form.json');

        return redirect(route('quotation.index'));
    }
}
