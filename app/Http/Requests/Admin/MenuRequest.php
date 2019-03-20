<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    private $rules = [
        'Menu.parent_id' => 'nullable|integer',
        'Menu.level' => 'required|integer',
        'Menu.icon' => 'nullable|string',
        'Menu.sort' => 'nullable|integer'
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
                $rules['Menu.name'] = 'required|unique:manage_menu,path';
                break;
            case 'PUT':
                $rules['Menu.name'] = "required|unique:manage_menu,path,{$id}";
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'Menu.name.required' => '菜单名称不能为空',
            'Menu.name:unique' => '此菜单名称已存在',
            'Menu.level.required' => '等级不能为空'
        ];
    }

}
