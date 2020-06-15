<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>添加角色</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<form class="layui-form" action="">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" name="title">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单</label>
        <div class="layui-input-block">
            <div>
                <input type="checkbox" lay-skin="primary" lay-filter="chk-all" title="全选">
            </div>

            @foreach($menu_list as $menu)
                <input type="checkbox" name="menus[{{ $menu['mid'] }}]" value="{{ $menu['mid'] }}" title="{{ $menu['title'] }}" lay-skin="primary">
            @endforeach

        </div>
    </div>

    <div class="layui-form-item">

        <div class="layui-input-block">
            <button class="layui-btn" type="button" onclick="save()">添加</button>
        </div>
    </div>
</form>

<script>
    layui.use(['layer','form'], function(){
        layer = layui.layer;
        form = layui.form;
        $ = layui.jquery;
        form.on('checkbox(chk-all)',function(data){
            if(data.elem.checked){
                $(data.elem).parent('div').siblings('input[type="checkbox"]').prop('checked',true);
            }else{
                $(data.elem).parent('div').siblings('input[type="checkbox"]').prop('checked',false);
            }
            form.render();
        });


    });
    function save() {
        var title = $.trim($('input[name="title"]').val());
        if (title== ''){
            return layer.alert('请填写角色名称',{icon:2});
        }
        $.post('/admin/groups/save',$('form').serialize(),function (res) {
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
