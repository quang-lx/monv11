<?php

namespace Modules\Mon\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route()->parameter('user');
        $rules = [
            'password' => 'required|min:8|regex:/^((?!.*[\s])(?=.*[a-zA-Z])(?=.*\d))/' ,
            'password_confirmation' => 'required|same:password'
        ];
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.regex' => 'Mật khẩu phải bao gồm ký tự chữ và số, không được chứa dấu cách',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password_confirmation.same' => 'Mật khẩu không trùng khớp',
            'password_confirmation.required' => 'Mật khẩu nhập lại là bắt buộc',
            'password.min' => 'Mật khẩu tối thiểu 8 ký tự'

        ];
    }
}
