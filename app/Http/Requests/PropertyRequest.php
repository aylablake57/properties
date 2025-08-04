<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:4|max:255',
            'description' => 'required',
            'area_size' => 'required|numeric',
            'price' => 'required|numeric|digits_between:5,10',
            'email' => 'required|email',
            'phone' => 'required|string',
            'landline' => 'nullable|string',
            'city' => 'required',
            'location' => 'required',
            'advance_amount' => 'nullable|numeric|gt:0|lt:price',
            'monthly_installment' => 'nullable|numeric|gt:0|lt:price',
            'latitude' => 'nullable|numeric|between:-90,90', 
            'longitude' => 'nullable|numeric|between:-180,180',
            'subtype' => 'required',

        ];
    }
}
