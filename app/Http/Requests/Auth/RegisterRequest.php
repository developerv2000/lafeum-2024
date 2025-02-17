<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', 'min:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => trans('auth.unique_name'),
            'email.unique' => trans('auth.unique_email'),
            'password.confirmed' => trans('auth.password_confirmation_failed'),
        ];
    }

    /**
     * Prevent non-existent email from registering
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureValidEmail(): void
    {
        $email = $this->input('email');
        $apiKey = 'c52ba285ca6057af2a69604e1739c39240db2eb84d80383588257741256fb70a';
        $url = 'https://verify.maileroo.net/check';

        // Make the HTTP POST request
        $response = Http::timeout(120)->asJson()->post($url, [
            'api_key' => $apiKey,
            'email_address' => $email,
        ]);

        // Handle the response
        if ($response->successful()) {
            $data = $response->json()['data'];
            if (!$data['mx_found'] || !$data['format_valid']) {
                throw ValidationException::withMessages([
                    'email' => trans('auth.incorrect_email'),
                ]);
            }
        }
    }
}
