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
                    <a href="javaScript:void(0)" class="shareIcon"
                       data-content="<?php echo $comment['content'] ?>"
                       data-nick="<?php echo $comment['nick'] ?>"
                       data-avatar="<?php echo $comment['avatar'] ?>">
                        <img src="/images/share.png"/>
                    </a>
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
    
    $(".shareIcon").on('click', function () {
        var dom = $(this);
        var data = dom.data();
        data.href = window.location.href;
        sendMessage(data);
    })

    function sendMessage(data) {
        WeixinJSBridge.on('menu:share:appmessage', function (argv) {

            WeixinJSBridge.invoke('sendAppMessage', {

                "appid": "", //appid 设置空就好了。
                "img_url": '/images/release.png', //分享时所带的图片路径
                "img_width": "120", //图片宽度
                "img_height": "120", //图片高度
                "link": window.location.href, //分享附带链接地址
                "desc": "我是一个介绍", //分享内容介绍
                "title": "标题，再简单不过了。"
            }, function (res) {/*** 回调函数，最好设置为空 ***/

            });

        });
    }

    if (document.addEventListener) {
        document.addEventListener('WeixinJSBridgeReady', sendMessage, false);
    } else if (document.attachEvent) {
        document.attachEvent('WeixinJSBridgeReady', sendMessage);
        document.attachEvent('onWeixinJSBridgeReady', sendMessage);
    }
</script>

