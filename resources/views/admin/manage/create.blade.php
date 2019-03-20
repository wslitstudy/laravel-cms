@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" action="{{ url('/admin/manage') }}"  method="post" novalidate="novalidate">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">添加管理员</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">管理员名称 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="manage_name" value="" placeholder="请输入管理员名称" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">登录密码 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="password" class="tpl-form-input" name="password" value="" placeholder="请输入登录密码" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">确定登录密码 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="password" class="tpl-form-input" name="password_confirmation" value="" placeholder="请再输入一次密码" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">选择角色 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            @foreach($data['roles'] as $role)
                                                <div class="am-checkbox-inline">
                                                    <label>
                                                        <input type="checkbox" value="{{ $role->id }}" name="group_id[]" required>{{ $role->group_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-2 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">提交</button>
                                            <a class="am-btn am-btn-sm am-btn-danger am-radius" href="javascript:history.go(-1)">返回</a>
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