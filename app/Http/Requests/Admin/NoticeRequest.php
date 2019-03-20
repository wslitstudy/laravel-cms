<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'Notice.title' => 'required|string',
            'Notice.content' => 'required',
            'Notice.sort' => 'nullable|integer',
            'Notice.is_show' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'Notice.title.required' => '公告标题不能为空',
            'Notice.title.string' => '公告标题必须为字符串',
            'Notice.content.required' => '公告标题不能为空',
            'Notice.sort.integer' => '排序为正整数'
        ];
    }

}
