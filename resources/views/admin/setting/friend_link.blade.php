<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>友情链接</title>
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
        <th>排序</th>
        <th>名称</th>
        <th>网址</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($link as $link)
        <tr>
            <td>{{ $link['id'] }}</td>
            <td>{{ $link['ord'] }}</td>
            <td>{{ $link['title'] }}</td>
            <td>{{ $link['url'] }}</td>
            <td>{{ $link['add_time']?date('Y-m-d H:i:s',$link['add_time']):'' }}</td>

            <td>
                <button class="layui-btn layui-btn-xs" onclick="edit({{ $link['id'] }})">编辑</button>
                <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $link['id'] }})">删除</button>
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
    //添加友链
    function add() {
        layer.open({
            type: 2,
            title: '添加友链',
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '300px'],
            content: '/admin/setting/add_friend'
        });
    }
    //编辑友链
    function edit(id) {
        layer.open({
            type: 2,
            title: '编辑友链'+id,
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '600px'],
            content: '/admin/setting/edit_friend?id='+id
        });
    }
    //删除友链
    function del(id) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/setting/del_friend_link',{id:id,_token:_token},function (res) {
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
