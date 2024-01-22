<?php

namespace Modules\Admin\Http\Requests\TestingService;

use Illuminate\Foundation\Http\FormRequest;

class CreateTestingServiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => "required|unique:testing_service",
            'code_lis' => "required|unique:testing_service",
            'name' => "required",
            'type' => "required",

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
            '*.required' => 'Thông tin này là trường bắt buộc',
            'code.unique' => 'Mã dịch vụ đã tồn tại trên hệ thống',

        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
