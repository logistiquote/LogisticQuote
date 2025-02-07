<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
        return [
            'subject' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) {
                $disposableDomains = ['mailinator.com', 'yopmail.com', 'tempmail.com'];
                $emailDomain = substr(strrchr($value, "@"), 1);

                if (in_array($emailDomain, $disposableDomains)) {
                    $fail('Disposable email addresses are not allowed.');
                }
            }],
            'phone' => ['required', 'string', 'regex:/^\d{8,15}$/', function ($attribute, $value, $fail) {
                if (preg_match('/(\d)\1{6,}/', $value)) {
                    $fail('Invalid phone number.');
                }
            }],
            'message' => ['required', 'string', 'min:10', 'max:1000', 'not_regex:/viagra|casino|bitcoin|loan/i'],
            'g-recaptcha-response' => env('APP_ENV') === 'production' ? ['required'] : [],
        ];
    }
}
