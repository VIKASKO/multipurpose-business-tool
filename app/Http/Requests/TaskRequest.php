<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required', 'exists:businesses,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Pending,In Progress,Completed'],
            'completed_at' => ['nullable', 'date'],
        ];
    }
}
