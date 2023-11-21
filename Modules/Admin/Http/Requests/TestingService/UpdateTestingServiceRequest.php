<?php

namespace Modules\Admin\Http\Requests\TestingService;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestingServiceRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
