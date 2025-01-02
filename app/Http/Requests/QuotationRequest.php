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
                    'route_id' => ['required', 'integer', 'exists:routes,id'], // Ensure valid route.
                    'incoterms' => ['required', 'string', 'in:EXW,FOB,CIP,CIF'],
                    'pickup_address' => ['nullable', 'string', 'max:255'],
                    'destination_address' => ['nullable', 'string', 'max:255'],
                    'transportation_type' => ['required', 'string', 'min:3', 'max:50'],
                    'type' => ['required', 'string', 'min:2', 'max:50'],
                    'ready_to_load_date' => ['required', 'date', 'after_or_equal:today'],
                    'value_of_goods' => ['required', 'numeric', 'min:1', 'max:100000000'],
                    'description_of_goods' => ['nullable', 'string', 'max:500'],
                    'calculate_by' => ['required_if:transportation_type,lcl', 'string', 'in:units,weight'],
                    'remarks' => ['nullable', 'string', 'max:500'],
                    'is_stockable' => ['boolean'],
                    'is_dgr' => ['boolean'],
                    'is_clearance_req' => ['boolean'],
                    'insurance' => ['boolean'],
                    'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
                    'container_size' => ['required_if:transportation_type,ocean,type,fcl', 'array'],
                    'container_weight' => ['required_if:transportation_type,ocean,type,fcl', 'array'],
                    'l' => ['required_if:calculate_by,units', 'array'],
                    'w' => ['required_if:calculate_by,units', 'array'],
                    'h' => ['required_if:calculate_by,units', 'array'],
                    'gross_weight' => ['required_if:calculate_by,units', 'array'],
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
