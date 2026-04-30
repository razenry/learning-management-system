<?php

namespace App\Modules\Subscriptions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ];
    }
}
