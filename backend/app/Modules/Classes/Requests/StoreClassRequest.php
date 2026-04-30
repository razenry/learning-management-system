<?php

namespace App\Modules\Classes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'teacher_id' => ['nullable', 'exists:users,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}
