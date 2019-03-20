<!DOCTYPE html>
<html lang="en" class="js cssanimations">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta name="apple-mobile-web-app-title" content="后台管理系统">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/assets/store/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/store/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/store/css/font_783249_oo2lzo85b4.css') }}">
    <script src="{{ asset('/assets/store/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/store/js/font_783249_e5yrsf08rap.js') }}"></script>
    <script>
        STORE_URL = "{{ $app_url }}";
    </script>
    @yield('header')
</head>

<body data-type="" style="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <div class="tpl-header-fluid">
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="">欢迎你，<span>{{ $manage_info['name']  }}</span>
                        </a>
                    </li>
                    <li class="am-text-sm">
                        <a href="javascript:void(0);" onclick="logout()">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    @include('admin.layout.left')
    <!-- 内容区域 start -->
    @yield('main')
</div>
<script src="{{ asset('/assets/layer/layer.js') }}"></script>
<script src="{{ asset('/assets/store/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('/assets/store/js/amazeui.min.js') }}"></script>
<script src="{{ asset('/assets/store/js/webuploader.html5only.js') }}"></script>
<script src="{{ asset('/assets/store/js/art-template.js') }}"></script>
<script src="{{ asset('/assets/store/js/app.js') }}"></script>
<script>
    function logout() {
        layer.alert('确定要退出系统吗?', {
            closeBtn: 0
        }, function(){
            window.location.href = "{{ url('/admin/logout') }}"
        });
    }
</script>
@yield('footer')
</body>
</html>