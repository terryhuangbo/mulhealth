<section class="center">
    <div class="myReport">
        <div class="title">
            <ul>
                <li><a class="active">细胞培养</a></li>
                <li><a href="/my/report/index">体检报告</a></li>
            </ul>
        </div>
        <div class="content">
            <? foreach ($cellList as $k => $cell): ?>
                <div class="list list<?php echo $k+1 ?>">
                    <div class="left"><p><?php echo $cell['report_at'] ?></p></div>
                    <div class="right">
                        <p><?php echo $cell['description'] ?></p>
                        <?php foreach ($cell['pics'] as $pic): ?>
                            <img src="<?php echo $pic ?>"/>
                        <?php endforeach ?>
                    </div>
                </div>
            <? endforeach ?>
            <a href="/my/cell/detail">查看更多 >>> </a>
        </div>
    </div>
</section>
