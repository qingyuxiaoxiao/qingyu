<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>角色列表</title>
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
        <th>角色名称</th>

        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
    <tr>
        <td>{{ $group['gid'] }}</td>
        <td>{{ $group['title'] }}</td>
        <td>
            <button class="layui-btn layui-btn-xs" onclick="add({{ $group['gid'] }})">编辑</button>
            <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $group['gid'] }})">删除</button>
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
<script>
    layui.use(['layer','form'], function(){
        layer = layui.layer;
        form = layui.layer;
        // var element = layui.element;
        $ = layui.jquery;

    });
    //添加角色
    function add(gid) {
        layer.open({
            type: 2,
            title: gid>0?'修改角色':'添加角色',
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '600px'],
            content: '/admin/groups/add?gid='+gid,
            btn:['保存'],
            yes:function (index, layero) {
                var body = layer.getChildFrame('body', index);
                var iframewin = window[layero.find('iframe')[0]['name']];
                iframewin.save();
            }
        });
    }

    //删除管理员
    function del(gid) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/groups/del',{gid:gid,_token:_token},function (res) {
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
