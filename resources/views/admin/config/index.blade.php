@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" method="post" action="/admin/config/revise" novalidate="novalidate">
                            <input type="hidden" name="type" value="base">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">网站开关设置</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">网站开关</label>
                                        <div class="am-u-sm-9">
                                            <label class="am-radio-inline">
                                                <input type="radio" value="1" {{ $data['list']['app_switch']['value']==1 ? 'checked' : '' }} name="config[app_switch]"> 开启
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" value="0" {{ $data['list']['app_switch']['value']==0 ? 'checked' : '' }} name="config[app_switch]"> 关闭
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">网站关闭提示信息</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="config[app_close_reason]"
                                                   value="{{ $data['list']['app_close_reason']['value'] }}">
                                            <small>{{ $data['list']['app_close_reason']['config_desc'] }}</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">网站自动开关</label>
                                        <div class="am-u-sm-9">
                                            <label class="am-radio-inline">
                                                <input type="radio" value="1" {{ $data['list']['app_auto_close']['value']==1 ? 'checked' : '' }} name="config[app_auto_close]"> 开启
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" value="0" {{ $data['list']['app_auto_close']['value']==0 ? 'checked' : '' }} name="config[app_auto_close]"> 关闭
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">自动开启时间</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="config[app_open_time]"
                                                   value="{{ $data['list']['app_open_time']['value'] }}">
                                            <small>{{ $data['list']['app_open_time']['config_desc'] }}</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">自动关闭时间</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="config[app_close_time]"
                                                   value="{{ $data['list']['app_close_time']['value'] }}">
                                            <small>{{ $data['list']['app_close_time']['config_desc'] }}</small>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">注册设置</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">注册开关</label>
                                        <div class="am-u-sm-9">
                                            <label class="am-radio-inline">
                                                <input type="radio" value="1" {{ $data['list']['register_open']['value']==1 ? 'checked' : '' }} name="config[register_open]"> 开启
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" value="0" {{ $data['list']['register_open']['value']==0 ? 'checked' : '' }} name="config[register_open]"> 关闭
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label">注册ip限制</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="config[register_ip_limit]"
                                                   value="{{ $data['list']['register_ip_limit']['value'] }}">
                                            <small>{{ $data['list']['register_ip_limit']['config_desc'] }}</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                            </button>
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

            /**
             * 表单验证提交
             * @type {*}
             */
            $('#my-form').superForm();

        });
    </script>
@endsection