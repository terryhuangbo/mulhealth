<div class="login">
    <form id="register" onsubmit="return false;">
        <input type="text" id="name" name="name" placeholder="请输入您的真实姓名">
        <input type="text" id="id_card" name="id_card" placeholder="请输入您的身份证号码" required>
        <input type="password" id="password" name="password" placeholder="请输入您的密码">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="请确认您的密码">
        <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
        <input type="submit" class="submit" value="立即注册"/>
    </form>
</div>
<script>
    $().ready(function(){
        $("#register")._clear_form(false);
        $("#register").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 20
                },
                id_card: {
                    required: true
                },
                password: {
                    required: true
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                name: {
                    required: "请输入真实姓名"
                },
                id_card: {
                    required: "请输入身份证号码"
                },
                password: {
                    required: "请输入密码"
                },
                password_confirm: {
                    required: "请输入确认密码",
                    equalTo: "密码和确认密码不相同"
                }
            },
            errorPlacement: function(error, el) {
                $(el).after(error);
            },
            errorElement: "p",
            submitHandler: function(form) {
                $._ajax('/user/index/register', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code < 0) {
                        $(".submit")._error(json.msg);
                    }
                });
            }
        });
    });
</script>
