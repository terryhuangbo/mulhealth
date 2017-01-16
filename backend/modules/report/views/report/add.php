<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加体检报告</title>

    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <link href="/css/extra.css" rel="stylesheet">

    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/sea.js"></script>
    <script src="http://g.alicdn.com/bui/bui/1.1.21/config.js"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
</head>

<body>
<div class="demo-content">
    <form id="Report_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加体检报告</h2>
        <div class="control-group">
            <label class="control-label">用户ID：</label>
            <div class="controls">
                <input name="uid" type="text" class="input-medium"  data-rules="{required : true}">
                <span>&nbsp;&nbsp;&nbsp;注：必须是注册用户的编号</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">体检时间：</label>
            <div class="controls">
                <input name="time" type="text" class="calendar calendar-time"  data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">地点：</label>
            <div class="controls">
                <input name="location" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">年龄：</label>
            <div class="controls">
                <input name="age" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">身高：</label>
            <div class="controls">
                <input name="height" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">体重：</label>
            <div class="controls">
                <input name="weight" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group" id="description_content">
            <label class="control-label">个人病史：</label>
            <div class="controls  control-row-auto">
                <textarea name="self_history" id="" class="control-row3 input-large" data-rules=""></textarea>
            </div>
        </div>

        <div class="control-group" id="description_content">
            <label class="control-label">家族病史：</label>
            <div class="controls  control-row-auto">
                <textarea name="family_history" id="" class="control-row3 input-large" data-rules=""></textarea>
            </div>
        </div>
        <hr>

        <h4>血常规</h4><br>
        <div class="control-group">
            <label class="control-label">WBC总数：</label>
            <div class="controls">
                <input name="blood[wbc]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">中性粒比例：</label>
            <div class="controls">
                <input name="blood[zxl]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">淋巴C比例：</label>
            <div class="controls">
                <input name="blood[lbc]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">RBC总数：</label>
            <div class="controls">
                <input name="blood[brc]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">RBC总数：</label>
            <div class="controls">
                <input name="blood[brc]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Hb含量：</label>
            <div class="controls">
                <input name="blood[hb]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">PLT 血小板数目：</label>
            <div class="controls">
                <input name="blood[plt]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">HCT 红细胞压积：</label>
            <div class="controls">
                <input name="blood[hct]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>尿常规</h4><br>
        <div class="control-group">
            <label class="control-label">尿WBC：</label>
            <div class="controls">
                <input name="urine[wbc]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">尿蛋白：</label>
            <div class="controls">
                <input name="urine[ldb]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">尿红细胞：</label>
            <div class="controls">
                <input name="urine[hxb]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>电解质</h4><hr>
        <div class="control-group">
            <label class="control-label">钾K+：</label>
            <div class="controls">
                <input name="elec[k]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">钠Na-：</label>
            <div class="controls">
                <input name="elec[na]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">氯Cl-：</label>
            <div class="controls">
                <input name="elec[cl]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">钙Ca2-：</label>
            <div class="controls">
                <input name="elec[ca]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>肝功能</h4><hr>
        <div class="control-group">
            <label class="control-label">总胆红素：</label>
            <div class="controls">
                <input name="liver[dhs]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">间接胆红素：</label>
            <div class="controls">
                <input name="liver[jdhs]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">直接胆红素：</label>
            <div class="controls">
                <input name="liver[zdhs]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">ALT 谷丙转氨酶：</label>
            <div class="controls">
                <input name="liver[alt]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">AST 谷草转氨酶：</label>
            <div class="controls">
                <input name="liver[ast]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>肾功能</h4><hr>
        <div class="control-group">
            <label class="control-label">BUN 血尿素氮：</label>
            <div class="controls">
                <input name="kidney[bun]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">CRE 肌酐：</label>
            <div class="controls">
                <input name="kidney[cre]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">URIC 尿素肌酐比：</label>
            <div class="controls">
                <input name="kidney[uric]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>肿瘤指标</h4><hr>
        <div class="control-group">
            <label class="control-label">AFP 甲胎蛋白：</label>
            <div class="controls">
                <input name="cancer[afp]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">CEA 癌胚抗原：</label>
            <div class="controls">
                <input name="cancer[cea]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>免疫四项</h4><hr>
        <div class="control-group">
            <label class="control-label">乙肝：</label>
            <div class="controls">
                <input name="immune[yg]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">丙肝：</label>
            <div class="controls">
                <input name="immune[bg]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">梅毒抗体：</label>
            <div class="controls">
                <input name="immune[md]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">HIV抗体：</label>
            <div class="controls">
                <input name="immune[hiv]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <h4>凝血五项</h4><br>
        <div class="control-group">
            <label class="control-label">PT 凝血酶原时间</label>
            <div class="controls">
                <input name="fivbl[pt]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">PT% 活动度：</label>
            <div class="controls">
                <input name="fivbl[ptp]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">FIB纤维蛋白原：</label>
            <div class="controls">
                <input name="fivbl[fib]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">APTT部分凝血酶原时间：</label>
            <div class="controls">
                <input name="fivbl[aptt]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">TT凝血酶时间：</label>
            <div class="controls">
                <input name="fivbl[tt]" type="text" class="input-medium" data-rules="">
            </div>
        </div>
        <hr>

        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="save-case">保存</button>
                <button type="reset" class="button" id="cancel-case">返回</button>
            </div>
        </div>
    </form>

    <!-- script start -->
    <script type="text/javascript">
        BUI.use('bui/form',function(Form){
            var form = new Form.Form({
                srcNode : '#Report_Form'
            });
            form.render();
            //保存
            $("#save-case").on('click', function(){
                if(form.isValid()){
                    var param = $("#Report_Form").serialize();
                    $._ajax('/report/report/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
//                                window.location.href = '/report/report/list';
                            }, 'success');

                        }else{
                            BUI.Message.Alert(json.msg, 'error');
                            this.close();
                        }
                    });
                }
            });
            //返回
            $("#cancel-case").on('click', function(){
                window.location.href = '/report/report/list';
            });
        });

        BUI.use('bui/calendar', function (Calendar) {
            var datepicker = new Calendar.DatePicker({
                trigger: '.calendar-time',
                showTime: true,
                autoRender: true
            });
        });
    </script>
    <!-- script end -->

    <script>


    </script>

</div>
</body>
</html>