@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" method="post"
                              action="/admin/config/doUpload" novalidate="novalidate">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">文件上传设置</div>
                                    </div>
                                    <div class="am-form-group am-form-success">
                                        <label class="am-u-sm-3 am-form-label">
                                            默认上传方式
                                        </label>
                                        <div class="am-u-sm-9">
                                            <label class="am-radio-inline">
                                                <input type="radio"
                                                       name="storage[method]"
                                                       value="local"
                                                       class="am-ucheck-radio am-field-valid"
                                                       {{ $data['method'] == 'local' ? 'checked' : '' }}
                                                >
                                                <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i
                                                            class="am-icon-checked"></i></span> 本地 (不推荐)
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio"
                                                       name="storage[method]"
                                                       value="qiniu"
                                                       {{ $data['method'] == 'qiniu' ? 'checked' : '' }}
                                                       class="am-ucheck-radio am-field-valid">
                                                <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i
                                                            class="am-icon-checked"></i></span> 七牛云存储
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio"
                                                       name="storage[method]"
                                                       value="aliyun"
                                                       class="am-ucheck-radio am-field-valid"
                                                        {{ $data['method'] == 'aliyun' ? 'checked' : '' }}
                                                >
                                                <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i
                                                            class="am-icon-checked"></i></span> 阿里云OSS
                                            </label>
                                        </div>
                                    </div>
                                    <div id="qiniu" class="form-tab-group {{ $data['method'] == 'qiniu' ? 'active' : '' }}">
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                存储空间名称 <span class="tpl-form-line-small-title">Bucket</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[qiniu][bucket]" value="{{ $data['qiniu']['bucket'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                ACCESS_KEY <span class="tpl-form-line-small-title">AK</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[qiniu][access_key]" value="{{ $data['qiniu']['access_key'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                SECRET_KEY <span class="tpl-form-line-small-title">SK</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[qiniu][secret_key]" value="{{ $data['qiniu']['secret_key'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group">
                                            <label class="am-u-sm-3 am-form-label">
                                                空间域名 <span class="tpl-form-line-small-title">Domain</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input" name="storage[qiniu][domain]"
                                                       value="{{ $data['qiniu']['domain'] ?? '' }}">
                                                <small>请补全http:// 或 https://，例如：http://static.cloud.com</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="aliyun" class="form-tab-group {{ $data['method'] == 'aliyun' ? 'active' : '' }}">
                                        <div class="am-form-group">
                                            <label class="am-u-sm-3 am-form-label">
                                                存储空间名称 <span class="tpl-form-line-small-title">Bucket</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input" name="storage[aliyun][bucket]"
                                                       value="{{ $data['aliyun']['bucket'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                所属地域 <span class="tpl-form-line-small-title">Region</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[aliyun][region]" value="{{ $data['aliyun']['region'] ?? '' }}">
                                                <small>请填写地域简称，例如：深圳、北京、杭州</small>
                                            </div>
                                        </div>
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                网络模式 <span class="tpl-form-line-small-title">ECS</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[aliyun][ecs]" value="{{ $data['aliyun']['ecs'] ?? '' }}">
                                                <small>请填写网络模式，例如：经典网络、VPC</small>
                                            </div>
                                        </div>
                                        <div class="am-form-group">
                                            <label class="am-u-sm-3 am-form-label"> AccessKeyId </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input"
                                                       name="storage[aliyun][access_key_id]" value="{{ $data['aliyun']['access_key_id'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group">
                                            <label class="am-u-sm-3 am-form-label"> AccessKeySecret </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input"
                                                       name="storage[aliyun][access_key_secret]" value="{{ $data['aliyun']['access_key_secret'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="am-form-group am-form-success">
                                            <label class="am-u-sm-3 am-form-label">
                                                空间域名 <span class="tpl-form-line-small-title">Domain</span>
                                            </label>
                                            <div class="am-u-sm-9">
                                                <input type="text" class="tpl-form-input am-field-valid"
                                                       name="storage[aliyun][domain]" value="{{ $data['aliyun']['domain'] ?? '' }}">
                                                <small>请补全http:// 或 https://，例如：http://static.cloud.com</small>
                                            </div>
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

            // 切换默认上传方式
            $("input:radio[name='storage[method]']").change(function (e) {
                $('.form-tab-group').removeClass('active');
                switch (e.currentTarget.value) {
                    case 'qiniu':
                        $('#qiniu').addClass('active');
                        break;
                    case 'aliyun':
                        $('#aliyun').addClass('active');
                        break;
                    case 'local':
                        break;
                }
            });

            /**
             * 表单验证提交
             * @type {*}
             */
            $('#my-form').superForm();

        });
    </script>
@endsection