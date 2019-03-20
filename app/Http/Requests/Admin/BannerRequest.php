<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'Banner.img' => 'required',
            'Banner.sort' => 'nullable|integer',
            'Banner.is_show' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'Banner.img.required' => '请先上传轮播图图片',
            'Banner.sort.integer' => '排序为正整数'
        ];
    }

}
