<script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
<style>
    .webuploader-element-invisible{
        display: none;
    }
</style>
<section class="center">
    <div class="my">
        <div class="head">
            <div class="tx">
                <div class="img">
                    <div id="thumbpic"><img  class="txImg" src="<?php echo $user['avatar'] ?>"/></div>
                    <img class="sex" src="/images/sex.png"/>
                </div>
                <div class="text">
                    <p><?php echo $user['name'] ?></p>
                    <p><?php echo $user['age'] ?>岁</p>
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
                <input type="hidden" name="avatar" value="<?php echo $user['avatar'] ?>">
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
                $(el).after(error);
            },
            errorElement: "em",
            errorClass: "msg-error",
            submitHandler: function(form) {
                $._ajax('/my/profile/perfect', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code < 0) {
                        $(".saveBtn")._error(json.msg);
                    }
                });
            }
        });
    });

    //头像上传
    $(function () {
        /*上传缩略图*/
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            //文件名称
            fileVal: 'attachment',
            // swf文件路径
            swf: '/plugins/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: "/common/file/upload",
            // 选择文件的按钮。可选。
            pick: '#thumbpic',
            //文件数量
//                fileNumLimit: 3,
            //文件大小 byte
            fileSizeLimit: 5 * 1024 * 1024,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //传递的参数
            formData: {
                objtype: 'case'
            }
        });
        // 当有文件添加进来之前
        uploader.on('beforeFileQueued', function (handler) {

        });
        // 当有文件添加进来的时候-执行队列
        uploader.on( 'fileQueued', function( file ) {

        });
        //文件数量，格式等出错
        uploader.on('error', function (handler) {
            _file_upload_notice(handler);
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, response) {
            if(response.code > 0){
                var data = response.data;//<div id="thumbpic"><img  class="txImg" src="/images/tx.png"/></div>
                var div = '<img  class="txImg" src="'+ data.url +'"/>';
                $('#thumbpic').html(div);
                $('[name=avatar]').val(data.url);
            }else{
                BUI.Message.Alert('上传失败！');
            }
        });
        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {

        });
    });

    var _file_upload_notice = function (handler) {
        switch (handler) {
            case 'Q_TYPE_DENIED':
                alert('文件类型不正确！');
                break;
            case 'Q_EXCEED_SIZE_LIMIT':
                alert('上传文件总大小超过限制！');
                break;
            case 'Q_EXCEED_NUM_LIMIT':
                alert('上传文件总数量超过限制！');
                break;
        }
    };
</script>
