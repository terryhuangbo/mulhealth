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
                <label class="control-label">用户账号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['username'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">昵称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['nick'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">真实姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['name'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">性别：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['sex'] ?></span>
                </div>
            </div>
            <div class="control-group  avatar_content" >
                <label class="control-label">头像：</label>
                <div class="controls">
                    <img class="avatar_img" src="<?php echo $user['avatar'] ?>">
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">手机号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['mobile'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">地址：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['address'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">注册时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['create_time']?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">最近登录：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['login_time'] ?></span>
                </div>
            </div>
        </div>
    </form>
</div>