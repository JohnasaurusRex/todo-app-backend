<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'sometimes|boolean',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }
}
