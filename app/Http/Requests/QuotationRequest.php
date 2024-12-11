<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->route()->getActionMethod()) {
            case 'store':
                return [
                    'incoterms' => ['required', 'string', 'in:EXW,FOB,CIP/CIF'], // Use real incoterms standards.
                    'origin_city' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/', 'max:100'], // City names typically contain letters, spaces, and dashes.
                    'origin_country' => ['required', 'string', 'size:2'], // Use ISO 3166-1 alpha-2 country codes (e.g., US, GB).
                    'origin_zip' => ['required', 'string', 'regex:/^\d{4,10}$/'], // ZIP codes vary by country but typically have a specific digit format.
                    'destination_city' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/', 'max:100'],
                    'destination_country' => ['required', 'string', 'size:2'], // ISO 3166-1 alpha-2.
                    'destination_zip' => ['required', 'string', 'regex:/^\d{4,10}$/'],
                    'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
                    'type' => ['required', 'string', 'min:2', 'max:255'],
                    'ready_to_load_date' => ['required', 'date', 'after_or_equal:today'], // Should be a valid date not earlier than today.
                    'value_of_goods' => ['required', 'numeric', 'min:1', 'max:9999999'], // Minimum $1, max $100M for realistic limits.
                    'calculate_by' => ['required', 'string',  'min:3', 'max:255'],

                ];
            case 'update':
                return [
                    'incoterms' => ['required', 'string', 'min:3', 'max:255'],
                    'origin' => ['required', 'string', 'min:3', 'max:255'],
                    'destination' => ['required', 'string', 'min:3', 'max:255'],
                    'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
                    'type' => ['required', 'string', 'min:2', 'max:255'],
                    'ready_to_load_date' => ['required', 'string', 'min:3', 'max:255'],
                    'value_of_goods' => ['required', 'numeric', 'min:3', 'max:9999999'],
                    'calculate_by' => ['required', 'string', 'min:3', 'max:255'],
                ];
            default:
                return [];
        }
    }

}
