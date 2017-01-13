<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加来访纪录</title>

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
    <form id="Customer_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加项目</h2>
        <div class="control-group">
            <label class="control-label">客户姓名：</label>
            <div class="controls">
                <input name="name" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系电话：</label>
            <div class="controls">
                <input name="mobile" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">客户来源：</label>
            <div class="controls">
                <input name="source" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">来访时间：</label>
            <div class="controls">
                <input name="call_at" type="text" class="calendar calendar-time"  data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">来访目的：</label>
            <div class="controls">
                <input name="purpose" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">客户评级：</label>
            <div class="controls">
                <input name="mark" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group" id="description_content">
            <label class="control-label">过程内容：</label>
            <div class="controls  control-row-auto">
                <textarea name="result" id="" class="control-row3 input-large" data-rules=""></textarea>
            </div>
        </div>

        <div class="control-group" id="description_content">
            <label class="control-label">备注：</label>
            <div class="controls  control-row-auto">
                <textarea name="note" id="" class="control-row3 input-large" data-rules=""></textarea>
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
                srcNode : '#Customer_Form'
            });
            form.render();
            //保存
            $("#save-case").on('click', function(){
                if(form.isValid()){
                    var param = $("#Customer_Form").serialize();
                    $._ajax('/customer/come/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
                                window.location.href = '/customer/come/list';
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
                window.location.href = '/customer/come/list';
            });
        });

        BUI.use('bui/calendar', function (Calendar) {
            var datepicker = new Calendar.DatePicker({
                trigger: '.calendar-time',
                showTime: true,
                autoRender: true
            });
        });
    </script>
    <!-- script end -->
</div>
</body>
</html>