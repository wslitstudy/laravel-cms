@extends('admin.layout.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('/assets/store/plugins/umeditor/themes/default/css/umeditor.css') }}">
@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" action="{{ url('/admin/notice') }}"
                              method="post" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">添加公告</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">公告标题 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Notice[title]" value=""
                                                   placeholder="请输入公告标题" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">排序 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="number" class="tpl-form-input" name="Notice[sort]" value="1"
                                                   placeholder="请输入公告排序" required="">
                                            <small>值越小，排序越靠前</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">是否发布 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            @foreach($data['status_label'] as $key=>$value)
                                                <label class="am-radio-inline">
                                                    <input type="radio" value="{{ $key }}"
                                                           name="Notice[is_show]" {{ $key == 1 ? 'checked' : '' }}> {{ $value }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">公告内容 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <textarea id="container" name="Notice[content]" type="text/plain"></textarea>
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
    <script src="{{ asset('/assets/store/plugins/umeditor/umeditor.config.js') }}"></script>
    <script src="{{ asset('/assets/store/plugins/umeditor/umeditor.min.js') }}"></script>
    <script>
        $(function () {
            // 富文本编辑器
            UM.getEditor('container', {
                initialFrameWidth: 400 + 15,
                initialFrameHeight: 600
            });

            /**
             * 表单验证提交
             * @type {*}
             */
            $('#my-form').superForm();

        });
    </script>
@endsection