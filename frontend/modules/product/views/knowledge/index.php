<section class="center">
    <div class="productItem">
        <div class="filter">
            <ul>
                <li>
                    <select data-placeholder="时间筛选" id="time-filter" from="0" to="0" style="" class="dept_select">
                        <option value="0##0">时间筛选<img src="/images/arrowDown.png"/></option>
                        <? foreach ($timeFilters as $k => $t): ?>
                            <option value="<?php echo $t['from'] . '##' . $t['to'] ?>"><?php echo $t['text'] ?></option>
                        <? endforeach ?>
                    </select>
                    <img src="/images/arrowDown.png"/>
                </li>
                <li>
                    <select data-placeholder="标签筛选" id="tag-filter" tag="0" style="" class="dept_select">
                        <option value="0">标签筛选</option>
                        <? foreach ($tagList as $t): ?>
                            <option value="<?php echo $t ?>"><?php echo $t ?></option>
                        <? endforeach ?>
                        <option value="0">不限</option>
                    </select>
                    <img src="/images/arrowDown.png"/>
                </li>
            </ul>
        </div>
        <div id="content">
            <?php foreach($knowledgeList as $knowledge): ?>
                <div class="list">
                    <div class="title">
                        <p class="fl"><?php echo $knowledge['title'] ?></p>
                        <p class="fr"><?php echo $knowledge['create_at'] ?></p>
                    </div>
                    <div class="content">
                        <img src="<?php echo $knowledge['pic'] ?>"/>
                        <p><?php echo $knowledge['detail'] ?></p>
                        <a href="/product/knowledge/detail?id=<?php echo $knowledge['id'] ?>">阅读>></a>
                    </div>
                </div>
            <?php endforeach ?>
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
    $("#time-filter ").on('click', function () {
        var el = $(this);
        var val = el.val().split('##');
        var from = val[0];
        var to = val[1];
        $("#time-filter").attr('from', from);
        $("#time-filter").attr('to', to);
        getItems();
    });
    $("#tag-filter").on('click', function () {
        var el = $(this);
        var tags = el.val();
        $("#tag-filter").attr('tag', tags);
        getItems();
    });
    var getItems = function () {
        var param = {
            'from' : $("#time-filter").attr('from'),
            'to' : $("#time-filter").attr('to'),
            'tags' : $("#tag-filter").attr('tag')
        };
        $._ajax('/product/knowledge/items', param, 'POST', 'JSON', function (json) {
            if(json.code > 0){
                var items = json.data.knowledgeList;
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
                        '        <a href="/product/knowledge/detail?id='+ v.id +'">阅读>></a>'+
                        '    </div>'+
                        '</div>';
                });
                $("#content").html(html);
            }
        });
    }
</script>