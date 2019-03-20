<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title>后台管理系统登录</title>
    <link rel="stylesheet" href="{{ asset('/assets/login/style.css') }}">
</head>
<body class="page-login-v3" style="">
<div class="container">
    <div id="wrapper" class="login-body">
        <div class="login-content">
            <div class="brand">
                <h2 class="brand-text">后台管理系统</h2>
            </div>
            <form id="login-form" class="login-form">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="" name="username" placeholder="请输入用户名" type="text" required="">
                </div>
                <div class="form-group">
                    <input class="" name="password" placeholder="请输入密码" type="password" required="">
                </div>
                <div class="form-group">
                    <button id="btn-submit" type="submit">
                        登录
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/assets/store/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/layer/layer.js') }}"></script>
<script src="{{ asset('/assets/store/js/jquery.form.min.js') }}"></script>
<script>
    $(function () {
        // 表单提交
        var $form = $('#login-form');
        $form.submit(function () {
            var $btn_submit = $('#btn-submit');
            $btn_submit.attr("disabled", true);
            $form.ajaxSubmit({
                type: "post",
                dataType: "json",
                url: '/admin/doLogin',
                success: function (result) {
                    $btn_submit.attr('disabled', false);
                    console.log(result)
                    if (result.code === 0) {
                        layer.msg(result.message, {time: 1500, anim: 1}, function () {
                            window.location = result.url;
                        });
                        return true;
                    }
                    layer.msg(result.message, {time: 1500, anim: 6});
                }
            });
            return false;
        });
    });
</script>

</body>
</html>