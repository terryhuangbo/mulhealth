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
        <script src="/js/jquery-1.11.3.min.js"></script>
        <script src="/js/swiper-3.4.0.min.js"></script>
        <script src="/js/jquery.validate.js"></script>
        <script src="/js/messages_zh.js"></script>
        <script src="/js/tools.js"></script>
    </head>
<body>
<?php echo $content ?>
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