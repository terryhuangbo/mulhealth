<section class="center">
    <div class="writeReport">
        <div class="title">上传体检报告</div>
        <div class="content">
            <form id="reportContent" onsubmit="return false;">
                <input type="hidden" name="pic" value="<?php echo $pic ?>">
                <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken ?>">
                <table>
                    <tr>
                        <td>体检时间：</td>
                        <td><input type="text" id="time1"  name="time"></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>体重：</td>
                        <td><input type="text" id="weight"  name="weight"></td>
                        <td>kg</td>
                    </tr>
                    <tr>
                        <td>身高:</td>
                        <td><input type="text" id="height"  name="height"></td>
                        <td>cm</td>
                    </tr>
                    <tr>
                        <td>收缩压:</td>
                        <td><input type="text" id="systolic"  name="systolic"></td>
                        <td>mnHg</td>
                    </tr>
                    <tr>
                        <td>舒张压:</td>
                        <td><input type="text" id="diastolic"  name="diastolic"></td>
                        <td>mnHg</td>
                    </tr>
                    <tr>
                        <td>心率:</td>
                        <td><input type="text" id="heartrate"  name="heartrate"></td>
                        <td>次/分</td>
                    </tr>
                    <tr>
                        <td>体重指数:</td>
                        <td><input type="text" id="bmi"  name="bmi"></td>
                        <td>次/分</td>
                    </tr>
                    <tr>
                        <td>视力:</td>
                        <td><input type="text" id="vision"  name="vision"></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <button type="submit" class="commit">提交</button>
            </form>
        </div>
    </div>
    <div class="modal">
        <div class="content">
            <a class="closeModal"><img src="/images/close.png"/> </a>
            <p id="alert-message">您的体检报告提交成功！</p>
            <button class="ok">确定</button>
        </div>
    </div>
</section>
<script>
    $(".commit").click(function () {
//        $(".modal").show();
    });
    $(".close,.ok").click(function () {
        $(".modal").hide();
    });
</script>
<script>
    $().ready(function(){
        $("#reportContent").validate({
            rules: {
//                time: {
//                    required: true,
//                },

            },
            messages: {
//                time: {
//                    required: "请输入体检时间"
//                },

            },
            errorPlacement: function(error, el) {
                $(el).after(error);
            },
            errorElement: "em",
            errorClass: "msg-error",
            submitHandler: function(form) {
                $._ajax('/my/report/add', $(form).serialize(), 'POST', 'JSON', function(json){
                    if(json.code > 0) {
                        $(".modal").show();
                    }else{
                        $("#alert-message").text(json.msg);
                        $(".modal").show();
                    }
                });
            }
        });
    });

</script>