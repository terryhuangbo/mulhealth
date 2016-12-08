<?php
use yii\helpers\Html;
use common\models\Cases;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>细胞列表</title>
    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/page-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <style>
        .user_avatar {
            width: 120px;
            height: 80px;
            margin: 10px auto;
        }
    </style>
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('cell/cell/list') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="authsearch" class="form-horizontal">

                <div class="row">
                    <div class="control-group span12">
                        <label class="control-label">细胞名称：</label>
                        <div class="controls" data-type="city">
                            <input type="text" class="control-text" name="name" id="name">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">细胞状态：</label>
                        <div class="controls" >
                            <select name="status" id="status">
                                <option value="">请选择</option>
                                <?php foreach (Cases::getStatuses() as $key => $name): ?>
                                    <option value="<?= $key ?>"><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="control-group span14">
                        <label class="control-label">发布时间：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="control-group span10">
                            <button type="button" id="btnSearch" class="button button-primary"  onclick="searchCases()">查询</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="bui-grid-tbar">
        </div>
        <div id="cell_grid">
        </div>
    </div>
</div>

<div id="reason_content" style="display: none" >
    <form id="reason_form" class="form-horizontal">
        <div class="control-group" >
            <div class="control-group" style="height: 80px">
                <label class="control-label"></label>
                <div class="controls ">
                    <textarea class="input-large" id="reason_text" style="height: 60px" data-rules="{required : true}" type="text"></textarea>
                </div>
            </div>
            <div class="control-group style="">
            <label class="control-label"></label>
            <div class="controls">
                <span><b>提示：</b>输入字数不能超过12个字</span>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#authsearch'
            });
            form.render();
        });
        BUI.use('bui/calendar', function (Calendar) {
            var datepicker = new Calendar.DatePicker({
                trigger: '.calendar-time',
                showTime: true,
                autoRender: true
            });
        });
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: _BASE_LIST_URL,
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page' //页码
                },
                autoLoad: true, //自动加载数据
                params: {
                },
                root: 'cellList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#cell_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '序号', dataIndex: 'id', width: 80, elCls : 'center'},
                    {title: '用户姓名', dataIndex: 'user_name', width: 80, elCls : 'center'},
                    {
                        title: '图片',
                        width: 140,
                        elCls : 'center',
                        renderer: function (v, obj) {
                            return "<img class='user_avatar' src='"+ obj.pics +"'>";
                        }
                    },
                    {title: '描述', dataIndex: 'description', width: 80, elCls : 'center'},
                    {title: '细胞状态', dataIndex: 'status_name', width: 80, elCls : 'center'},
                    {title: '创建时间', dataIndex: 'create_time', width: 150, elCls : 'center'},
                    {title: '更新时间', dataIndex: 'update_time', width: 150, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            if(obj.status == 1){
                                return "<a class='button button-info' onclick='showInfo(" + obj.id + ")'>查看</a>" +
                                    "<a class='button button-success page-action' title='编辑细胞' href='/cell/cell/update/?id="+ obj.id +"' data-href='/cell/cell/update/?id="+ obj.id +"' >编辑</a>" +
                                    " <a class='button button-danger' onclick='offShelf(" + obj.id + ")'>禁用</a>";
                            }else if(obj.status == 2){
                                return "<a class='button button-info' onclick='showInfo(" + obj.id + ")'>查看</a>" +
                                    "<a class='button button-success page-action' title='编辑细胞信息' data-href='/cell/cell/update/?id="+ obj.id +"' >编辑</a>" +
                                    " <a class='button button-primary' onclick='upShelf(" + obj.id + ")'>启用</a>";
                            }
                        }
                    }
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    // pagingBar:表明包含分页栏
                    pagingBar: true
                },
                plugins: Grid.Plugins.CheckSelection,// 插件形式引入多选表格
            });
            grid.render();
            $("#cell_grid").data("BGrid", grid);

        });

    });
</script>

<script>
    /**
     * 搜索细胞,刷新列表
     */
    function searchCases() {
        var search = {};
        var fields = $("#authsearch").serializeArray();//获取表单信息
        jQuery.each(fields, function (i, field) {
            if (field.value != "") {
                search[field.name] = field.value;
            }
        });
        var store = $("#cell_grid").data("BGrid").get('store');
        var lastParams = store.get("lastParams");
        lastParams.search = search;
        store.load(lastParams);//刷新
    }
    /**
     * 获取过滤项
     */
    function getCasesGridSearchConditions() {
        var search = {};
        var upusername = $("#upusername").val();
        if (upusername != "") {
            search.upusername = upusername;
        }
        var username = $("#username").val();
        if (username != "") {
            search.username = username;
        }
        return search;
    }

    /**
     * 显示细胞详情
     */
    function showInfo(id) {
        var width = 500;
        var height = 450;
        var Overlay = BUI.Overlay;
        var buttons = [
            {
                text:'确认',
                elCls : 'button button-primary',
                handler : function(){
                    window.location.href = '/cell/cell/list';
                    this.close();
                }
            },
        ];
        dialog = new Overlay.Dialog({
            title: '细胞信息',
            width: width,
            height: height,
            closeAction: 'destroy',
            loader: {
                url: "/cell/cell/info",
                autoLoad: true, //不自动加载
                params: {id: id},//附加的参数
                lazyLoad: false //不延迟加载
            },
            buttons: buttons,
            mask: false
        });
        dialog.show();
        dialog.get('loader').load({id: id});
    }


    /**
     * 上架
     */
    function upShelf(id) {
        ajax_change_status(id, 1, function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '/cell/cell/list';
                }, 'success');
            }else{
                BUI.Message.Alert(json.msg, 'error');
            }
        });
    }

    /**
     * 下架
     */
    function offShelf(id) {
        ajax_change_status(id, 2, function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '/cell/cell/list';
                }, 'success');
            }else{
                BUI.Message.Alert(json.msg, 'error');
            }
        });
    }

    /**
     *删除
     */
    function del(id) {
        BUI.Message.Confirm('您确定要删除？', function(){
            ajax_change_status(id, 3, function(json){
                if(json.code > 0){
                    BUI.Message.Alert(json.msg, function(){
                        window.location.href = '/cell/cell/list';
                    }, 'success');
                }else{
                    BUI.Message.Alert(json.msg, 'error');
                }
            });
        }, 'question');
    }

    /**
     *改变细胞状态
     */
    function ajax_change_status(id, status, callback){
        var param = param || {};
        param.id = id;
        param.cell_status = status;
        $._ajax('<?php echo yiiUrl('cell/cell/ajax-change-status') ?>', param, 'POST','JSON', function(json){
            if(typeof callback == 'function'){
                callback(json);
            }
        });

    }

</script>

</body>
</html>