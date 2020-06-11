<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <link rel="stylesheet" href="/static/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>

            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                @foreach($menus as $menu)
                <li class="layui-nav-item">
                    <a class="" href="javascript:;"><i class="fa {{ $menu['icon'] }}" aria-hidden="true"></i> {{ $menu['title'] }}</a>
                    <dl class="layui-nav-child">
                        @foreach($menu['child'] as $chd)
                        <dd><a href="javascript:;" onclick="firemenu(this)" controller="{{ $chd['controller'] }}" action="{{ $chd['action'] }}"><i class="fa {{ $chd['icon'] }}" aria-hidden="true"></i> {{ $chd['title'] }}</a></dd>
                        @endforeach
                    </dl>
                </li>
                @endforeach

            </ul>
        </div>
    </div>

    <div class="layui-body main" style="overflow-y: hidden">
        <!-- 内容主体区域 -->
        <iframe src="/admin/home/welcome" frameborder="0" style="width: 100%;height: 100%" onload="reserIframeHeight(this)">

        </iframe>

    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>

<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
        $ = layui.jquery;

    });
    //点击菜单
    function firemenu(obj) {
        var controller = $(obj).attr('controller');
        var action     = $(obj).attr('action');
        var url        = '/admin/'+controller+'/'+action;
        $('.main iframe').attr('src',url);
    }
    function reserIframeHeight(obj) {
        var leftHeight = parent.document.documentElement.clientHeight - 60;
        $('.layui-body').height(leftHeight);

    }
</script>
</body>
</html>
