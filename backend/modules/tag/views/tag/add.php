<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加标签</title>
    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <link href="/css/extra.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
</head>

<body>
<div class="demo-content">
    <form id="Goods_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加标签</h2>
        <div class="control-group">
            <label class="control-label"><s>*</s>标签名称：</label>
            <div class="controls">
                <input name="name" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">标签类型：</label>
            <div class="controls" >
                <select name="type" id="type" data-rules="{required : true}">
                    <option value="">请选择</option>
                    <?php foreach ($types as $key => $name): ?>
                        <option value="<?= $key ?>"><?= $name ?></option>
                    <?php endforeach ?>
                </select>
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
                    $._ajax('/tag/tag/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
                                window.location.href = '/tag/tag/list';
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
                window.location.href = '/tag/tag/list';
            });
        });
    </script>
    <!-- script end -->
</div>
</body>
</html>