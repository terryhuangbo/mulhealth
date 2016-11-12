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
    <script src="/js/tools.js"></script>
    <title>聚惠银联</title>
</head>
<body>
<section class="top">
    <a onclick="goBack();" class="fl back"><img src="/images/arrowLeft.png"/>返回</a>
    <p>聚惠银联 嗨翻大东北</p>
    <a href="/my/order" class="fr user"><img src="/images/user.png"/></a>
</section>
<section class="banner">
    <a href="/activity/index"><img src="/images/banner.png"/></a>
</section>
<section class="info">
    <div class="name">
        <div class="tx"><img src="/images/tx.png"/></div>
        <p class="fc"><?php echo $user['mobile'] ?></p>
        <p>我的积分:<span><?php echo $user['points'] ?></span></p>
    </div>
    <div class="signBtn">
        <a class="qiandao">签到赚积分</a>
    </div>
</section>
<section class="goodsList">
    <?php foreach ($goods_list as $good):?>
        <div class="goods">
            <table>
                <tr>
                    <td><img src="<?php echo yiiParams('img_host') . $good['thumb'] ?>" alt="20元手机充值卡"></td>
                    <td><p><?php echo $good['name'] ?></p><p><span><?php echo $good['redeem_pionts'] ?></span><label>积分</label></p></td>
                    <td><img src="/images/arrowRight.png"></td>
                    <td><a href="<?php echo yiiUrl(['/redeem/goods/view', 'gid' => $good['gid']]) ?>"></a></td>
                </tr>
            </table>
        </div>
    <?php endforeach;?>
</section>
</body>

<script>
    $(".qiandao").on('click', function(){
        $._ajax('/home/sign', {}, 'POST', 'JSON', function(json){
            if(json.code > 0){
                window.location.reload();
            }else{
                $(".qiandao").off('click');
            }
        });
    });
</script>

<!--微信分享-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $this->context->signPackage["appId"];?>',
        timestamp: <?php echo $this->context->signPackage["timestamp"];?>,
        nonceStr: '<?php echo $this->context->signPackage["nonceStr"];?>',
        signature: '<?php echo $this->context->signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            "onMenuShareAppMessage",
            "onMenuShareTimeline",
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        //发送给朋友
        wx.onMenuShareAppMessage({
            title: '聚惠银联，嗨翻大东北', // 分享标题
            desc: '', // 分享描述
            link: '', // 分享链接
            imgUrl: '<?php echo yiiParams('share_img') ?>', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                $._ajax('/home/share', {}, 'POST', 'JSON', function(json){});
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: '聚惠银联，嗨翻大东北', // 分享标题
            link: '', // 分享链接
            imgUrl: '<?php echo yiiParams('share_img') ?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                $._ajax('/home/share', {}, 'POST', 'JSON', function(json){});
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>
</html>