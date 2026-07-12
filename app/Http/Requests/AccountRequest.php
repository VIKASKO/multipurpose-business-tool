<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required', 'exists:businesses,id'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_type' => ['required', 'in:Cash,Bank,UPI,Wallet,Business Account'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
