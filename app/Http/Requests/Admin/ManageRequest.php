<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ManageRequest extends FormRequest
{

    private $createRules = [
        'password' => 'required|min:6|max:16',
        'password_confirmation' => 'required|same:password',
        'group_id' => 'required'
    ];

    private $updateRules = [
        'password' => 'nullable|min:6|max:16',
        'password_confirmation' => 'required_with:password|same:password',
        'group_id' => 'required'
    ];

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $method = $this->getMethod();

        $id = $this->input('id');

        switch ($method) {
            case 'POST':
                $rules = $this->createRules;
                $rules['manage_name'] = 'required|unique:manage_user,name';
                break;
            case 'PUT':
                $rules = $this->updateRules;
                $rules['manage_name'] = "required|unique:manage_user,name,{$id}";
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'manage_name.required' => '用户名不能为空',
            'manage_name.unique' => '用户名已存在',
            'password.required' => '密码不能为空',
            'password.min' => '密码长度不能少于6位',
            'password.max' => '密码长度不能大于16位',
            'password_confirmation.required' => '确定密码不能为空',
            'password_confirmation.same' => '两次密码输入不一致',
            'password_confirmation.required_with' => '确定密码不能为空',
            'group_id.required' => '请选择分组'
        ];
    }

}
