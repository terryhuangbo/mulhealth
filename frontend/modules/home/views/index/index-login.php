<div class="index">
    <div class="bannerTop"><a href="/my/index/index"><img src="<?php echo \Yii::$app->user->identity->avatar ?>"/></a></div>
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/images/banner1.png"/></div>
                <div class="swiper-slide"><img src="/images/banner2.png"/></div>
            </div>
        </div>
    </div>
    <div class="slideText">
        <marquee>最新动态-跑马灯</marquee>
    </div>
    <div class="navList">
        <div class="four">
            <ul>
                <li><a style="background: #04d4be;" href="/company/about/index">关于多源</a></li>
                <li><a style="background: #fa8cbd;" href="/company/about/team">技术团队</a></li>
                <li><a style="background: #0082c2;" href="/product/knowledge/items">产品知识</a></li>
                <li><a style="background: #ffb401;" href="/product/case/items">经典案例</a></li>
            </ul>
        </div>
        <div class="three">
            <ul>
                <li><a style="background: #c361e8;" href="/comment/index/index">多源之家</a></li>
                <li><a style="background: #6ec928;" href="">联系我们</a></li>
                <li><a style="background: #5cc2c2;" href="/my/report/index">体检报告</a></li>
            </ul>
        </div>
    </div>
</div>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//可选选项，自动滑动
        loop : true,
    })
</script>
