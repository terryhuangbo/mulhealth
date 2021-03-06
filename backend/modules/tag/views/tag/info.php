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
                <label class="control-label">标签ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['id'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">标签标题：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['title'] ?></span>
                </div>
            </div>
            <div class="control-group  avatar_content" >
                <label class="control-label">标签图片：</label>
                <div class="controls">
                    <img class="avatar_img" src="<?php echo $tag['pic'] ?>">
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">详情：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['detail'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">标签：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['tags'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">创建时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['create_at']?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">更新登录：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $tag['update_at'] ?></span>
                </div>
            </div>
        </div>
    </form>
</div>