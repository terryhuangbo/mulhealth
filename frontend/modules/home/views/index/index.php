<div class="index">
    <div class="bannerTop"><a href="/user/index/login"><img src="/images/anumous.png"/> </a></div>
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($banners as $v): ?>
                    <?php if (empty($v['url'])): ?>
                        <div class="swiper-slide"><img src="<?php echo $v['src'] ?>"/></div>
                    <?php else: ?>
                        <div class="swiper-slide"><a href="<?php echo $v['url'] ?>"><img src="<?php echo $v['src'] ?>"/></a></div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="slideText">
        <marquee><?php echo !empty($latest) ? $latest : ''  ?></marquee>
    </div>
    <div class="nav">
        <ul>
            <li><a href="/company/about/index"><img class="fl" src="/images/index1.png"/></a></li>
            <li><a href="/my/index/index"><img class="fr" src="/images/index2.png"/></a></li>
            <li><a href="/company/about/guest"><img class="fl" src="/images/index3.png"/></a></li>
        </ul>
    </div>
</div>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//可选选项，自动滑动
        loop : true
    })
</script>