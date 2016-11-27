<?php

namespace frontend\modules\my\controllers;

use common\behavior\PointBehavior;
use common\lib\Tools;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class ProfileController extends BaseController
{

    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $_data = [];
        return $this->render('index', $_data);
    }

    /**
     * 完善用户信息
     * @return type
     */
    public function actionPerfect()
    {
        if ($this->isGet())
        {
            $_data = [
                'user' => Yii::$app->user->identity->toArray()
            ];
            return $this->render('perfect', $_data);
        }
        $user = Yii::$app->user->identity;
        $ret = $user->perfect($this->req());
        if ($ret['code'] < 0)
        {
            return $this->toJson($ret);
        }
        return $this->refresh();
    }





}
