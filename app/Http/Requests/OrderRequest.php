<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // تأكد من ضبط هذه القيمة بناءً على متطلبات الأمان الخاصة بك
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'bill' => 'nullable|string',
            'shipping_address' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'card_number' => 'nullable|string|max:16', // مثال، قد تحتاج لتعديل القاعدة
            'card_expiry' => 'nullable|string|max:4', // مثال، قد تحتاج لتعديل القاعدة
            'card_cvc' => 'nullable|string|max:4', // مثال، قد تحتاج لتعديل القاعدة
        ];
    }
}
