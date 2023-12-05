<?php

namespace Modules\Admin\Http\Requests\ServiceIndex;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdateServiceIndexRequest extends FormRequest
{
    public function rules()
    {
        $serviceindex = $this->route()->parameter('serviceindex');

        $rules =  [
            'service_id' => "required",
            'code' => "required|unique:testing_service_index,code,{$serviceindex->id}",
            'code_lis' => "required|unique:testing_service_index,code_lis,{$serviceindex->id}",
            'name' => "required",

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
            'service_id.required' => 'Dịch vụ là bắt buộc',
            'name.required' => 'Chỉ số con: Tên dịch vụ là bắt buộc',
            'type.required' => 'Chỉ số con: Loại dịch vụ là bắt buộc',
            'code.required' => 'Chỉ số con: Mã dịch vụ là bắt buộc',
            'code.unique' => 'Chỉ số con: Mã dịch vụ đã tồn tại trên hệ thống',
            'code_lis.required' => 'Chỉ số con: Mã gửi LIS là bắt buộc',
            'code_lis.unique' => 'Chỉ số con: Mã gửi LIS đã tồn tại trên hệ thống'


        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
