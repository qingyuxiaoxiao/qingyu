<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>分类列表</title>
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
        <th>分类名称</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cate as $cate)
        <tr>
            <td>{{ $cate['id'] }}</td>
            <td>{{ $cate['title'] }}</td>

            <td>
                <button class="layui-btn layui-btn-xs" onclick="add({{ $cate['id'] }})">编辑</button>
                <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $cate['id'] }})">删除</button>
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
    function add(id) {
        layer.open({
            type: 2,
            title: id>0?'编辑分类':'添加分类',
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '600px'],
            content: '/admin/article/add_cate?id='+id
        });
    }

    //删除管理员
    function del(id) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/article/del_cate',{id:id,_token:_token},function (res) {
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

