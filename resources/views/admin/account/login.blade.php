<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>内容管理系统登录</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="background-color: #1E9FFF">
<div style="position: absolute;left: 50%;width: 480px;top: 50%;margin-left: -240px;background-color: #fff;margin-top: -200px;padding: 20px;border-radius: 4px;box-shadow: 5px 5px 20px #4444;">
    <div class="layui-form">
        @csrf
        <div class="layui-form-item" style="color: #0C0C0C;font-size: 24px;text-align: center;">通用后台管理系统</div>
        <hr class="layui-bg-blue">
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="username">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" class="layui-input" name="pwd">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">验证码</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="verifycode">
            </div>
            <img id="captcha" src="/admin/account/captcha" alt="" style="width: 167px;height: 36px;border: 1px solid #d2d2d2;" onclick="reload_captcha();">
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" onclick="dologin();">登录</button>
                <button class="layui-btn">重置</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    layui.use(['layer'],function () {
        $ = layui.jquery;
    });
    //登录
    function dologin() {
        var username = $.trim($('input[name="username"]').val());
        var pwd      = $.trim($('input[name="pwd"]').val());
        var verifycode = $.trim($('input[name="verifycode"]').val());
        var _token   = $('input[name="_token"]').val();
        if (username==''){
            return layer.alert('请输入用户名',{icon:2});
        }
        if (pwd==''){
            return layer.alert('请输入密码',{icon:2});
        }
        if (verifycode==''){
            return layer.alert('请输入验证码',{icon:2});
        }
        $.post('/admin/dologin',{_token:_token,username:username,pwd:pwd,verifycode:verifycode},function (res) {
            if (res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function () {
                window.location.href = '/admin/home/index';
            },1000);

        },'json');
    }
    //点击验证码进行更换
    function reload_captcha() {
        $('#captcha').attr('src','/admin/account/captcha?rand='+Math.random());

    }
</script>
</body>
</html>
