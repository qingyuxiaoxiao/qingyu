<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>添加菜单</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<form class="layui-form" action="">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="title">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="controller">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="action">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">图标</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="icon">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="org">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否隐藏</label>
        <div class="layui-input-block">
            <input type="checkbox" name="ishidden" title="隐藏" lay-skin="primary">
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
        var title      = $.trim($('input[name="title"]').val());
        var controller = $.trim($('input[name="controller"]').val());
        var action     = $.trim($('input[name="action"]').val());
        var icon     = $.trim($('input[name="icon"]').val());
        if (title==''){
            return layer.alert('请填写菜单名称',{icon:2});
        }
        $.post('/admin/menus/save',$('form').serialize(),function (res) {
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
