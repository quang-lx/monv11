<?php

namespace Modules\Admin\Http\Requests\Packages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackagesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'period_time' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
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
            'name.required' => 'Tên là bắt buộc',
            'period_time.required' => 'Số tháng là bắt buộc',
            'period_time.numeric' => 'Số tháng phải là số',
            'period_time.min' => 'Số tháng phải lớn hơn 0',

            'price.required' => 'Số tiền là bắt buộc',
            'price.numeric' => 'Số tiền phải là số',
            'price.min' => 'Số tiền phải lớn hơn 0',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
