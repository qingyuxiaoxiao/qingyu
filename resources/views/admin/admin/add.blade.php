<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>添加管理员</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<form class="layui-form" action="">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="username">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色</label>
        <div class="layui-input-block">
            <select name="gid" id="">
                <option></option>
                @foreach($groups as $group)
                    <option value="{{ $group['gid'] }}">{{ $group['title'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" class="layui-input" name="pwd">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">真实姓名</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="real_name">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="phone">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="checkbox" lay-filter="test1" name="status" lay-text="启用|禁用" lay-skin="switch" checked>
        </div>
    </div>
    <div class="layui-form-item">

        <div class="layui-input-block">
            <button class="layui-btn" type="button" onclick="save()">添加</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use(['layer','form'], function(){
        layer = layui.layer;
        form = layui.form;
        $ = layui.jquery;


        form.on('switch(test1)', function(data){

            console.log(data.elem.checked); //开关是否开启，true或者false
            //询问框判断是否开启
            if (data.elem.checked==true){
                layer.confirm('您确定要启用？', {
                    btn: ['启用','取消'] //按钮
                }, function(){
                    layer.msg('启用成功', {icon: 1});
                }, function(){
                    $(data.elem).prop('checked',false)
                    form.render();
                });
            }else {
                layer.confirm('您确定要禁用？', {
                    btn: ['禁用','取消'] //按钮
                }, function(){
                    layer.msg('禁用成功', {icon: 1});
                }, function(){
                    $(data.elem).prop('checked',true)
                    form.render();
                });
            }
        });

    });
    function save() {
        var username = $.trim($('input[name="username"]').val());
        var gid      = parseInt($('select[name="gid"]').val());
        var pwd = $.trim($('input[name="pwd"]').val());
        if (username==''){
            return layui.alert('请输入用户名',{icon:2});
        }
        if (isNaN(gid)){
            return  layui.alert('请选择角色',{icon:2});
        }
        if (pwd==''){
            return layui.alert('请输入密码',{icon:2});
        }
        $.post('/admin/admin/save',$('form').serialize(),function (res) {
            if (res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function () {
                parent.window.location.reload();
            },1000);
        },'json');

    }



</script>
</body>
</html>
