<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品添加/修改</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <script type="text/javascript" src="/static/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/static/plugins/ueditor/ueditor.all.js"></script>
</head>
<body style="padding: 15px">
<div class="layui-form">
    @csrf
    <input type="hidden" name="pro_id" value="{{ $item['id'] }}">
    <div class="layui-form-item">
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="title" value="{{ $item['title'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品副标题</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="subtitle" value="{{ $item['subtitle'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品价格</label>
        <div class="layui-input-inline">
            <input type="number" class="layui-input" name="price" value="{{ $item['price'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品库存</label>
        <div class="layui-input-inline">
            <input type="number" class="layui-input" name="stock" value="{{ $item['stock'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品分类</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="wd" placeholder="输入商品分类搜索" oninput="search_product_cates()">
        </div>
        <div class="layui-input-inline">
            <select name="cid">
                <option value="{{$item['cid']}}">{{$item['cate_title']}}</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">封面图</label>
        <div class="layui-input-inline">
            <img id="preview_img" src="{{ $item['thumb'] }}" style="height: 30px">

            <button type="button" class="layui-btn" id="btn_upload">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="keywords" value="{{ $item['keywords'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-inline">
            <textarea name="descs" placeholder="请输入内容" class="layui-textarea">{{ $item['descs'] }}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <!-- 加载编辑器的容器 -->
        <script id="container" name="content" type="text/plain">
            {!!$detail['contents']!!}
        </script>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
            <input type="checkbox" lay-skin="primary" {{$item['status']==1?'checked':''}} name="status" title="上架">
        </div>
    </div>
</div>

<script type="text/javascript">
    layui.use(['upload','form'], function(){
        $ = layui.jquery;
        var _token =  $('input[name="_token"]').val();
        form = layui.form;
        upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#btn_upload' //绑定元素
            ,url: '/admin/files/upload_img' //上传接口
            ,data:{_token:_token}
            ,done: function(res){
                //上传完毕回调
                $('#preview_img').attr('src',res.data.src);
            }
            ,error: function(){
                //请求异常回调
            }
        });
        <!-- 实例化编辑器 -->
        ue = UE.getEditor('container',{
            initialFrameWidth:'100%',
            initialFrameHeight:'500'
        });
    });
    //文章保存
    function save() {
        var data = {};
        data._token = $('input[name="_token"]').val();
        data.pro_id = $('input[name="pro_id"]').val();
        data.title = $.trim($('input[name="title"]').val());
        data.subtitle = $.trim($('input[name="subtitle"]').val());
        data.price = $('input[name="price"]').val();
        data.stock = $('input[name="stock"]').val();
        data.cid = parseInt($('select[name="cid"]').val());
        data.thumb = $('#preview_img').attr('src');
        data.keywords = $('input[name="keywords"]').val();
        data.descs = $('textarea[name="descs"]').val();
        data.contents = ue.getContent();
        data.status = $('input[name="status"]').is(':checked')?1:0;


        if(data.title==''){
            return layer.alert('请填写商品名称',{icon:2});
        }
        if(isNaN(data.cid)||data.cid<=0){
            return layer.alert('请选择商品分类');
        }
        $.post('/admin/product/save',data,function (res) {
            if (res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function () {
                parent.window.location.reload();
            },1000);
        },'json');

    }
    // 搜索商品分类
    function search_product_cates(){
        var wd = $.trim($('input[name="wd"]').val());
        if(wd==''){
            return;
        }
        $.get('/admin/product/search_product_cates',{wd:wd},function(res){
            if(res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            var html = '';
            $.each(res.data,function(i,v){
                html += ('<option value='+v.id+'>'+v.title+'</option>');
            });
            $('select[name="cid"]').html(html);
            form.render();
        },'json');
    }
</script>
</body>
</html>
