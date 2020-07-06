<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>商品管理</title>
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
        <th>商品分类</th>
        <th>缩略图</th>
        <th>商品名称</th>
        <th>商品价格</th>
        <th>商品库存</th>
        <th>浏览量</th>
        <th>添加时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($product_list as $item)
        <tr>
            <td>{{$item['id']}}</td>
            <td>{{isset($cates[$item['cid']])?$cates[$item['cid']]['title']:''}}</td>
            <td><img src="{{$item['thumb']}}" style="height: 30px;"></td>
            <td>{{$item['title']}}</td>
            <td>{{$item['price']}}</td>
            <td>{{$item['stock']}}</td>
            <td>{{$item['pv']}}</td>
            <td>{{date('Y-m-d H:i:s',$item['add_time'])}}</td>
            <td>{{$item['status']==0?'未上架':'已上架'}}</td>
            <td>
                <button class="layui-btn layui-btn-xs" onclick="add({{ $item['id'] }})">编辑</button>
                <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $item['id'] }})">删除</button>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
<div id="pages"></div>
<script>
    layui.use(['layer','laypage'], function(){
        layer = layui.layer;
        $ = layui.jquery;
        laypage = layui.laypage;
        //分页参数
        laypage.render({
            elem: 'pages' //注意，这里的 test1 是 ID，不用加 # 号
            ,limit: {{ $pageSize }}
            ,count: {{ $total }} //数据总数，从服务端得到
            ,curr: {{ $page }}
            ,layout:['prev','page','next','skip','count']
            ,jump: function(obj, first){
                console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。

                //首次不执行
                if(!first){
                    window.location.href = '?page='+obj.curr;
                }
            }
        });


    });
    //添加文章或修改文章
    function add(pro_id) {
        layer.open({
            type: 2,
            title: pro_id>0?'修改商品':'添加商品',
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '90%'],
            content: '/admin/product/add?pro_id='+pro_id,
            btn:['保存'],
            yes:function (index, layero) {
                var body = layer.getChildFrame('body', index);
                var iframewin = window[layero.find('iframe')[0]['name']];
                iframewin.save();
            }
        });
    }

    //删除文章
    function del(pro_id) {
        layer.confirm('确定要删除吗？', {
            icon:3,
            btn: ['删除','取消'] //按钮
        }, function(){
            var _token = $('input[name="_token"]').val();
            $.post('/admin/product/del',{pro_id:pro_id,_token:_token},function (res) {
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
