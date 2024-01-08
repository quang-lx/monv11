<?php

namespace Modules\Admin\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required|numeric',
            'papers' => 'required',
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
            'phone.numeric' => 'Thông tin sai định dạng'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
