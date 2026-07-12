<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required', 'exists:businesses,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'order_number' => ['required', 'string', 'max:255'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'advance_amount' => ['required', 'numeric', 'min:0'],
            'balance_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:New,In Progress,Ready,Delivered,Cancelled'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
