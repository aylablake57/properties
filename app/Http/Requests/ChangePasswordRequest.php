<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
        // By Asfia
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'same:password']
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Current Password is required',
            'current_password.current_password' => 'The current password you provided is incorrect',
            'password.required' => 'New Password is required',
            'password_confirmation.same:password' => 'The new password confirmation does not match',
            'password_confirmation.required' => 'The password confirmation is required',
        ];
    }


}
