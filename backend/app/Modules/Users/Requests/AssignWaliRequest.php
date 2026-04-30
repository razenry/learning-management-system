<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignWaliRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:users,id'],
            'wali_id' => ['required', 'exists:users,id'],
        ];
    }
}
