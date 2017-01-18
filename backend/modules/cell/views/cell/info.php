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
                <label class="control-label">细胞ID：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $cell['id'] ?></span>
                </div>
            </div>
            <div class="control-group span20 avatar_content">
                <label class="control-label">细胞图片：</label>
                <? foreach ($cell['pics'] as $f): ?>
                    <li class="controls">
                        <a href="<?php echo $f ?>" target="_blank"><img class="avatar_img" src="<?php echo $f ?>"></a>
                    </li>
                <? endforeach ?>
            </div>
            <div class="control-group ">
                <label class="control-label">详情：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $cell['description'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">状态：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $cell['status']?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">创建时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $cell['report_at']?></span>
                </div>
            </div>
        </div>
    </form>
</div>