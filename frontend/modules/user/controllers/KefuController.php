<?php

namespace frontend\modules\user\controllers;

use Yii;
use app\base\BaseController;
use yii\helpers\VarDumper;


class KefuController extends BaseController
{
    public $layout = '//home';

    /**
     * 微信客服
     * @return type
     */
    public function actionIndex()
    {
        $options = yiiParams('wechatConfig');
        $auth = Yii::$app->wechat;

        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];

        VarDumper::dump($open_id);
        exit;

    }

}
