<script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
<style>
    .webuploader-element-invisible{
        display: none;
    }
</style>
<section class="center">
    <div class="upload">
        <form id="comment" onsubmit="return false;" action="">
            <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
            <input type="hidden" name="pid" value="<?php echo $pid ?>">
            <textarea name="content" maxlength="140" placeholder="说两句吧"></textarea>
            <div class="btn">
                <label>剩余<span>140</span>字</label>
                <button class="commit">提交</button>
                <button class="cancel" onclick="history.go(-1);">取消</button>
            </div>
            <div class="uploadImg" id="uploadFile">
                <div id="uploadImgContent">
                </div>
                <div class="uploadFile" >
                    <img src="/images/addPic.png"/>
                </div>
                <div style="clear: both;"></div>
                <p>最多可上传8张图片</p>
            </div>
        </form>
    </div>
</section>
<script>
    $().ready(function(){
        $("#comment")._clear_form(false);
        $(".commit").click(function () {
            var param =  $("#comment").serialize();
            var content = $("[name=content]").val();
            if (content.length == 0) {
                alert('请输入内容');
                return
            }
            if ($._str_len(content.length) > 140) {
                alert('评论内容不能超过140个字');
                return
            }

            $._ajax('/comment/index/release', param, 'POST', 'JSON', function(json){
                if(json.code < 0) {
                    alert(json.msg);
                    return
                }
            });
        });
    });

    //图片上传
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
            pick: '#uploadFile',
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
                objtype: 'comment'
            }
        });
        // 当有文件添加进来之前
        uploader.on('beforeFileQueued', function (handler) {
            if ($('.uploadImg').find('img').length > 8) {
                alert('最多可上传8张图片');
                return false;
            }
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
                var data = response.data;//<img src="/images/upload.png"/>
                var div = '<img src="'+ data.url +'"/>';
                var input = '<input type="hidden" name="pics[]" value="'+ data.url +'">';
                $('#uploadImgContent').append(div);
                $('#comment').prepend(input);
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
