<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>欢迎页面</title>
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
        <th>ID</th>
        <th>用户名</th>
        <th>角色</th>
        <th>姓名</th>
        <th>最后登录时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($admin as $admin)
    <tr>
        <td>{{ $admin['id'] }}</td>
        <td>{{ $admin['username'] }}</td>
        <td>{{ $db_groups[$admin['gid']]['title'] }}</td>
        <td>{{ $admin['real_name'] }}</td>
        <td>{{ $admin['lastlogin']?date('Y-m-d H:i:s',$admin['lastlogin']):'' }}</td>
        <td>{{ $admin['status']==0?'启用':'禁用' }}</td>
        <td>
            <button class="layui-btn layui-btn-xs" onclick="edit({{ $admin['id'] }})">编辑</button>
            <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $admin['id'] }})">删除</button>
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
            title: '添加管理员',
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '300px'],
            content: '/admin/admin/add'
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
    function del(aid) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/admin/del',{aid:aid,_token:_token},function (res) {
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
