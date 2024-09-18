<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    protected $redirect = '/profile/edit#password-update';
    protected $errorBag = 'updatePassword';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => trans('auth.password_confirmation_failed'),
        ];
    }
}
