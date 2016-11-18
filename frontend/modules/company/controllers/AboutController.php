<?php

namespace frontend\modules\company\controllers;

use common\behavior\PointBehavior;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class AboutController extends BaseController
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
     * 首页-登录
     * @return type
     */
    public function actionIntroduce()
    {
        $_data = [];
        return $this->render('introduce', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionTeam()
    {
        $_data = [];
        return $this->render('team', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionPatent()
    {
        $_data = [];
        return $this->render('patent', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionHonor()
    {
        $_data = [];
        return $this->render('honor', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionGuest()
    {
        $_data = [];
        return $this->render('guest', $_data);
    }











}
