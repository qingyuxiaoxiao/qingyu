<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--    当前文档要用到阿里字体图标-->
    <link rel="stylesheet" href="/static/font/iconfont.css">
    <link rel="stylesheet" href="/static/css/shop_detail.css">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <title>{{$item['title']}}-php中文网</title>
</head>
<body>
<!--公共页眉-->
 @include('shop/public/header')

<!--主体全部放在main元素中-->
<main>
<!--    商城公共头部-->
    <!--logo+搜索框+快捷入口区-->
    @include('shop/public/header_search')

    <!--为商品详情区块单独创建一个包含块,方便用网格布局-->
    <div class="detail">
        @csrf
        <!--商城详情页上部购买组件-->
        <div class="shop-detail-bug">
            <!--头部面包屑导航-->
            <nav>
                <a href="">首页&nbsp;&gt;&nbsp;</a>
                <a href="">图片写真&nbsp;&gt;&nbsp;</a>
                <a href="">日本&nbsp;&gt;&nbsp;</a>
                <a href="">颖宝宝</a>
            </nav>

            <article>
                <input type="hidden" name="pro_id" value="{{$item['id']}}">
                <span><img src="{{$item['thumb']}}" alt=""></span>
                <div>
                    <!--商品标题-->
                    <h3>{{$item['title']}}</h3>
                    <!--商品价格-->
                    <div class="price">
                        <span>本站特惠:</span>
                        <span>&yen;{{$item['price']}}</span>
                    </div>
                    <!--基本描述-->
                    <div class="desc">
                        销量: <span>13</span>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        累积评价: <span>3</span>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        好评率: <span>199%</span>
                    </div>
                    <!-- 购买数量-->
                    <div class="buy-num">
                        <label for="num">购买数量:</label><input type="number" id="num" value="1">
                    </div>
                    <!--购买按钮-->
                    <div class="buy-btn">
                        <button onclick="buy()">立即购买</button>
                        <button><i class="iconfont icon-icon_tianjia"></i>加入购物车</button>
                    </div>
                    <!--售后承诺-->
                    <div class="promise">
                        <span><i class="iconfont icon-zhanghaoquanxianguanli"></i>本站保障</span>
                        <span><i class="iconfont icon-icon_safety"></i>企业认证</span>
                        <span><i class="iconfont icon-tianshenpi"></i>退款承诺</span>
                        <span><i class="iconfont icon-kuaisubianpai"></i>免费换货</span>
                    </div>
                </div>
            </article>
        </div>

        <!--商城详情页左下推荐商品列表-->
        <div class="shop-detail-recommend">
            <h3>推荐商品</h3>
            <div>
                <a href="">
                    <img src="/static/images/shop/shop1.jpg" alt="">
                </a>
                <a href="">韩国美女最新海报促销美妆写真图集</a>
                <div class="hot">
                    <span>热销:</span><span>8976</span>
                    <span>价格:</span><span>&yen;99</span>
                </div>
            </div>
            <div>
                <a href="">
                    <img src="/static/images/shop/shop2.jpg" alt="">
                </a>
                <a href="">韩国美女最新海报促销美妆写真图集</a>
                <div class="hot">
                    <span>热销:</span><span>324</span>
                    <span>价格:</span><span>&yen;798</span>
                </div>
            </div>
            <div>
                <a href="">
                    <img src="/static/images/shop/shop3.jpg" alt="">
                </a>
                <a href="">韩国美女最新海报促销美妆写真图集</a>
                <div class="hot">
                    <span>热销:</span><span>678</span>
                    <span>价格:</span><span>&yen;630</span>
                </div>
            </div>
            <div>
                <a href="">
                    <img src="/static/images/shop/shop4.jpg" alt="">
                </a>
                <a href="">韩国美女最新海报促销美妆写真图集</a>
                <div class="hot">
                    <span>热销:</span><span>12</span>
                    <span>价格:</span><span>&yen;980</span>
                </div>
            </div>
        </div>

        <!--商城详情页右下详情选项卡-->
        <div class="shop-detail-tab">
            <div class="tab">
                <span class="active">商品详情</span>
                <span>案例/演示</span>
                <span>常见问题</span>
                <span>累计评价</span>
                <span>产品咨询</span>
            </div>
            <div class="content">{!!$detail['contents']!!}</div>
        </div>

        <!--评论与回复-->
        <div class="public-comment-reply">
            <!--    评论区-->
            <div class="comment">
                <h3>我要评论</h3>
                <div>
                    <label for="comment"><img src="/static/images/user.png" alt=""></label>
                    <textarea name="" id="comment"></textarea>
                </div>
                <button>发表评论</button>
            </div>

            <!--    回复区-->
            <div class="reply">
                <h3>最新回复</h3>
                <div>
                    <img src="/static/images/user.png" alt="">
                    <div class="detail">
                        <span>用户昵称</span>
                        <span>留言内容: php中文网,是一个有温度,有思想的学习平台</span>
                        <div>
                            <span>2019-12-12 15:34:23发表</span>
                            <span><i class="iconfont icon-dianzan"></i>回复</span>
                        </div>
                    </div>
                </div>

                <div>
                    <img src="/static/images/user.png" alt="">
                    <div class="detail">
                        <span>用户昵称</span>
                        <span>留言内容: php中文网,是一个有温度,有思想的学习平台</span>
                        <div>
                            <span>2019-12-12 15:34:23发表</span>
                            <span><i class="iconfont icon-dianzan"></i>回复</span>
                        </div>
                    </div>
                </div>

                <div>
                    <img src="/static/images/user.png" alt="">
                    <div class="detail">
                        <span>用户昵称</span>
                        <span>留言内容: php中文网,是一个有温度,有思想的学习平台</span>
                        <div>
                            <span>2019-12-12 15:34:23发表</span>
                            <span><i class="iconfont icon-dianzan"></i>回复</span>
                        </div>
                    </div>
                </div>

                <div>
                    <img src="/static/images/user.png" alt="">
                    <div class="detail">
                        <span>用户昵称</span>
                        <span>留言内容: php中文网,是一个有温度,有思想的学习平台</span>
                        <div>
                            <span>2019-12-12 15:34:23发表</span>
                            <span><i class="iconfont icon-dianzan"></i>回复</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--公共页脚-->
@include('shop/public/footer')
</body>
</html>
<script type="text/javascript">
    layui.use('layer',function(){
        layer = layui.layer;
    });

    // 购买
    function buy(){
        var pro_id = parseInt($('input[name="pro_id"]').val());
        var buycount = parseInt($('#num').val());
        if(isNaN(pro_id)||pro_id==0){
            return layer.alert('商品参数错误',{icon:2});
        }
        if(isNaN(buycount)||buycount==0){
            return layer.alert('购买数量错误',{icon:2});
        }

        // 下订单
        var price = $('input[name="price"]').val();
        var _token = $('input[name="_token"]').val();
        $.post('/shop/create_order',{proid:pro_id,buycount:buycount,_token:_token},function(res){
            // 未登录
            if(res.code==401){
                layer.open({
                  type: 2,
                  title: '登录',
                  shadeClose: true,
                  shade: 0.8,
                  area: ['400px', '300px'],
                  content: '/account/login' //iframe的url
                }); 
                return;
            }
            if(res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            layer.open({
                type: 2,
                title: '付款',
                shadeClose: true,
                shade: 0.8,
                area: ['400px', '400px'],
                content: '/shop/pay?ord_no='+res.ord_no //iframe的url
            });
        },'json');
    }
</script>