<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comments' => 'nullable|string|max:1500',
            'suggestions' => 'nullable|string|max:1500',
            'rating' => 'required',
        ];
    }
}
