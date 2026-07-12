<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required', 'exists:businesses,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'project_name' => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'project_value' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Planning,Active,Testing,Completed,Cancelled'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
