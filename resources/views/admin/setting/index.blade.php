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
<form class="layui-form">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">网站名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value="{{ $setting['vals']['title'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-inline">
            <input type="text" name="keywords" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value="{{ $setting['vals']['keywords'] }}">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">网站描述</label>
        <div class="layui-input-inline">
            <textarea name="desc" placeholder="请输入内容" class="layui-textarea">{{ $setting['vals']['desc'] }}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">TCP备案</label>
        <div class="layui-input-inline">
            <input type="text" name="tcpbeian" required  lay-verify="required" placeholder="TCP备案号" autocomplete="off" class="layui-input" value="{{ $setting['vals']['tcpbeian'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联网备案</label>
        <div class="layui-input-inline">
            <input type="text" name="gabeian" required  lay-verify="required" placeholder="公安备案" autocomplete="off" class="layui-input" value="{{ $setting['vals']['gabeian'] }}">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" onclick="save()">立即提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    layui.use(['layer'],function () {
        layer = layui.layer;
        $ = layui.jquery;
    });
    function save() {
        var title = $.trim($('input[name="title"]').val());
        if (title==''){
            return layer.alert('网站名称不能为空',{icon:2});
        }
        $.post('/admin/setting/save',$('form').serialize(),function (res) {
            if (res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);

        },'json');

    }
</script>



</body>
</html>
