<div class="login">
    <form id="login" onsubmit="return false;">
        <input type="text" id="id_card" name="id_card" placeholder="请输入您的用户名">
        <input type="password" id="password" name="password" placeholder="请输入您的密码">
        <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
        <input type="submit" class="submit" value="登录"/>
    </form>
    <p>
        <span><a href="/user/index/register">立即注册</a></span>
        <span><a href="/user/index/reset">忘记密码</a></span>
    </p>
</div>
<script>
    $().ready(function(){
        $("#login")._clear_form(false);
        $("#login").validate({
            rules: {
                id_card: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                id_card: {
                    required: "请输入身份证号码"
                },
                password: {
                    required: "请输入密码"
                }
            },
            errorPlacement: function(error, el) {
                $(el).after(error);
            },
            errorElement: "p",
            submitHandler: function(form) {
                $._ajax('/user/index/login', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code < 0) {
                        $(".submit")._error(json.msg);
                    }
                });
            }
        });
    });
</script>