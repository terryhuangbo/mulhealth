<section class="center">
    <div class="productIntro">
        <div class="list">
            <div class="title">
                <img src="/images/intro1.png"/>
                <p>产品项目</p>
                <a href="/product/project/items">更多>></a>
            </div>
            <? foreach ($data['project'] as $key => $val): ?>
                <div class="content">
                    <p><?php echo $val['title'] ?></p>
                    <? foreach ($val['pic'] as $v): ?>
                        <img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>">
                    <? endforeach ?>
                </div>
            <? endforeach ?>
        </div>
        <div class="list">
            <div class="title">
                <img src="/images/intro2.png"/>
                <p>产品知识</p>
                <a href="/product/knowledge/items">更多>></a>
            </div>
            <? foreach ($data['knowledge'] as $key => $val): ?>
                <div class="content">
                    <p><?php echo $val['title'] ?></p>
                    <? foreach ($val['pic'] as $v): ?>
                        <img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>">
                    <? endforeach ?>
                </div>
            <? endforeach ?>
        </div>
        <div class="list">
            <div class="title">
                <img src="/images/intro3.png"/>
                <p>经典案例</p>
                <a href="/product/case/items">更多>></a>
            </div>
            <? foreach ($data['cases'] as $key => $val): ?>
                <div class="content">
                    <p><?php echo $val['title'] ?></p>
                    <? foreach ($val['pic'] as $v): ?>
                        <img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>">
                    <? endforeach ?>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>
