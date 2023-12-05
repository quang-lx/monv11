<?php

namespace Modules\Admin\Http\Requests\TestingService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdateTestingServiceRequest extends FormRequest
{
    public function rules()
    {
        $testingservice = $this->route()->parameter('testingservice');

        $rules =  [
            'code' => "required|unique:testing_service,code,{$testingservice->id}",
            'code_lis' => "required|unique:testing_service,code_lis,{$testingservice->id}",
            'name' => "required",
            'type' => "required",

        ];


        return $rules;
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
            'code.required' => 'Mã dịch vụ là bắt buộc',
            'code.unique' => 'Mã dịch vụ đã tồn tại trên hệ thống',
            'code_lis.required' => 'Mã gửi LIS là bắt buộc',
            'code_lis.unique' => 'Mã gửi LIS đã tồn tại trên hệ thống',
            'name.required' => 'Tên dịch vụ là bắt buộc',
            'type.required' => 'Loại dịch vụ là bắt buộc',


        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
