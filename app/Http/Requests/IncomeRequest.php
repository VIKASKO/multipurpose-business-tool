<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required', 'exists:businesses,id'],
            'source_id' => ['required', 'exists:income_sources,id'],
            'account_id' => ['required', 'exists:accounts,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
