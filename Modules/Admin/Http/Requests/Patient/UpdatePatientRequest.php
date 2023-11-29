<?php

namespace Modules\Admin\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
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
            'name.required' => 'Họ và tên là bắt buộc',
            'sex.required' => 'Giới tính là bắt buộc',
            'birthday.required' => 'Năm sinh là bắt buộc',
            'phone.required' => 'Số điện thoại là bắt buộc',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
