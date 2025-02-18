<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetDHLQuoteRequest;
use App\Services\DHLExpressService;
use App\Exceptions\DHLApiException;
use Illuminate\Http\Request;

class DHLExpressController extends Controller
{
    public function __construct(protected DHLExpressService $dhlExpressService)
    {
    }

    public function getQuote(GetDHLQuoteRequest $request)
    {
        $validated = $request->validated();

        try {
            $quote = $this->dhlExpressService->getQuote(
            // Origin details
                [
                    'country' => $validated['origin_country'],
                    'postal_code' => $validated['origin_postal'],
                    'city' => $validated['origin_city'],
                    'province' => $validated['origin_province'] ?? null,
                    'address_line1' => $validated['origin_address_line1'],
                    'address_line2' => $validated['origin_address_line2'] ?? null,
                    'address_line3' => $validated['origin_address_line3'] ?? null,
                    'county' => $validated['origin_county'] ?? null,
                ],
                // Destination details
                [
                    'country' => $validated['destination_country'],
                    'postal_code' => $validated['destination_postal'],
                    'city' => $validated['destination_city'],
                    'province' => $validated['destination_province'] ?? null,
                    'address_line1' => $validated['destination_address_line1'],
                    'address_line2' => $validated['destination_address_line2'] ?? null,
                    'address_line3' => $validated['destination_address_line3'] ?? null,
                    'county' => $validated['destination_county'] ?? null,
                ],
                // Package details
                $validated['weight'],
                [
                    'length' => $validated['length'],
                    'width' => $validated['width'],
                    'height' => $validated['height']
                ],
                $validated['planned_shipping_date']
            );

            return view('dhl.quote', compact('quote'));

        } catch (DHLApiException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function getQuoteFormation(Request $request)
    {
        $DHLQuoteData = [
                'origin_country' => $request->origin_country,
                'origin_postal' => $request->origin_postal,
                'destination_country' => $request->destination_country,
                'destination_postal' => $request->destination_postal,
        ];

        return view('dhl.quote-formation', compact('DHLQuoteData'));
    }
}
