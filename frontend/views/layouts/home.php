<?php
use yii\helpers\Html;
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
<?php echo $content ?>
</body>
</html>
<?php $this->endPage() ?>