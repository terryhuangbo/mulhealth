<section class="center">
    <div class="team">
        <div class="title"><img src="/images/teamTitle.png"/></div>
        <div class="img">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($knowledge['pic'] as $v): ?>
                        <div class="swiper-slide"><img src="<?php echo $v ?>"> </div>
                    <?php endforeach ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <div class="text"><?php echo $knowledge['detail'] ?>
        </div>
    </div>
</section>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//可选选项，自动滑动
        prevButton:'.swiper-button-prev',
        nextButton:'.swiper-button-next',
        loop : true
    })
</script>