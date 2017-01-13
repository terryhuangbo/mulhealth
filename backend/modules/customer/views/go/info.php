<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
    }
    .avatar_img{
        height: 100px;
        width: 120px;
        position: relative;
        top: -21px;
        left: 118px;
        display: block;

    }
    .bui-stdmod-body{
        overflow-x : hidden;
        overflow-y : auto;
    }

</style>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group ">
                <label class="control-label">编号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['id'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">客户姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['name'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">拜访时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo date('Y-m-d H:i:s', $customer['call_at']) ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">拜访目的：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['purpose'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">下次拜访目标：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['next_plan'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">拜访目的：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['purpose'] ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">过程内容：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['result']?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">备注：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['result']?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">录入时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $customer['create_at'] ?></span>
                </div>
            </div>
        </div>
    </form>
</div>