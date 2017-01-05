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
                <label class="control-label">客服ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $wechat['id'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">客服父ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $wechat['pid'] ?></span>
                </div>
            </div>
<!--            <div class="control-group  avatar_content" >-->
<!--                <label class="control-label">客服图片：</label>-->
<!--                <div class="controls">-->
<!--                    <img class="avatar_img" src="--><?php //echo $wechat['pics'] ?><!--">-->
<!--                </div>-->
<!--            </div>-->
            <div class="control-group span20 avatar_content">
                <label class="control-label">截图：</label>
                <? foreach ($wechat['pics'] as $f): ?>
                    <li class="controls">
                        <a href="<?php echo $f ?>" target="_blank"><img class="avatar_img" src="<?php echo $f ?>"></a>
                    </li>
                <? endforeach ?>
            </div>
            <div class="control-group ">
                <label class="control-label">客服内容：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $wechat['content'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">客服时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $wechat['create_at']?></span>
                </div>
            </div>
        </div>
    </form>
</div>