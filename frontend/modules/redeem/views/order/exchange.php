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
    <title>聚惠银联 嗨翻大东北</title>
</head>
<body>
<section class="top">
    <a onclick="goBack();" class="fl back"><img src="/images/arrowLeft.png"/>返回</a>
    <p>确认兑换</p>
    <a href="/my/order" class="fr user"><img src="/images/user.png"/></a>
</section>
<section class="queryExchange">
    <div class="view">
        <img src="<?php echo yiiParams('img_host') . $goods['thumb'] ?>"/>
        <div class="infoDetail">
            <p>【兑换】 <?php echo $goods['name']  ?></p>
            <p>积分 <span><?php echo $goods['redeem_pionts']  ?></span></p>
        </div>
    </div>
    <div class="infoWrite">
        <form id="exchange">
            <table>
                <tr>
                    <td>收货人姓名</td>
                    <td><input name="receiver_name" value=""/></td>
                </tr>
                <tr>
                    <td>收货人联系方式</td>
                    <td><input name="receiver_mobile" value=""/></td>
                </tr>
                <tr>
                    <td>收货人所在地区</td>
                    <td>
                        <select name="receiver_province">
                            <?php foreach($provinces as $p): ?>
                                <option value="<?php echo $p['id'] ?>"><?php echo $p['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>手机号码服务商</td>
                    <td>
                        <select name="receiver_service">
                            <?php foreach($mobileService as $k => $p): ?>
                                <option value="<?php echo $k ?>"><?php echo $p ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="gid" value="<?php echo $gid ?>">
        </form>
    </div>
    <div class="confirm">
        <a href="javaScript:void(0)">立即兑换</a>
    </div>
</section>
</body>
<script>
    $(".confirm").on('click', function(){
        var param = $._get_form_json('#exchange');
        param._csrf = '<?php echo Yii::$app->request->csrfToken ?>';
        console.log(param);
        var url = '<?php echo yiiUrl("redeem/order/confirm-exchange") ?>';
        $._ajax(url, param, 'POST', 'JSON', function(json){
            if(json.code > 0){

            }else{
                alert(json.msg);
            }
        });
    });
</script>

</html>