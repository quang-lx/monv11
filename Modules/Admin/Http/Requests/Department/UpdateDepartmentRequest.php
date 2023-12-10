<?php

namespace Modules\Admin\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules()
    {
        $department = $this->route()->parameter('department');
        return [
            'name' => "required|unique:department,name,{$department->id}",
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
            'name.required' => 'Tên nhóm là bắt buộc',
            'name.unique' => 'Tên nhóm đã tồn tại'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
