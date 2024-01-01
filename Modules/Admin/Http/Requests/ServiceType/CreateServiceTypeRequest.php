<?php

namespace Modules\Admin\Http\Requests\ServiceType;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => "required|unique:service_type",
            'name' => "required",
        ];
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
        return [
            '*.required' => 'Thông tin này là bắt buộc',
            'code.unique' => 'Thông tin này đã tồn tại trên hệ thống',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
