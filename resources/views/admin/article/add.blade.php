<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文章添加</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <script type="text/javascript" src="/static/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/static/plugins/ueditor/ueditor.all.js"></script>
</head>
<body style="padding: 15px">
<div class="layui-form">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">文章标题</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="title" value="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">文章副标题</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="subtitle" value="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">文章分类</label>
        <div class="layui-input-inline">
            <select name="cid" id="">
                <option></option>
                @foreach($cates as $cate)
                    <option value="{{ $cate['id'] }}">{{ $cate{'title'} }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">封面图</label>
        <div class="layui-input-inline">
            <img id="preview_img" alt="">

            <button type="button" class="layui-btn" id="btn_upload">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="keywords" value="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-inline">
            <textarea name="descs" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <!-- 加载编辑器的容器 -->
        <script id="container" name="content" type="text/plain">

        </script>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
            <input type="checkbox" lay-skin="primary" name="status" value="" title="发布">
        </div>
    </div>
</div>

<script type="text/javascript">
    layui.use(['upload','form'], function(){
        $ = layui.jquery;
        var _token =  $('input[name="_token"]').val();
        upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#btn_upload' //绑定元素
            ,url: '/admin/files/upload_img' //上传接口
            ,data:{_token:_token}
            ,done: function(res){
                //上传完毕回调
                console.log(res);
                $('#preview_img').attr('src',res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });
        <!-- 实例化编辑器 -->
        var ue = UE.getEditor('container');
    });
    //文章保存
    function save() {

    }
</script>
</body>
</html>
