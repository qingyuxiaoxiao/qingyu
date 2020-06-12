<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>菜单管理1</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<div>
    <button class="layui-btn" onclick="add()">添加</button>
</div>

<table class="layui-table">
    @csrf
    <thead>
    <tr>
        <th>MID</th>
        <th>排序</th>
        <th>菜单名称</th>
        <th>控制器</th>
        <th>方法</th>
        <th>是否隐藏</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
    <tr>
        <td>{{ $menu['mid'] }}</td>
        <td>{{ $menu['ord'] }}</td>
        <td>{{ $menu['title'] }}</td>
        <td>{{ $menu['controller'] }}</td>
        <td>{{ $menu['action'] }}</td>
        <td>{{ $menu['ishidden']?'隐藏':'显示' }}</td>
        <td>{{ $menu['status']?'禁用':'启用' }}</td>
        <td>
            <button class="layui-btn layui-btn-xs layui-btn-primary" >下级菜单</button>
            <button class="layui-btn layui-btn-xs" onclick="edit({{ $menu['mid'] }})">编辑</button>
            <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $menu['mid'] }})">删除</button>
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
<script>
    layui.use('layer', function(){
        layer = layui.layer;
        // var element = layui.element;
        $ = layui.jquery;

    });
    //添加管理员
    function add() {
        layer.open({
            type: 2,
            title: '添加菜单',
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '300px'],
            content: '/admin/menus/add'
        });
    }
    //编辑管理员
    function edit(aid) {
        layer.open({
            type: 2,
            title: '编辑管理员'+aid,
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '300px'],
            content: '/admin/admin/edit?aid='+aid
        });
    }
    //删除管理员
    function del(mid) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/menus/del',{mid:mid,_token:_token},function (res) {
                if (res.code>0){
                    return layer.alert(res.msg,{icon:2});
                }
                layer.msg(res.msg);
                setTimeout(function () {
                   window.location.reload();

                },1000);
            },'json');
        });

    }

</script>
</body>
</html>
