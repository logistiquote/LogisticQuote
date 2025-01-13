<?php

namespace App\Http\Controllers;

use App\Enums\WaterContainerType;
use App\Http\Requests\QuotationRequest;
use App\Mail\QuotationCreated;
use App\Models\Quotation;
use App\Services\QuotationService;
use App\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function __construct(private QuotationService $quotationService, private RouteService $routeService)
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
        $data['containerTypes'] = WaterContainerType::all();

        $allRoutes = $this->routeService->getAllRoutes();
        $data['origins'] = $this->routeService->getUniqueOrigins($allRoutes);
        $data['destinations'] = $this->routeService->getUniqueDestinations($allRoutes);

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

    public function downloadQuotationSummary(Quotation $quotation)
    {
        dd($quotation);
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

    public function storePendingForm()
    {

        if(Auth::user()->role != 'user')
        {
            Storage::disk('public')->delete('store_pending_form.json');
            return redirect(route('quotations.view_all'));
        }

        $fileContents = (array)json_decode(Storage::disk('public')->get('store_pending_form.json'));
        DB::beginTransaction();

        try {

            $quotation = $this->quotationService->createQuotation($fileContents);

            DB::commit();

            if (env('MAIL_ENABLED', false)) {
                Mail::to('mshlafman@gmail.com')->send(new QuotationCreated($quotation));
            }

            return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
