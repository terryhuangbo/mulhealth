<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name='HandheldFriendly' content='True'/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <link rel="stylesheet" href="/css/login/style.css">
    <title>聚惠银联 嗨翻大东北</title>
    <style>
        body, html {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="login">
    <form id="reg" onsubmit="return false;">
        <input class="telInput" type="tel" name="mobile" placeholder="请输入您的手机号码"/>
        <button id="submit">提交</button>

    </form>
</div>
</body>
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/main.js"></script>
<script src="/js/tools.js"></script>

<script>
    $("#submit").on('click', function(){
        var param = $._get_form_json('#reg');
        $._ajax('/redeem/user/login', param, 'POST', 'JSON', function(json){
            var code = json.code;
            var msg = json.msg;
            if(code > 0){
                window.location.href = json.data.redirect;
            }else{
                alert(msg);
                return;
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=mobile]").closest('div').after(error);
                error.fadeOut(1500);
            }
        });
    });

</script>
</html>