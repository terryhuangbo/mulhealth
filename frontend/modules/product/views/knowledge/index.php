<section class="center">
    <div class="productItem">
        <div class="filter">
            <ul>
                <li>
                    <a><p>时间筛选<img src="/images/arrowDown.png"/></p></a>
                    <div id="time">
                        <ul>
                            <li>时间段1</li>
                            <li>时间段2</li>
                            <li>时间段3</li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a><p>标签筛选<img src="/images/arrowDown.png"/></p></a>
                    <div id="items">
                        <ul>
                            <li>产品知识1</li>
                            <li>产品知识2</li>
                            <li>产品知识3</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="list">
            <div class="title">
                <p class="fl">产品知识1</p>
                <p class="fr">2016/12/12 12:00:00</p>
            </div>
            <div class="content">
                <img src="/images/cell.png"/>
                <p>这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试</p>
                <a href="">阅读>></a>
            </div>
        </div>
        <div class="list">
            <div class="title">
                <p class="fl">产品知识1</p>
                <p class="fr">2016/12/12 12:00:00</p>
            </div>
            <div class="content">
                <img src="/images/cell.png"/>
                <p>这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试</p>
                <a href="">阅读>></a>
            </div>
        </div>
        <div class="list">
            <div class="title">
                <p class="fl">产品知识1</p>
                <p class="fr">2016/12/12 12:00:00</p>
            </div>
            <div class="content">
                <img src="/images/cell.png"/>
                <p>这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试</p>
                <a href="">阅读>></a>
            </div>
        </div>
        <div class="list">
            <div class="title">
                <p class="fl">产品知识1</p>
                <p class="fr">2016/12/12 12:00:00</p>
            </div>
            <div class="content">
                <img src="/images/cell.png"/>
                <p>这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试这是一个申请的平台，给予我们现在无限的测试测试</p>
                <a href="">阅读>></a>
            </div>
        </div>
    </div>
</section>
<script>
    //    弹出筛选框
    $(".filter a").click(function () {
        $(this).next().toggle();
    });
    //选择筛选条件
    $("#time li,#items li").click(function () {
        $(this).parent().parent().hide();
    });
</script>