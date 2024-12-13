<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationImportRequest extends FormRequest
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
        return match ($this->route()->getActionMethod()) {
            'importLocations' => [
                'type' => ['required', 'string', 'in:water'],
                'file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
            ],
            default => [],
        };
    }
}
