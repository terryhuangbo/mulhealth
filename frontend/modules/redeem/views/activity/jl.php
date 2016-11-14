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
    <title>聚惠银联 嗨翻大东北</title>
</head>
<body>
<section class="jls">
    <a class="game" href="http://game.zuikuh5.com/g/5001.html" target="_blank" class="btn"></a>
    <a class="btn"><img src="/images/jlBtn.png"></a>
    <?php foreach($activities as $k => $activity): ?>
        <a  class="<?php echo $class_array[$k] ?> brand">
            <img class="activityDetail" num="<?php echo $k ?>"  src="<?php echo yiiParams('img_host') . $activity['poster'] ?>">
        </a>
    <?php endforeach ?>
<!--    <a class="hll_jl"><img src="/images/hll.png"></a>-->
<!--    <a class="xtdcs"><img src="/images/xtdcs.png"></a>-->
<!--    <a class="drf_jl"><img src="/images/drf.png"></a>-->
<!--    <a class="oyjt"><img src="/images/oyjt.png"></a>-->
<!--    <a class="ct"><img src="/images/ct.png"></a>-->
<!--    <a class="gpp"><img src="/images/gpp.png"></a>-->
</section>
<div class="fixBg">
    <div class="pop">
        <a class="close"></a>
        <div class="title">
            <img id="act_img" src="/images/drfLogo.png"/>
            <div class="line"></div>
            <p id="begin-end">2016.11.16-2017.01.25</p>
        </div>
        <div class="actInfo">
            <ul>
                <li>活动时间：</li>
                <li id="act_day">2016年11月16日-2017年1月25日，每周三、周日</li>
            </ul>
            <ul>
                <li>活动对象：</li>
                <li id="act_aims">建行、交行、招行银联信用卡（卡号62开头）及银联云闪付持卡人</li>
            </ul>
            <ul>
                <li>活动形式：</li>
                <li id="act_way">单笔消费满188元，随机立减8元-免单</li>
            </ul>
            <ul>
                <li>限额说明：</li>
                <li id="act_limitation">每活动日限前6000名，单卡单日限一次优惠，名额有限，送完为止。免单最高优惠300元，免单需支付1分钱作为记账凭证。</li>
            </ul>
            <ul>
                <li>活动细则：</li>
                <li id="act_details">1. 每活动日限前6000名，单卡单日限一次优惠，名额有限，送完为止；活动减免金额最低为8元上限为300元，持卡人获得免单后仍需要支付1分钱，作为记账处理。<br/>
                    2. 上述活动中刷卡消费数据以银联系统记载的交易日期及交易金额为准。<br/>
                    3. 购买超市预付卡，香烟类商品不可参加本活动，拆单使用多张信用卡结账不可参加本活动。<br/>
                    4. 活动期间由于大润发旗下门店地址变更，工程装修，停业整顿或自然灾害等不可抗力原因导致门店未能正常营业的情况与中国银联无关，建议持卡人参与活动前向商家咨询确认。</li>
            </ul>
        </div>
    </div>
</div>
</body>
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/main.js"></script>
<script src="/js/tools.js"></script>
<script src="/js/message.js"></script>
<script>
    $(function () {
        var hasGetPoints = false;
        $('.activityDetail').on('click', function(){
            var dom = $(this);
            var num = parseInt(dom.attr('num'));
            var activities = <?php echo json_encode($activities) ?>;
            $("#act_img").attr('src', '<?php echo yiiParams("img_host") ?>' + activities[num].logo);
            $("#act_day").text(activities[num].begin_end);
            $("#begin-end").text(activities[num].begin_end1);
            $("#act_aims").text(activities[num].aims);
            $("#act_way").text(activities[num].way);
            $("#act_limitation").text(activities[num].limitation);
            $("#act_details").text(activities[num].details);

            if(hasGetPoints){
                return
            }
            var id = activities[num].id;
            $._ajax('/activity/points', {id: id}, 'POST', 'JSON', function(json){
                if(json.code > 0){
                    Alert('恭喜获得1点积分', 2000);
                    hasGetPoints = true;
                }else{
                }
            })
        });
    })
</script>
</html>