<section class="center">
    <div class="productIntro">
        <div class="list">
            <div class="title">
                <img src="/images/intro1.png"/>
                <p>产品项目</p>
                <a href="/product/project/items">更多>></a>
            </div>
            <?php if (!empty($data['project'])) : ?>
                <div class="content">
                    <a href="/product/project/detail?id=<?php echo $data['project']['id'] ?>"><p><?php echo $data['project']['title'] ?></p></a>
                    <?php foreach ($data['project']['pic'] as $v): ?>
                    <a href="/product/project/detail?id=<?php echo $data['project']['id'] ?>"><img src="<?php echo $v ?>" alt="<?php echo $data['project']['title'] ?>"></a>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <div class="list">
            <div class="title">
                <img src="/images/intro2.png"/>
                <p>产品知识</p>
                <a href="/product/knowledge/items">更多>></a>
            </div>
            <?php if (!empty($data['knowledge'])) : ?>
                <div class="content">
                    <a href="/product/knowledge/detail?id=<?php echo $data['knowledge']['id'] ?>"><p><?php echo $data['knowledge']['title'] ?></p></a>
                    <?php foreach ($data['knowledge']['pic'] as $v): ?>
                        <a href="/product/knowledge/detail?id=<?php echo $data['knowledge']['id'] ?>"><img src="<?php echo $v ?>" alt="<?php echo $data['knowledge']['title'] ?>"></a>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <div class="list">
            <div class="title">
                <img src="/images/intro3.png"/>
                <p>经典案例</p>
                <a href="/product/case/items">更多>></a>
            </div>
            <?php if (!empty($data['cases'])) : ?>
                <div class="content">
                    <a href="/product/case/detail?id=<?php echo $data['cases']['id'] ?>"><p><?php echo $data['cases']['title'] ?></p></a>
                    <?php foreach ($data['cases']['pic'] as $v): ?>
                        <a href="/product/case/detail?id=<?php echo $data['cases']['id'] ?>"><img src="<?php echo $v ?>" alt="<?php echo $data['cases']['title'] ?>"></a>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>
