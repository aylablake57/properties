<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => ['required', 'string', 'max:255'],
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
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'landline' => ['nullable', 'string', 'regex:/^\d+$/'],
            'city_id' => ['required'],
            'profile_image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024','dimensions:min_width=200,min_height=200,ratio=1/1'],
            'facebook_id' => ['nullable', 'url:http,https'],
            'instagram' => ['nullable', 'url:http,https'],
            'linkedin' => ['nullable', 'url:http,https'],
            'youtube' => ['nullable', 'url:http,https'],
            'about' => ['nullable'], 
        ];
    }
}
