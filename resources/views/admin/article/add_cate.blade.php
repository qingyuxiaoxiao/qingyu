<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>添加分类</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<form class="layui-form" action="">
    @csrf
    <input type="hidden" name="id" value="{{ $cat['id'] }}">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="title" value="{{ $cat['title'] }}">
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
    });
    function save() {
        var title = $.trim($('input[name="title"]').val());

        if (title==''){
            return layui.alert('请输入分类名称',{icon:2});
        }

        $.post('/admin/article/save_cate',$('form').serialize(),function (res) {
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
