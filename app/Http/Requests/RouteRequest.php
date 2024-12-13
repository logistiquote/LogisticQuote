<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->route()->getActionMethod()) {
            'store' => [
                'origin_id' => 'required|exists:locations,id',
                'destination_id' => 'required|exists:locations,id',
                'type' => 'required|string|in:water',
                'containers' => 'required|array',
                'containers.*.type' => 'required|string',
                'containers.*.price' => 'required|numeric|min:0',
            ],
            default => [],
        };
    }
}
