<section class="center">
    <div class="my">
        <div class="head">
            <div class="tx">
                <div class="img">
                    <img class="txImg" src="/images/tx.png"/>
                    <img class="sex" src="/images/sex.png"/>
                </div>
                <div class="text">
                    <p><?php echo $user['name'] ?></p>
                    <p>31岁</p>
                </div>
            </div>
        </div>
        <div class="info">
            <form id="perfection" onsubmit="return false;">
                <table>
                    <tr>
                        <td>昵称</td>
                        <td>
                            <input type="text" id="nick" name="nick" maxlength="12" value="<?php echo $user['nick'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>性别</td>
                        <td><label><input type="radio" id="sex" name="sex" value="1" <?php if($user['sex'] === 1){echo "checked='checked'";}?>>男</label>
                            <label><input type="radio" name="sex"  value="2" <?php if($user['sex'] === 2 ){echo "checked='checked'";}?>>女</label>
                        </td>
                    </tr>
                    <tr>
                        <td>真实姓名</td>
                        <td><input type="text" id="name" name="name" value="<?php echo $user['name'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>身份证号</td>
                        <td><input type="text" id="id_card" name="id_card" value="<?php echo $user['id_card'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>联系方式</td>
                        <td><input type="tel" id="mobile" name="mobile" value="<?php echo $user['mobile'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>通讯地址</td>
                        <td><input type="text" id="address" name="address" value="<?php echo $user['address'] ?>" /></td>
                    </tr>
                </table>
                <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
                <button type="submit" class="saveBtn">保存</button>
            </form>
        </div>
    </div>
</section>
<script>
    $().ready(function(){
        $("#perfection").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 20
                },
                id_card: {
                    required: true
                },
                nick: {
                    required: true
                },
                sex: {
                    required: true
                },
                mobile: {
                    required: true
                },
                address: {
                    required: true
                }

            },
            messages: {
                name: {
                    required: "请输入真实姓名"
                },
                id_card: {
                    required: "请输入身份证号码"
                },
                nick: {
                    required: "请输入昵称"
                },
                sex: {
                    required: "请选择性别"
                },
                mobile: {
                    required: "请输入联系方式"
                },
                address: {
                    required: "请输入通讯地址"
                }

            },
            errorPlacement: function(error, el) {
                $(el).closest('td').after(error);
            },
            errorElement: "td",
            submitHandler: function(form) {
                $._ajax('/my/profile/perfect', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code < 0) {
                        $(".saveBtn")._error(json.msg);
                    }
                });
            }
        });
    });
</script>
