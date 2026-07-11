<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'in:Personal,Boutique,Freelance,Software,Investment,Other'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }
}
