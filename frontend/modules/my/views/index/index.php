<section class="center">
    <div class="my">
        <div class="head">
            <div class="tx">
                <div class="img">
                    <img class="txImg" src="<?php echo \Yii::$app->user->identity->avatar ?>"/>
                    <img class="sex" src="/images/sex.png"/>
                </div>
                <div class="text">
                    <p><?php echo \Yii::$app->user->identity->nick ?></p>
                    <p><?php echo \Yii::$app->user->identity->age ?>岁</p>
                </div>
            </div>
        </div>
        <div class="menu">
            <table>
                <tr>
                    <td><img src="/images/inco1.png"/> </td>
                    <td style="color:#fdb505;">我的信息</td>
                    <td><a href="/my/profile/perfect"> > </a>  </td>
                </tr>
                <tr>
                    <td><img src="/images/inco2.png"/> </td>
                    <td style="color:#5bc3c3;">我的体检报告</td>
                    <td><a href="/my/report/index">></a>  </td>
                </tr>
                <tr>
                    <td><img src="/images/inco3.png"/> </td>
                    <td style="color:#0282c2;">我的细胞培养</td>
                    <td><a href="/my/cell/index"> > </a></td>
                </tr>
                <tr>
                    <td><img src="/images/inco4.png"/> </td>
                    <td style="color:#f88cbd;">修改登录密码</td>
                    <td><a href="/my/index/alter-pwd"> > </a></td>
                </tr>
            </table>
        </div>
    </div>
</section>
