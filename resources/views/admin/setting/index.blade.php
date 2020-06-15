<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>网站设置</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 15px">
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">网站名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="keywords" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">网站描述</label>
        <div class="layui-input-block">
            <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="botton" class="layui-btn" onclick="save()">立即提交</button>
        </div>
    </div>
</form>
<script>
    layui.use(['layer'],function () {
        layer = layui.layer;
        $ = layui.jqtery;
    });
    function save() {
        var title = $.trim($('input[name="title"]').val());

    }
</script>



</body>
</html>
