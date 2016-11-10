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
    <title>确认订单</title>
</head>
<body>
<section class="top">
    <a onclick="goBack();" class="fl back"><img src="/images/arrowLeft.png"/>返回</a>
    <p>确认兑换</p>
    <a href="/my/order" class="fr user"><img src="/images/user.png"/></a>
</section>
<section class="queryExchange">
    <div class="view">
        <img src="/images/20.png"/>
        <div class="infoDetail">
            <p>【兑换】 价值20元 手机充值卡</p>
            <p>积分 <span>999</span></p>
        </div>
    </div>
    <div class="infoWrite">
        <table>
            <tr>
                <td>收货人姓名</td>
                <td><input/></td>
            </tr>
            <tr>
                <td>收货人联系方式</td>
                <td><input/></td>
            </tr>
            <tr>
                <td>收货人所在地区</td>
                <td>
                    <select>
                        <option value="1">黑龙江省</option>
                        <option value="2">吉林省</option>
                        <option value="3">辽宁省</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>手机号码服务商</td>
                <td>
                    <select>
                        <option value="1">移动</option>
                        <option value="2">联通</option>
                        <option value="3">电信</option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="confirm">
        <a href="">立即兑换</a>
    </div>
</section>
</body>
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/main.js"></script>
</html>