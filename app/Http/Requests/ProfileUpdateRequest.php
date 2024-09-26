<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\Gender;
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
            'name' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'birthday' => ['date', 'nullable'],
            'gender_id' => [Rule::exists(Gender::class, 'id'), 'nullable'],
            'country_id' => [Rule::exists(Country::class, 'id'), 'nullable'],
            'biography' => ['string', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => trans('auth.unique_name'),
            'email.unique' => trans('auth.unique_email'),
        ];
    }
}
