<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DHLServiceType;

class CreateDHLShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_type' => 'required|string|in:' . implode(',', array_column(DHLServiceType::cases(), 'value')),
        ];
    }

    public function messages(): array
    {
        return [
            'service_type.required' => 'A service type is required.',
            'service_type.in' => 'Invalid service type. Please select a valid DHL service.',
        ];
    }
}

