<?php

namespace Modules\Admin\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomersRequest extends FormRequest
{
    public function rules()
    {
        $customers = $this->route()->parameter('customers');
        $rules = [
            'username' => "required|unique:customers,username,{$customers->id}",
            'name' => 'required',
            'phone' => "required|unique:customers,phone,{$customers->id}",
            'email' => "required|unique:customers,email,{$customers->id}|email",
            'password' => 'required|min:6',
        ];


        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => 'Tài khoản'
        ];
    }
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại là bắt buộc',
            'username.required' => 'Tài khoản là bắt buộc',
            'username.unique' => 'Tài khoản đã tồn tại trên hệ thống',
            'name.required' => 'Tên khách hàng là bắt buộc',
            'email.unique' => 'Email đã được sử dụng',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email sai định dạng',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password_confirmation.same' => 'Xác nhận mật khẩu không đúng',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống',
            'password.same' => 'Xác nhận mật khẩu không đúng',
        ];
    }
}
