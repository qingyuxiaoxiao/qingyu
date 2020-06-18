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
        <th>所属分类</th>
        <th>缩略图</th>
        <th>文章标题</th>
        <th>文章作者</th>
        <th>添加时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($article_list as $article)
        <tr>
            <td>{{ $article['id'] }}</td>
            <td>{{ $cate[$article['cid']]['title'] }}</td>
            <td><img src="{{ $article['thumb'] }}" /> </td>
            <td>{{ $article['subtitle'] }}</td>
            <td>{{ $admin[$article['auth_id']]['username'] }}</td>
            <td>{{ $article['add_time']?date('Y-m-d H:i:s',$article['add_time']):'' }}</td>
            <td>{{ $article['status']==0?'未发布':'发布' }}</td>
            <td>
                <button class="layui-btn layui-btn-xs" onclick="edit({{ $article['id'] }})">编辑</button>
                <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({{ $article['id'] }})">删除</button>
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
    //添加文章
    function add() {
        layer.open({
            type: 2,
            title: '添加文章',
            shadeClose: true,
            shade: 0.8,
            area: ['800px', '90%'],
            content: '/admin/article/add',
            btn:['保存'],
            yes:function (index, layero) {
                var body = layer.getChildFrame('body', index);
                var iframewin = window[layero.find('iframe')[0]['name']];
                iframewin.save();
            }
        });
    }
    //编辑文章
    function edit(aid) {
        layer.open({
            type: 2,
            title: '编辑文章'+aid,
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '300px'],
            content: '/admin/admin/edit?aid='+aid
        });
    }
    //删除文章
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
