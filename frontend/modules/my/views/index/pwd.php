<section class="center">
    <div class="changePwd">
        <h2>修改密码</h2>
        <form id="reset" onsubmit="return false;">
            <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
            <table>
                <tr>
                    <td>原始密码</td>
                    <td><input name="oldpassword" id="oldpassword" type="password"></td>
                </tr>


                <tr>
                    <td>新密码</td>
                    <td><input name="password" id="password" type="password"></td>
                </tr>
                <tr>
                    <td>确认新密码</td>
                    <td><input name="password_confirm" id="password_confirm"  type="password"></td>
                </tr>
            </table>
            <button type="submit" class="commit">修改</button>
        </form>
    </div>
    <div class="modal">
        <div class="content">
            <a class="closeModal"><img src="/images/close.png"/> </a>
            <p>您的密码修改成功！</p>
            <button class="ok">确定</button>
        </div>
    </div>
</section>
<script>
    $().ready(function(){
        $("#reset")._clear_form(false);
        $("#reset").validate({
            rules: {
                oldpassword: {
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
                oldpassword: {
                    required: "请输入原始密码"
                },
                password: {
                    required: "请输入重置密码"
                },
                password_confirm: {
                    required: "请输入确认密码",
                    equalTo: "密码和确认密码不相同"
                }
            },
            errorPlacement: function(error, el) {
                $(el).after(error);
            },
            errorElement: "em",
            errorClass: "msg-error-pwd",
            submitHandler: function(form) {
                $._ajax('/my/index/alter-pwd', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code < 0) {
                        $(".commit")._error(json.msg);
                    }else{
                        $(".modal").show();
                    }
                });
            }
        });
    });

    $(".ok, .closeModal").click(function () {
        $(".modal").hide();
        window.location.reload();
    });
</script>