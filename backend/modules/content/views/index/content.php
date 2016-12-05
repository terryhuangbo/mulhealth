<?php
use yii\helpers\Html;
use common\models\Meta;
$meta = new Meta();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>内容配置</title>

    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
    <style>
        .user_avatar {
            width: 120px;
            height: 80px;
            margin: 10px auto;
        }
        .demo-content{
            margin: 40px 60px;
        }

        .webuploader-element-invisible{
            display: none;
        }

        .layout-outer-content{
            padding: 15px;
            margin: 10px 0px 40px 130px;
            width: 800px;
            background-color: #f6f6fb;
            border: 1px solid #c3c3d6;
        }
        .layout-content{
            width: 300px;
            margin: 10px 120px;
        }
        .img-content-li{
            width: 200px;
            height: 150px;
            margin-left: -50px;
        }
        .img-content-li img{
            width: 120px;
            height:90px;
        }
        .img-content-li p{
            padding: 2px 0px;
        }

        .img-delete{
            position: relative;
            top:17px;
            left: 91px;
        }

    </style>
</head>

<body>
<div class="demo-content">
    <form id="Config_Form" action="" class="form-horizontal" onsubmit="return false;">

        <div class="control-group">
            <label class="control-label"><s>*</s>最新动态：</label>
            <div class="controls">
                <input type="text" name="config[latest]" class="input-large" data-rules="{required : true}" value="<?php echo $latest ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><s>*</s>轮播Banner：</label>
            <div class="controls">
                <input type="text" class="input-large" data-rules="{required : true}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><s>*</s>项目缩略图：</label>
            <div id="thumbpic" class="controls">
                <span class="button button-primary">上传图片</span>
            </div>
        </div>

        <div class="row" >
            <div class="span16 layout-outer-content">
                <div id="thumbpic-content" class="layout-content" aria-disabled="false" aria-pressed="false" >
                    <?php foreach($project as $v): ?>
                        <div id="" class=" pull-left img-content-li">
                            <a href="javaScript:;"><span class="label label-important img-delete" file-path="<?php echo $v ?>">删除</span></a>
                            <div aria-disabled="false"  class="" aria-pressed="false">
                                <img  src="<?php echo $v ?>" />
                                <input type="hidden" name="" value="<?php echo $v ?>">
                                <p>链接：<input type="text" name="" class="input-small"   value="<?php echo $latest ?>">
                                </p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="save-config">保存</button>
                <button type="reset" class="button" id="cancel-config">返回</button>
            </div>
        </div>
    </form>

<!-- script start -->
<script type="text/javascript">
    BUI.use('bui/form',function(Form){
        var form = new Form.Form({
            srcNode : '#Config_Form'
        });
        form.render();

        //保存
        $("#save-config").on('click', function(){
            if(form.isValid()){
                var param = $._get_form_json("#Config_Form");
                $._ajax('/content/index/content', param, 'POST', 'JSON', function(json){
                    if(json.code > 0){
//                        BUI.Message.Alert('保存成功', 'success');
                    }else{
                        BUI.Message.Alert(json.msg, 'error');
                        this.close();
                    }
                });
            }
        });
        //返回
        $("#cancel-config").on('click', function(){
            window.location.href = '/config/config/list';
        });
    });
</script>
<!-- script end -->

<script>
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
//                fileNumLimit: 1,
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
                objtype: 'case',
            }
        });
        // 当有文件添加进来之前
        uploader.on('beforeFileQueued', function (handler) {
            if ($(".img-content-li").length >= 3) {
                alert('上传文件总数量超过限制！');
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
                var data = response.data;
                var div =
                    '<div id="'+ file.id +'" class=" pull-left img-content-li">'+
                    '<a href="javaScript:;"><span class="label label-important img-delete" file-path="'+ data.filePath +'">删除</span></a>'+
                    '<div aria-disabled="false"  class="" aria-pressed="false">'+
                    '<img  src="'+ data.url +'" />'+
                    '<input type="hidden" name="pic[]" value="'+ data.url +'">'+
                    '<p>'+ file.name +'</p>'+
                    '</div>'+
                    '</div>';
                $('#thumbpic-content').append(div);
                uploaderlist.addButton({
                    id: '#thumblistpic'
                });
                $('.img-delete').off('click').on('click', function(){
                    var dom = $(this);
                    var filePath = dom.attr('file-path');
                    deleteFile(filePath, function(json){
                        if(json.code > 0){
                            dom.closest('div').remove();
                            uploader.reset();
                        }else{
                            BUI.Message.Alert('删除失败！');
                        }
                    });
                });
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

    var deleteFile = function (filePath, callback){
        $._ajax('/common/file/delete', {filepath: filePath},  'POST', 'Json', function(json){
            if(typeof (callback) == 'function'){
                callback(json);
            }
        });
    }

    $('.img-delete').off('click').on('click', function(){
        var dom = $(this);
        var filePath = dom.attr('file-path');
        deleteFile(filePath, function(json){
            if(json.code > 0){
                dom.closest('div').remove();
            }else{
                BUI.Message.Alert('删除失败！');
            }
        });
    });



</script>

</div>
</body>
</html>