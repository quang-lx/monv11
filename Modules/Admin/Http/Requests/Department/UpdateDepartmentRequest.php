<?php

namespace Modules\Admin\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required'
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
            'title.required' => 'Tên nhóm là bắt buộc'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
