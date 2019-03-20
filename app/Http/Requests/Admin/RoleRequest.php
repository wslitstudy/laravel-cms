<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    private $rules = [
        'power_id' => 'required',
    ];

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        $method = $this->getMethod();

        $id = $this->input('id');

        switch ($method) {
            case 'POST':
                $rules['Role.name'] = 'required|unique:manage_group,group_name';
                break;
            case 'PUT':
                $rules['Role.name'] = "required|unique:manage_group,group_name,{$id}";
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'Role.name.required' => '角色名称不能为空',
            'Role.name:unique' => '此角色已存在',
            'power_id.required' => '请选择角色的权限'
        ];
    }

}
