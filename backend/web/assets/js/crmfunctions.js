/**
 * Created by LuChuang on 2015/11/7.
 */
/**
 * 刷新列表
 */
function refreshCompanyGrid(){
//    var search = getCompanyGridSearchConditions();
    var search = {};
    var fields = $("#crmsearch").serializeArray();//获取表单信息
    jQuery.each( fields, function(i, field){
        if(field.value!="") {
            search[field.name] = field.value;
        }
    });
    var store = $("#companys_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}

/**
 * 搜索公司
 */
function searchCompanys(){
    refreshCompanyGrid();
}
/**
 * 获取过滤项
 */
function getCompanyGridSearchConditions(){

    var search = {};
    var upusername = $("#upusername").val();
    if(upusername != ""){
        search.upusername = upusername;
    }
    return search;
}
/**
 * 删除提示
 */
function checkDeleteCompanys(companyId){
    //如果不传，表示删除勾选
    var companyIds = [];
    if(companyId){
        companyIds.push(companyId);
    }
    else{
        companyIds = $("#companys_grid").data("BGrid").getSelectionValues();
    }
    if(companyIds.length == 0){
        return;
    }

    BUI.use('bui/overlay',function(Overlay){
        BUI.Message.Show({
            title:'删除提示',
            msg:'您确定要删除选中公司吗？',
            icon:'warning',
            buttons:[
                {
                    text:'确定',
                    elCls : 'button button-primary',
                    handler : function(){
                        deleteCompanys(companyIds);
                        this.close();
                    }
                },
                {
                    text:'取消',
                    elCls : 'button',
                    handler : function(){
                        this.close();
                    }
                }
            ]
        });
    });
}




/**
 * 删除公司
 */
function deleteCompanys(companyIds){
    $.ajax({
        type:"post",
        data:{ids:companyIds},
        url : DELACTIONURL,
        dataType:"json",
        success:function(json){
            if(json.result){
                var grid = $("#companys_grid").data("BGrid");
                grid.clearSelection();
                grid.get('store').load();//刷新
                BUI.Message.Alert('删除成功','success');
            }
            else{
                BUI.Message.Alert(json.message,'error');
            }
        }
    });
}



$(function(){
    // 三级行业分类
    BUI.Form.Group.Select.addType('type2',{
        data : CATEJASON
    });
    BUI.use('common/page');
    BUI.use('bui/form',function (Form) {
        var form = new Form.HForm({
            srcNode : '#crmsearch'
        });

        form.render();
    });
    BUI.use('bui/calendar',function(Calendar){
        var datepicker = new Calendar.DatePicker({
            trigger:'.calendar-time',
            showTime:true,
            autoRender : true
        });
    });
    //设置表格属性
    BUI.use(['bui/grid','bui/data'],function(Grid,Data){
        var Grid = Grid;
        var store = new Data.Store({
            url : BASELISTURL,
            proxy : {//设置请求相关的参数
                method : 'post',
                dataType : 'json', //返回数据的类型
                limitParam : 'pageSize', //一页多少条记录
                pageIndexParam : 'page' //页码
            },
            autoLoad:true, //自动加载数据
            params : { //配置初始请求的其他参数

            },
            root : 'companys',//数据返回字段,支持深成次属性root : 'data.records',
            totalProperty : 'totalCount',//总计字段
            pageSize:20// 配置分页数目,

        });
        var grid = new Grid.Grid({
            render:'#companys_grid',
            idField : 'id', //自定义选项 id 字段
            selectedEvent : 'click',
            columns : [
                {title : '企业编号',dataIndex : 'id',width:80},
                {
                    title : '企业名称',
                    dataIndex : 'name',
                    width:200,
                    renderer:function(v, obj){
                        return "<a class='btn1' href='javascript:void(0);' onclick='showCompanyBrief("+obj.id+")'>"+obj.name+"</a>";
                    }
                },
                {title : '创意云注册ID',dataIndex : 'username',width:100},
                {title : '企业电话',dataIndex : 'tel',width:100},
                {title : '录入人员',dataIndex : 'upusername',width:70},
                {
                    title : '录入时间',
                    dataIndex :'uptime',
                    width:130,
                    renderer:function(v){
                        return v ? BUI.Date.format(new Date(v * 1000), 'yyyy-mm-dd HH:MM:ss') : '';
                    }
                },
                {title : '评分',dataIndex :'score',width:350},
                {
                    title: '操作',
                    width: 400,
                    renderer: function (v, obj) {
                        if (ACTMARK == 'listmy') {
                            return "<a class='button button-info' title='企业信息' href='javascript:void(0);' onclick='showCompanyBrief("+obj.id+")'>详情</a>" +
                            " <a class='button button-primary page-action'  title='编辑企业信息' href='/crm/company/update/?id="+obj.id+"' data-href='/crm/company/update/?id="+obj.id+"'>编辑</a>"+
                                " <a class='button button-info' href='http://rc.vsochina.com/enterprise/default/index/" + obj.username + "'  target='_blank'>看空间</a>" +
                            " <a class='button button-danger' onclick='checkDeleteCompanys(" + obj.id + ")'>删除</a>"
                        }
                        else if (ACTMARK == 'listmark') {
                            return "<a class='button button-info' title='企业信息' href='javascript:void(0);' onclick='showCompanyBrief("+obj.id+")'>详情</a>" +
                                " <a class='button button-info' href='http://rc.vsochina.com/enterprise/default/index/" + obj.username + "'  target='_blank'>看空间</a>" +
                            " <a class='button button-success page-action' href='#' data-href='/crm/company/add-mark/?id="+obj.id+"'>评分</a>"
                        } else {
                            return "<a class='button button-info' title='企业信息' href='javascript:void(0);' onclick='showCompanyBrief("+obj.id+")'>详情</a>" +
                                " <a class='button button-info' href='http://rc.vsochina.com/enterprise/default/index/" + obj.username + "'  target='_blank'>看空间</a>" +
                            " <a class='button button-success page-action'  title='企业评分' href='#' data-href='/crm/company/add-mark/?id="+obj.id+"'>评分</a>"+
                            " <a class='button button-primary page-action'   title='编辑企业信息' href='/crm/company/update/?id="+obj.id+"' data-href='/crm/company/update/?id="+obj.id+"'>编辑</a>"+
                                " <a class='button button-danger' onclick='checkDeleteCompanys(" + obj.id + ")'>删除</a>"
                        }
                    }
                }

            ],
            loadMask: true, //加载数据时显示屏蔽层
            store: store,
            // 底部工具栏
            bbar:{
                // pagingBar:表明包含分页栏
                pagingBar:true
            },
            plugins : [ACTMARK == 'list'?Grid.Plugins.CheckSelection:''] // 插件形式引入多选表格
        });
        grid.render();
        $("#companys_grid").data("BGrid", grid);
    });

    //异步加载添加公司信息
    var Overlay = BUI.Overlay;
    var dialog = new Overlay.Dialog({
        title:'公司基本信息',
        width:600,
        height:700,
        buttons:[],
        loader : {
            url : "/crm/company/add-mark",
            autoLoad : false, //不自动加载
            lazyLoad : false //不延迟加载
        },
        mask:false
});
//    dialog.show();
var count = 0;
$('#addCompany').on('click',function () {
    dialog.show();
    dialog.get('loader').load({a : count});
    count++;
});

BUI.use(['bui/mask'],function(Mask){
    var fullMask = new Mask.LoadMask({
        el : 'body',
        msg : 'loading...'
    });
    $("body").data('BMask', fullMask);
});

//BUI.use('common/page');
});

/**
 * 显示公司详情，作品，其他信息
 */
function showCompanyBrief(id){
    // window.location.href = BRIEFURL+'?id='+id;
    // return;
    var width = jQuery(window).width()-500;
    var height = jQuery(window).height()-200;
    var Overlay = BUI.Overlay;
    var dialog = new Overlay.Dialog({
        title:'企业信息',
        width:width,
        height:height,
        closeAction:'destroy',
        loader : {
            url : "/crm/company/brief",
            autoLoad : true, //不自动加载
            params : {id : id},//附加的参数
            lazyLoad : false, //不延迟加载
        },
        success: function () {
            this.close();
        },
        mask:false
    });
    dialog.show();
    dialog.get('loader').load({id : id});
}