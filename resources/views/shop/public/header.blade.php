<!--公共页眉-->
<nav class="public-header">
    <a href="">网站首页</a>
    <a href="">专题</a>
    <a href="">网站导航</a>
    <a href="">二手商品</a>
    <a href="">讨论区</a>
    <span>
    	@if($member==null)
        <a href=""><i class="iconfont icon-huiyuan2"></i>登陆</a>
        <a href="">免费注册</a>
        @else
        <a href=""><i class="iconfont icon-huiyuan2"></i>{{substr_replace($member->phone,'****',3,4)}}</a>
        <a href="">退出</a>
        @endif
    </span>
</nav>