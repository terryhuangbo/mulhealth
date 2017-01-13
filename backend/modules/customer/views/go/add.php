<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加项目</title>

    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <link href="/css/extra.css" rel="stylesheet">

    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/sea.js"></script>
    <script src="http://g.alicdn.com/bui/bui/1.1.21/config.js"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
</head>

<body>
<div class="demo-content">
    <form id="Goods_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加项目</h2>
        <div class="control-group">
            <label class="control-label"><s>*</s>项目名称：</label>
            <div class="controls">
                <input name="title" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><s>*</s>项目标签：</label>
            <div id="tags-content" style="text-indent: 10px; margin: auto auto 10px 0">
                <input name="tags" type="hidden" id="tags" value=""  data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><s>*</s>项目图片：</label>
            <div id="thumbpic" class="controls">
                <span class="button button-primary">上传图片</span>
            </div>
        </div>
        <div class="row" >
            <div class="span16 layout-outer-content">
                <div id="thumbpic-content" class="layout-content" aria-disabled="false" aria-pressed="false" >

                </div>
            </div>
        </div>

        <div class="control-group" id="description_content">
            <label class="control-label">项目详情：</label>
            <div class="controls  control-row-auto">
                <!--                <textarea name="detail" id="" class="control-row3 input-large" data-rules="{required : true}"></textarea>-->
                <script type="text/plain" id="editor_content" name="detail"></script>
            </div>
        </div>
        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="save-case">保存</button>
                <button type="reset" class="button" id="cancel-case">返回</button>
            </div>
        </div>
    </form>

    <!-- script start -->
    <script type="text/javascript">
        BUI.use('bui/form',function(Form){
            var form = new Form.Form({
                srcNode : '#Goods_Form'
            });
            form.render();
            //保存
            $("#save-case").on('click', function(){
                if(form.isValid()){
                    var param = $._get_form_json("#Goods_Form");
                    $._ajax('/product/project/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
                                window.location.href = '/product/project/list';
                            }, 'success');

                        }else{
                            BUI.Message.Alert(json.msg, 'error');
                            this.close();
                        }
                    });
                }
            });
            //返回
            $("#cancel-case").on('click', function(){
                window.location.href = '/product/project/list';
            });
        });

        //选择标签
        BUI.use('bui/select',function(Select){
            var items = <?php echo $tags; ?>,
                select1 = new Select.Combox({
                    render:'#tags-content',
                    showTag:true,
                    width : 340,
                    elCls : 'bui-tag-follow',
                    valueField : '#tags',//显示tag的Combox必须存在valueField
                    items: items
                });
            select1.render();
        });
    </script>
    <!-- script end -->

    <script>
        $(function () {
            var editor = UE.getEditor('editor_content', {
                "initialFrameWidth": "700",
                "initialFrameHeight": "360",
                "lang": "zh-cn"
            });
        });

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
                    objtype: 'project'
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

    </script>

</div>
</body>
</html>