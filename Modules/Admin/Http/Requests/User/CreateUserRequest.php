<?php

namespace Modules\Admin\Http\Requests\User;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Mon\Entities\User;


class CreateUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {

    }
    public function rules()
    {

        $rules = [

            'username'=>"unique:users",
            'name'=>"required",
            'sex'=>"required",
            'active_at'=>"required",
            'expired_at'=>"required",

            'email' => 'nullable|email',
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
            '*.required' => 'Thông tin này là bắt buộc',
            'username.unique' => 'Tài khoản đã tồn tại trên hệ thống',
            // 'name.required' => 'Tên là bắt buộc',
            // 'sex.required' => 'Giới tính là bắt buộc',
            // 'department_id.required' => 'Đơn vị là bắt buộc',
            // 'active_at.required' => 'Thời gian hiệu lực của tài khoản là bắt buộc',
            // 'expired_at.required' => 'Thời gian hiệu lực của tài khoản là bắt buộc',
            'email.unique' => 'Thông tin đã được sử dụng',
            // 'email.required' => 'Email là bắt buộc',
            'email.email' => 'Thông tin sai định dạng',

            'phone.unique' => 'Thông tin đã được sử dụng',
            // 'phone.required' => 'Thông tin là bắt buộc',
            'phone.regex' => 'Thông tin chỉ dược nhập là số',



        ];
    }
}

