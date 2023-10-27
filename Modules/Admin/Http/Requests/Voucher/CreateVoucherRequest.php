<?php

namespace Modules\Admin\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class CreateVoucherRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
            'range_time' => 'required',
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
            'amount.required' => 'Số lượng là bắt buộc',
            'amount.numeric' => 'Số lượng phải là số',
            'amount.min' => 'Số lượng phải lớn hơn 0',
            'range_time.required' => 'Thời gian là bắt buộc',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
