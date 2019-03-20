@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" action="/admin/banner/{{ $data['info']->id }}"
                              method="post" novalidate="novalidate">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">编辑轮播图</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">图片 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <button type="button" id="upload-img" class="am-btn am-btn-sm" data-name="Banner[img]">
                                                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                                            </button>
                                            <div class="uploader-list am-cf" id="file-list">
                                                <div class="file-item">
                                                    <a href="{{ $data['info']->img }}" title="点击查看大图" target="_blank">
                                                        <img src="{{ $data['info']->img }}">
                                                    </a>
                                                    <input type="hidden" name="Banner[img]" value="{{ $data['info']->img }}">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">链接地址 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Banner[url]" value="{{ $data['info']->url }}"
                                                   placeholder="请输入链接地址">
                                            <small>http://或者https://，请输入正确的地址</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">排序 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="number" class="tpl-form-input" name="Banner[sort]" value="{{ $data['info']->sort }}"
                                                   placeholder="请输入排序" required="">
                                            <small>值越小，排序越靠前</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">是否发布 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            @foreach($data['status_label'] as $key=>$value)
                                                <label class="am-radio-inline">
                                                    <input type="radio" value="{{ $key }}"
                                                           name="Banner[is_show]" {{ $key == $data['info']->is_show ? 'checked' : '' }}> {{ $value }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-2 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">
                                                提交
                                            </button>
                                            <a class="am-btn am-btn-danger am-btn-sm am-radius"
                                               href="javascript:history.go(-1)">返回</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer')
    <script>
        $(function () {
            $.uploadImage({
                pick: '#upload-img',  // 上传按钮
                list: '#file-list' // 缩略图容器
            });

            $('#my-form').superForm();

        });
    </script>
@endsection