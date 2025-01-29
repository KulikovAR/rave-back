<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_phone' => 'required|string|max:15',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'type' => 'required|string|in:Доставка,Самовывоз',
            'customer_name' => 'required|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'street' => 'nullable|string',
            'house' => 'nullable|string',
            'entrance' => 'nullable|string',
            'apartment' => 'nullable|string',
            'comment' => 'nullable|string',
        ];
    }
}
