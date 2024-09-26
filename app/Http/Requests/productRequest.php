<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|',
            'description'   => 'required',
            'category_id'   => 'required|exists:categories,id',
            'image'         => 'required|',
            'price'         => 'required|integer',
            'weight'        => 'required|integer',
            'quantity'      => 'required|integer'
        ];
    }
}
