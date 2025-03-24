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
        $airQuoteData = session('air_quote_data', []);

        $mergedRequest = $request->merge($airQuoteData);

        $validated = $mergedRequest->validated();

        $dimension = [
            'length' => $validated['length'],
            'width' => $validated['width'],
            'height' => $validated['height'],
            'weight' => $validated['weight'],
        ];
        try {
            $quote = $this->dhlExpressService->getQuote(
            // Origin details
                [
                    'origin_country' => $validated['origin_country'],
                    'origin_city' => $validated['origin_city'],
                    'origin_postal_code' => $validated['origin_postal_code'],
                ],
                // Destination details
                [
                    'destination_country' => $validated['destination_country'],
                    'destination_city' => $validated['destination_city'],
                    'destination_postal_code' => $validated['destination_postal_code'],
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

            $updatedData = array_merge($validated, $quote);

            session(['air_quote_data' => $updatedData]);
            session()->save();

            return view('dhl.quote', compact('quote', 'dimension'));

        } catch (DHLApiException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function getQuoteFormation(Request $request)
    {
        $DHLQuoteData = [
                'origin_country' => $request->originCountryCode,
                'origin_city' => $request->originCityName,
                'destination_country' => $request->destinationCountryCode,
                'destination_city' => $request->destinationCityName,
        ];

        return view('dhl.quote-formation', compact('DHLQuoteData'));
    }
}
