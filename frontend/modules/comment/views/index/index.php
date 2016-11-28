<section class="center">
    <div class="home">
        <? foreach ($comments as $comment): ?>
            <div class="list">
                <div class="title">
                    <p class="fl"><img src="<?php echo $comment['avatar'] ?>" alt="头像" class="fl"><?php echo $comment['nick'] ?></p>
                    <p class="fr"><?php echo $comment['create_at'] ?></p>
                </div>
                <div class="content">
                    <p><?php echo $comment['content'] ?></p>
                </div>
                <div class="tail">
                    <a href=""><img src="/images/share.png"/></a>
                    <a href=""><img src="/images/chat.png"/></a>
                    <a href=""><img src="/images/like.png"/></a>
                </div>
            </div>
        <? endforeach ?>


        <div class="release">
            <a href="/comment/index/release"><img src="/images/release.png"/>发帖 </a>
        </div>
    </div>
</section>

