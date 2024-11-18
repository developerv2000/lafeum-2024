<?php

namespace App\Http\Requests;

use App\Models\TermType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TermUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'term_type_id' => Rule::exists(TermType::class, 'id'),
        ];
    }
}
