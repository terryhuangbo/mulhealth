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
                    <a href="<?php echo yiiUrl(['comment/index/release', 'pid' => $comment['id']]) ?>"><img src="/images/chat.png"/></a>
                    <?php  if($comment['isLiked']): ?>
                        <a href="javaScript:void(0)" class="addLike" cid="<?php echo $comment['id'] ?>"><img src="/images/like.png"/></a>
                    <?php  else: ?>
                        <a href="javaScript:void(0)" class="addLike unlike" cid="<?php echo $comment['id'] ?>"><img src="/images/unlike.png"/></a>
                    <?php  endif ?>
                </div>
            </div>
        <? endforeach ?>


        <div class="release">
            <a href="/comment/index/release"><img src="/images/release.png"/>发帖 </a>
        </div>
    </div>
</section>
<script>
    $(".addLike").on('click', function () {
        var _this = $(this);
        var cid = _this.attr('cid');
        $._ajax('<?php echo yiiUrl("comment/like/add") ?>', {cid: cid}, 'GET', 'JSON', function (json) {
            if (json.code == 20000) {
                //点赞成功
                alert(json.msg);
                _this.find('img').attr('src', '/images/like.png');
            } else if (json.code == 20001) {
                //取消点赞成功
                alert(json.msg);
                _this.find('img').attr('src', '/images/unlike.png');
            } else {
                alert(json.msg);
            }
        });
    })
</script>

