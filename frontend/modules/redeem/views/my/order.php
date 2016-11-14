<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name='HandheldFriendly' content='True'/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="/js/main.js"></script>
    <title>聚惠银联 嗨翻大东北</title>
</head>
<body>
<section class="top">
    <a onclick="goBack();" class="fl back"><img src="/images/arrowLeft.png"/>返回</a>
    <p>我的兑换记录</p>
</section>
<section class="record">
    <?php foreach($order_list as $order): ?>
        <div class="recordList">
            <p class="fl">订单编号:<?php echo $order['order_id'] ?></p>
            <p class="fr">交易时间：<?php echo date('Y/m/d', $order['create_at']) ?></p>
            <table>
                <tr>
                    <td><img src="<?php echo yiiParams('img_host') . $order['goods']['thumb'] ?>"/> </td>
                    <td><?php echo $order['goods']['description'] ?></td>
                    <td><span><?php echo $order['goods']['redeem_pionts'] ?></span>积分 </td>
                </tr>
            </table>
        </div>
    <?php endforeach ?>
</section>
</body>

</html>