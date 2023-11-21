<?php

namespace Modules\Admin\Http\Requests\Disease;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiseaseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required'
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
            'name.required' => 'Tên bệnh là bắt buộc',
            'code.required' => 'Mã bệnh là bắt buộc'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
