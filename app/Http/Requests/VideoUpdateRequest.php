<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'channel_id' => Rule::exists(Channel::class, 'id'),
        ];
    }
}
