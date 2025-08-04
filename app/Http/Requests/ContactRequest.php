<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
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
            // 'name' => 'required|string',
            // 'mobile' => 'required|string|max:11',
            'name' => [
                'required',
                'string',
                'min:4',
                'max:50',
                function ($attribute, $value, $fail) {
                    // Check if the name is just repeated characters
                    if (preg_match('/^(.)\\1{2,}$/', $value)) {
                        $fail('The ' . $attribute . ' must be a meaningful name.');
                    }

                    // Check if the name is just random gibberish
                    if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
                        $fail('The ' . $attribute . ' must contain only letters and spaces.');
                    }

                    // Check for sequences that are too long
                    if (preg_match('/(.)\\1{2,}/', $value)) {
                        $fail('The ' . $attribute . ' must be a meaningful name.');
                    }

                    // Check for a reasonable mix of characters (e.g., not just consonants or vowels)
                    if (preg_match('/^[bcdfghjklmnpqrstvwxyz]{4,}$/i', $value) || preg_match('/^[aeiou]{4,}$/i', $value)) {
                        $fail('The ' . $attribute . ' must be a meaningful name.');
                    }
                },
            ],
            'mobile' => ['required', 'string', 'regex:/^(0[0-9]{10}|[0-9]{10})$/'],
            'email' => 'required|string|email',
            'message' => 'required|string|min:25',
        ];
    }
}
