<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $goods['name'] ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name='HandheldFriendly' content='True'/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/tools.js"></script>
    <title>聚惠银联 嗨翻大东北</title>
</head>
<body>
<section class="top">
    <a onclick="goBack();" class="fl back"><img src="/images/arrowLeft.png"/>返回</a>
    <p>【兑换】 手机充值卡</p>
    <a href="/my/order" class="fr user"><img src="/images/user.png"/></a>
</section>
<section class="detail">
    <img src="<?php echo yiiParams('img_host') . $goods['thumb'] ?>"/>
    <ul>
        <li><p><?php echo $goods['description'] ?></p></li>
        <li><p>兑换积分<span><?php echo $goods['redeem_pionts'] ?></span>分</p></li>
        <li><small>温馨提示：兑换商品在下单之后3日内按照顺序安排发货。</small></li>
        <!--<li><a href=""><small>图文详情<span>（建议在wifi环境下进行浏览）</span></small><img src="images/arrowR.png"/></a></li>-->
    </ul>
    <div class="exchange">
        <a href="<?php echo yiiUrl(['order/exchange', 'gid' => $goods['gid']])  ?>">立即兑换</a>
    </div>
</section>
</body>

</html>