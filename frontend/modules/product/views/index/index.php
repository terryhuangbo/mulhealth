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
                    <a href="/product/project/detail?id=<?php echo $val['id'] ?>">
                        <p><?php echo $val['title'] ?></p>
                    </a>
                    <? foreach ($val['pic'] as $v): ?>
                        <a href="/product/project/detail?id=<?php echo $val['id'] ?>"><img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>"></a>
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
                    <a href="/product/knowledge/detail?id=<?php echo $val['id'] ?>">
                        <p><?php echo $val['title'] ?></p>
                    </a>
                    <? foreach ($val['pic'] as $v): ?>
                        <a href="/product/knowledge/detail?id=<?php echo $val['id'] ?>">
                            <img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>">
                        </a>
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
                    <a href="/product/case/detail?id=<?php echo $val['id'] ?>">
                        <p><?php echo $val['title'] ?></p>
                    </a>
                    <? foreach ($val['pic'] as $v): ?>
                        <a href="/product/case/detail?id=<?php echo $val['id'] ?>">
                            <img src="<?php echo $v ?>" alt="<?php echo $val['title'] ?>">
                        </a>
                    <? endforeach ?>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>
