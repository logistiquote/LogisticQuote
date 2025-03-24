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
            'origin_country' => 'required|string|size:2',
            'origin_city' => 'required|string|min:1|max:45',
            'origin_postal_code' => 'required|string|min:1|max:45',

            'destination_country' => 'required|string|size:2',
            'destination_city' => 'required|string|min:1|max:45',
            'destination_postal_code' => 'required|string|min:1|max:45',

            'weight' => 'required|numeric|min:0.1|max:1000',
            'length' => 'required|numeric|min:1|max:300',
            'width' => 'required|numeric|min:1|max:120',
            'height' => 'required|numeric|min:1|max:160',

            'planned_shipping_date' => 'required|date|after:today|before_or_equal:' . now()->addDays(10)->toDateString(),

        ];
    }


    public function messages(): array
    {
        return [
            'origin_country.required' => 'The origin country is required.',
            'destination_country.required' => 'The destination country is required.',
            'weight.min' => 'The weight must be greater than 0.',
            'length.min' => 'The length must be greater than 0.',
            'width.min' => 'The width must be greater than 0.',
            'height.min' => 'The height must be greater than 0.',
        ];
    }
}
