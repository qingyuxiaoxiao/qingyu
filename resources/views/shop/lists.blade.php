<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--    当前文档要用到阿里字体图标-->
    <link rel="stylesheet" href="/static/font/iconfont.css">
    <link rel="stylesheet" href="/static/css/shop_list.css">
    <title>商城首页</title>
</head>

<body>
    <!--公共页眉-->
    @include('shop/public/header')
    <!--主体全部放在main元素中-->
    <main>
        <!--    商城公共头部-->
         @include('shop/public/header_search')
        <!--    商城商品列表展示区-->
        <!--引入大标题组件-->
        <div class="public-headline">
            <span>写真贴画1</span>
        </div>
        <!--商城图文专区-->
        <div class="shop-index-goods">
            <!-- 标题1-->
            <div class="title1">
                <a href="">抢好货</a>
                <span>0低价, 便捷,安全,快速</span>
            </div>
            <!-- 标题2-->
            <div class="title2">
                <span>热门分类</span>
                <a href="">美女写真</a>
                <a href="">日本美女</a>
                <a href="">美国美女</a>
                <a href="">国内美女</a>
                <a href="">AV美女</a>
            </div>
            <!--商品展示区-->
            <div class="goods">
                <!--左侧商品列表-->
                <div class="goods-list">
                    <!-- 商品简介-->
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop1.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图1</a>
                        <div>
                            <span>&yen; 333</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop2.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图2</a>
                        <div>
                            <span>&yen; 456</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop3.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图3</a>
                        <div>
                            <span>&yen; 777</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop4.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图4</a>
                        <div>
                            <span>&yen; 878</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop5.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图5</a>
                        <div>
                            <span>&yen; 6666</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop6.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图6</a>
                        <div>
                            <span>&yen; 1234</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop7.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图7</a>
                        <div>
                            <span>&yen; 5678</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop8.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图8</a>
                        <div>
                            <span>&yen; 346</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop7.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图7</a>
                        <div>
                            <span>&yen; 987</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop8.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图8</a>
                        <div>
                            <span>&yen; 453</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop7.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图7</a>
                        <div>
                            <span>&yen; 5643</span>
                            <span>美女</span>
                        </div>
                    </div>
                    <div class="intro">
                        <a href=""><img src="/static/images/shop/shop8.jpg" alt="" width="176" height="120"></a>
                        <a href="">美女性感写真海报墙艺术装饰画贴画图8</a>
                        <div>
                            <span>&yen; 2313</span>
                            <span>美女</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    分页条-->
        <div class="public-paginate">
            <a href="">&lt;</a>
            <a href="">1</a>
            <a href="">2</a>
            <a href="">3</a>
            <a href="">4</a>
            <a href="">5</a>
            <a href="">6</a>
            <a href="">7</a>
            <a href="">8</a>
            <a href="">&gt;</a>
        </div>
    </main>
    <!--公共页脚-->
    @include('shop/public/footer')
</body>

</html>