<style>
    .avatar_content{
        margin-left: -1px;
        margin-bottom: 80px;
    }
    .avatar_content li{
        float: left;
    }
    .avatar_img{
        height: 100px;
        width: 120px;
        display: block;
    }
    .bui-stdmod-body{
        overflow-x : hidden;
        overflow-y : auto;
    }

</style>
<div id="reason_content" style="display: none" >
    <form id="reason_form" class="form-horizontal" onsubmit="return false;">
        <div class="control-group" >
            <input type="hidden" name="id" value="<?php echo $msg['id'] ?>">
            <div class="control-group" style="height: 80px">
                <label class="control-label"></label>
                <div class="controls ">
                    <textarea class="input-large" name="content" id="reason_text" style="height: 60px" data-rules="{required : true}" type="text"></textarea>
                </div>
            </div>
            <div class="control-group style="">
            <label class="control-label"></label>
            <div class="controls">
                <span><b>提示：</b>输入字数不能超过100个字</span>
            </div>
        </div>
        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="reply-msg">保存</button>
                <button type="reset" class="button">重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    $("#reply-msg").on('click', function () {
        var content = $.trim($("#reason_text").val());
        if(content == ''){
            BUI.Message.Alert('请输入回复内容', 'error');
            return false;
        }
        $._ajax('/wechat/msg/reply', $("#reason_form").serialize() , 'POST', 'JSON', function (json) {
            if (json.code > 0) {
                BUI.Message.Alert('回复成功！', 'success');
                window.location.reload();
            }else{
                BUI.Message.Alert(json.msg, 'error');
            }
        });
    });

</script>