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
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group ">
                <label class="control-label">评论ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $comment['id'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">评论父ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $comment['pid'] ?></span>
                </div>
            </div>
<!--            <div class="control-group  avatar_content" >-->
<!--                <label class="control-label">评论图片：</label>-->
<!--                <div class="controls">-->
<!--                    <img class="avatar_img" src="--><?php //echo $comment['pics'] ?><!--">-->
<!--                </div>-->
<!--            </div>-->
            <div class="control-group span20 avatar_content">
                <label class="control-label">截图：</label>
                <? foreach ($comment['pics'] as $f): ?>
                    <li class="controls">
                        <a href="<?php echo $f ?>" target="_blank"><img class="avatar_img" src="<?php echo $f ?>"></a>
                    </li>
                <? endforeach ?>
            </div>
            <div class="control-group ">
                <label class="control-label">评论内容：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $comment['content'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">评论时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $comment['create_at']?></span>
                </div>
            </div>
        </div>
    </form>
</div>