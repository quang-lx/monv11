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
            'list_service_index.*.name' => 'required',

        ];

        $list_service_index = Request::get('list_service_index', []);
        foreach($list_service_index as $key => $service_index) {
            if ( array_key_exists('id', $service_index) && $service_index['id'] ) { // if have an id, means an update, so add the id to ignore
                $rules = array_merge($rules, ['list_service_index.'.$key.'.code' => 'required|unique:testing_service_index,code,'.$service_index['id']]);
                $rules = array_merge($rules, ['list_service_index.'.$key.'.code_lis' => 'required|unique:testing_service_index,code_lis,'.$service_index['id']]);
            } else {
                $rules = array_merge($rules, ['list_service_index.'.$key.'.code' => 'required|unique:testing_service_index']);
                $rules = array_merge($rules, ['list_service_index.'.$key.'.code_lis' => 'required|unique:testing_service_index']);
            }
        }
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
