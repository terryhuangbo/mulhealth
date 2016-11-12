<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
        margin-right: 160px;
    }
    .avatar_img{
        height: 100px;
        width: 120px;
        margin: 10px 40px;
    }
    .pic-content{
        margin-bottom: 15px;
    }


</style>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">

        <div class="row">

            <div class="control-group span8">
                <label class="control-label">手机号码：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['mobile']?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">积分：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['points'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户状态：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['user_status'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">注册时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['create_at'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">更新时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['update_at'] ?></span>
                </div>
            </div>
        </div>

    </form>
</div>