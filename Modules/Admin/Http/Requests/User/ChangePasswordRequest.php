<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
            'password_old' => 'required',
            'password_new' => 'required|min:6|regex:/^((?!.*[\s])(?=.*[a-zA-Z])(?=.*\d))/' ,
            'password_confirmation' => 'required|same:password_new'
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
            'password_new.required' => 'Mật khẩu mới là bắt buộc',
            'password_old.required' => 'Mật khẩu cũ là bắt buộc',
            'password_new.min' => 'Mật khẩu tối thiểu 8 ký tự',

            'password_new.regex' => 'Mật khẩu phải bao gồm ký tự chữ và số, không được chứa dấu cách',
            'password_confirmation.same' => 'Mật khẩu không trùng khớp',
            'password_confirmation.required' => 'Mật khẩu nhập lại là bắt buộc',

        ];
    }

  

    public function withValidator($validator)
    {
        $user = $this->route()->parameter('user');

        $validator->after(function ($validator) use ($user) {
            $passwordOld = $this->input('password_old');

            // Kiểm tra xem password_old có khớp với password của user hay không
            if (!Hash::check($passwordOld, $user->password)) {
                $validator->errors()->add('password_old', 'Mật khẩu cũ nhập vào không chính xác.');
            }
        });
    }
}
