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
                            <li>产品项目1</li>
                            <li>产品项目2</li>
                            <li>产品项目3</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div id="content">
            <? foreach ($projectList as $project): ?>
                <div class="list">
                    <div class="title">
                        <p class="fl"><?php echo $project['title'] ?></p>
                        <p class="fr"><?php echo $project['create_at'] ?></p>
                    </div>
                    <div class="content">
                        <img src="<?php echo $project['pic'] ?>"/>
                        <p><?php echo $project['detail'] ?></p>
                        <a href="">阅读>></a>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>
<script>
    //弹出筛选框
    $(".filter a").click(function () {
        $(this).next().toggle();
    });
    //选择筛选条件
    $("#time li,#items li").click(function () {
        $(this).parent().parent().hide();
    });
</script>
<script>
    $("#time li").on('click', function () {
        var el = $(this);
        var period = el.text();
        var param = {'period': period};
        getItems(param);
    });
    $("#items li").on('click', function () {
        var el = $(this);
        var tags = el.text();
        var param = {'tags': tags};
        getItems(param);
    });
    var getItems = function (param) {
        $._ajax('/product/project/items', param, 'POST', 'JSON', function (json) {
            if(json.code > 0){
                var items = json.data.projectList;
                var html = '';
                $.each(items, function (i, v) {
                    html +=
                        '<div class="list"> '+
                        '    <div class="title">'+
                        '        <p class="fl">'+ v.title +'</p>'+
                        '        <p class="fr">'+ v.create_at +'</p>'+
                        '    </div>'+
                        '    <div class="content">'+
                        '        <img src="'+ v.pic +'"/>'+
                        '        <p>'+ v.detail +'</p>'+
                        '        <a href="">阅读>></a>'+
                        '    </div>'+
                        '</div>';
                });
                $("#content").html(html);
            }
        });
    }
</script>