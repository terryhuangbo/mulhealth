<?php

namespace frontend\modules\my\controllers;

use common\behavior\PointBehavior;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class ReportController extends BaseController
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
    public function actionUpload()
    {
        $_data = [];
        return $this->render('upload', $_data);
    }

    /**
     * 首页-未登录
     * @return type
     */
    public function actionAdd()
    {
        $_data = [];
        return $this->render('add', $_data);
    }



}
