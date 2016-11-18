<section class="center">
    <div class="changePwd">
        <h2>修改密码</h2>
        <table>
            <tr>
                <td>原始密码</td>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td>新密码</td>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td>确认新密码</td>
                <td><input type="password"></td>
            </tr>
        </table>
        <button class="commit">修改</button>
    </div>
    <div class="modal">
        <div class="content">
            <a class="closeModal"><img src="../images/close.png"/> </a>
            <p>您的密码修改成功！</p>
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