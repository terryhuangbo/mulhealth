<section class="center">
    <div class="writeReport">
        <div class="title">上传体检报告</div>
        <div class="content">
            <table>
                <tr>
                    <td>体检时间：</td>
                    <td><input /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>体重：</td>
                    <td><input></td>
                    <td>kg</td>
                </tr>
                <tr>
                    <td>身高:</td>
                    <td><input></td>
                    <td>cm</td>
                </tr>
                <tr>
                    <td>收缩压:</td>
                    <td><input></td>
                    <td>mnHg</td>
                </tr>
                <tr>
                    <td>舒张压:</td>
                    <td><input></td>
                    <td>mnHg</td>
                </tr>
                <tr>
                    <td>心率:</td>
                    <td><input></td>
                    <td>次/分</td>
                </tr>
                <tr>
                    <td>体重指数:</td>
                    <td><input></td>
                    <td>次/分</td>
                </tr>
                <tr>
                    <td>视力:</td>
                    <td><input></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <button class="commit">提交</button>
        </div>
    </div>
    <div class="modal">
        <div class="content">
            <a class="closeModal"><img src="/images/close.png"/> </a>
            <p>您的体检报告提交成功！</p>
            <button class="ok">确定</button>
        </div>
    </div>
</section>
<script>
    $(".commit").click(function () {
        $(".modal").show();
    });
    $(".close,.ok").click(function () {
        $(".modal").hide();
    });
</script>