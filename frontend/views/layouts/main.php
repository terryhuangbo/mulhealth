<?php
use Yii;
$moduleId = $this->context->module->id;
$avatar = !Yii::$app->user->isGuest ? Yii::$app->user->identity->avatar : yiiParams('default_avatar');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0 user-scalable=no"/>
        <title>首页</title>
        <link rel="stylesheet" href="/css/style.css"/>
        <link rel="stylesheet" href="/css/swiper-3.4.0.min.css"/>
        <link rel="stylesheet" href="/css/extra.css"/>
        <script src="/js/jquery-3.1.1.min.js"></script>
        <script src="/js/swiper-3.4.0.min.js"></script>
        <script src="/js/jquery.validate.js"></script>
        <script src="/js/messages_zh.js"></script>
        <script src="/js/tools.js"></script>
    </head>
<body>
<section class="top">
    <p><a href="<?php echo Yii::$app->homeUrl ?>">多源健康</a></p>
    <div class="circle">
        <a href="/my/index/index"><img src="<?php echo $avatar ?>"/></a>
    </div>
</section>

<?php echo $content; ?>

<section class="bottom">
    <nav>
        <ul>
            <li>
                <a href="/company/about/index" <?php if($moduleId === 'company'):?>class="active"<?php endif ?>>
                    <div class="circle"><img src="/images/nav1.png"/></div>
                    <p>关于多源</p>
                </a>
            </li>
            <li>
                <a href="/product/index/index" <?php if($moduleId === 'product'):?>class="active"<?php endif ?>>
                    <div class="circle"><img src="/images/nav2.png"/></div>
                    <p>产品介绍</p>
                </a>
            </li>
            <li>
                <a href="/comment/index/index" <?php if($moduleId === 'comment'):?>class="active"<?php endif ?>>
                    <div class="circle"><img src="/images/nav3.png"/></div>
                    <p>多源之家</p>
                </a>
            </li>
            <li>
                <a href="/my/index/index" <?php if($moduleId === 'my'):?>class="active"<?php endif ?>>
                    <div class="circle"><img src="/images/nav4.png"/></div>
                    <p>我的多源</p>
                </a>
            </li>
        </ul>
    </nav>
</section>
<div class="modal body-modal">
    <div class="content">
        <a class="closeModal"><img src="/images/close.png"/> </a>
        <p>您的密码修改成功！</p>
        <button class="ok">确定</button>
    </div>
</div>
</body>
<script>
    var showModal = function (text, time, callback) {
        var dom = $('.body-modal');
        dom.find('p').text(text);
        $('.body-modal').show();
        if(typeof time == "number"){
            setTimeout(function () {
                $(".modal").hide();
                if (typeof callback == "function") {
                    callback();
                }
            }, time);
        }else if(typeof time == "function"){
            $(".ok").off('click').on('click', function () {
                $(".modal").hide();
                time();
            })
        }
    }
    $(".ok, .closeModal").click(function () {
        $(".modal").hide();
    });
</script>
</html>
<?php $this->endPage() ?>