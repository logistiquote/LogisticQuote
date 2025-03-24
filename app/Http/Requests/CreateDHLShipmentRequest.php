<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateDHLShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Shipper Details
            'origin_full_name' => 'required|string|max:100',
            'origin_company_name' => 'required|string|max:100',
            'origin_postal_code' => 'required|string|max:12',
            'origin_address_line1' => 'required|string|max:255',
            'origin_contact_email' => 'required|email|max:255',
            'origin_contact_phone' => 'required|string|max:20',

            // Receiver Details
            'destination_full_name' => 'required|string|max:100',
            'destination_company_name' => 'required|string|max:100',
            'destination_postal_code' => 'required|string|max:12',
            'destination_address_line1' => 'required|string|max:255',
            'destination_contact_email' => 'required|email|max:255',
            'destination_contact_phone' => 'required|string|max:20',

            // Additional Information
            'description' => 'required|string|max:255',
            'declared_value' => 'required|numeric|min:0',
            'declared_value_currency' => 'required|string|in:USD,EUR,ILS',

            'invoice_pdf' => 'required|file|mimes:pdf|max:2048',

            'service' => 'required',

            // Invoice Details
            'invoice.number' => 'required|string|max:50',
            'invoice.date' => 'required|date',

            // Line Items (must have at least one)
            'lineItems' => 'required|array|min:1',
            'lineItems.*.description' => 'required|string|max:255',
            'lineItems.*.price' => 'required|numeric|min:0',
            'lineItems.*.quantity.value' => 'required|integer|min:1',
            'lineItems.*.quantity.unitOfMeasurement' => 'required|string|in:PCS,KG',
            'lineItems.*.manufacturerCountry' => 'required|string|size:2', // ISO country code
            'lineItems.*.weight.netValue' => 'required|numeric|min:0',
            'lineItems.*.weight.grossValue' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'service.required' => 'A service type is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $previousUrl = url()->previous(); // Get the previous URL

        throw new HttpResponseException(
            redirect($previousUrl) // Redirect back to the previous page
            ->withErrors($validator)
                ->withInput()
        );
    }
}

