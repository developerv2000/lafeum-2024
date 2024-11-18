<?php

namespace App\Http\Requests;

use App\Support\Helpers\ModelHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $model = $this->route('model');
        $namespacedModel = ModelHelper::addFullNamespaceToModelBasename($model);

        return [
            'name' => [Rule::unique($namespacedModel)],
        ];
    }
}
