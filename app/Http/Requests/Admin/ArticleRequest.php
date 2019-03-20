<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'Article.title' => 'required|string',
            'Article.content' => 'required',
            'Article.sort' => 'nullable|integer',
            'Article.is_show' => 'required|integer',
            'Article.cate_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'Article.title.required' => '公告标题不能为空',
            'Article.title.string' => '公告标题必须为字符串',
            'Article.content.required' => '公告标题不能为空',
            'Article.sort.integer' => '排序为正整数',
            'Article.cate_id.required' => '文章分类不能为空'
        ];
    }

}
