<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>菜单管理</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">

    <div style="float: left;margin-right: 10px;margin-bottom: 10px">
        <input type="hidden" name="pid" value="{{ $pmenu?$pmenu['mid']:'0' }}">
        <button class="layui-btn" onclick="add()">添加</button>
    </div>

    @if(isset($pmenu['mid']) && $pmenu['mid']>0)
    <button class="layui-btn layui-btn-primary" onclick="backup({{ $pmenu['pid'] }})">返回【{{ $pmenu['title'] }}】</button>
    @endif


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
            <button class="layui-btn layui-btn-xs layui-btn-primary"  onclick="childs({{ $menu['mid'] }})">下级菜单</button>
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
        var pid = $('input[name="pid"]').val();
        layer.open({
            type: 2,
            title: '添加菜单',
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '600px'],
            content: '/admin/menus/add?pid='+pid
        });
    }

    //子菜单
    function childs(mid) {
        window.location.href="?mid="+mid;

    }
    //返回上一级
    function backup(ppid) {
        window.location.href="?mid="+ppid;

    }
    //编辑菜单
    function edit(mid) {
        layer.open({
            type: 2,
            title: '编辑管理员'+mid,
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '600px'],
            content: '/admin/menus/edit?mid='+mid
        });
    }
    //删除菜单
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
