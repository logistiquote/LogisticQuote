<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetDHLQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'origin_country' => 'required|string|min:2|max:2',
            'origin_postal' => 'required|string|max:12',
            'origin_city' => 'required|string|min:1|max:45',
            'origin_province' => 'nullable|string|min:2|max:35',
            'origin_address_line1' => 'required|string|min:1|max:45',
            'origin_address_line2' => 'nullable|string|min:1|max:45',
            'origin_address_line3' => 'nullable|string|min:1|max:45',
            'origin_county' => 'nullable|string|min:1|max:45',

            'destination_country' => 'required|string|min:2|max:2',
            'destination_postal' => 'required|string|max:12',
            'destination_city' => 'required|string|min:1|max:45',
            'destination_province' => 'nullable|string|min:2|max:35',
            'destination_address_line1' => 'required|string|min:1|max:45',
            'destination_address_line2' => 'nullable|string|min:1|max:45',
            'destination_address_line3' => 'nullable|string|min:1|max:45',
            'destination_county' => 'nullable|string|min:1|max:45',

            'weight' => 'required|numeric|min:0.1|max:999999999999',
            'length' => 'required|numeric|min:1|max:9999999',
            'width' => 'required|numeric|min:1|max:9999999',
            'height' => 'required|numeric|min:1|max:9999999',
            'planned_shipping_date' => 'required|date|after:today|before:+10 days',
        ];
    }


    public function messages(): array
    {
        return [
            'origin_country.required' => 'The origin country is required.',
            'destination_country.required' => 'The destination country is required.',
            'weight.min' => 'The weight must be greater than 0.',
        ];
    }
}
