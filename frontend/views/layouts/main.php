<?php
use yii\helpers\Html;
$moduleId = $this->context->module->id;
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
        <script src="/js/jquery-3.1.1.min.js"></script>
        <script src="/js/swiper-3.4.0.min.js"></script>
        <script src="/js/tools.js"></script>
    </head>
<body>
<?php echo $content;lg($this->context); ?>
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
</body>
</html>
<?php $this->endPage() ?>