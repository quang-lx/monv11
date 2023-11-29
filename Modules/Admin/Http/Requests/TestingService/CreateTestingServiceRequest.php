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
            'list_service_index.*.name' => 'required',
            'list_service_index.*.type' => 'required',
            'list_service_index.*.code' => 'required|unique:testing_service_index',
            'list_service_index.*.code_lis' => 'required|unique:testing_service_index'
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
            'code.required' => 'Mã dịch vụ là bắt buộc',
            'code.unique' => 'Mã dịch vụ đã tồn tại trên hệ thống',
            'code_lis.required' => 'Mã gửi LIS là bắt buộc',
            'code_lis.unique' => 'Mã gửi LIS đã tồn tại trên hệ thống',
            'name.required' => 'Tên dịch vụ là bắt buộc',
            'type.required' => 'Loại dịch vụ là bắt buộc',
            'list_service_index.*.name.required' => 'Chỉ số con: Tên dịch vụ là bắt buộc',
            'list_service_index.*.type.required' => 'Chỉ số con: Loại dịch vụ là bắt buộc',
            'list_service_index.*.code.required' => 'Chỉ số con: Mã dịch vụ là bắt buộc',
            'list_service_index.*.code.unique' => 'Chỉ số con: Mã dịch vụ đã tồn tại trên hệ thống',
            'list_service_index.*.code_lis.required' => 'Chỉ số con: Mã gửi LIS là bắt buộc',
            'list_service_index.*.code_lis.unique' => 'Chỉ số con: Mã gửi LIS đã tồn tại trên hệ thống'

        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
