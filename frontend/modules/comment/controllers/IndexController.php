<?php

namespace frontend\modules\comment\controllers;

use common\behavior\PointBehavior;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class IndexController extends BaseController
{

    public $enableCsrfValidation = false;

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
     * 首页-未登录
     * @return type
     */
    public function actionRelease()
    {
        $_data = [];
        return $this->render('release', $_data);
    }




}
