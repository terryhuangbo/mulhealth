<?php

namespace frontend\modules\my\controllers;

use common\behavior\PointBehavior;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class IndexController extends BaseController
{

    public $enableCsrfValidation = true;

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
    public function actionAlterPwd()
    {
        $_data = [];
        if ($this->isGet())
        {
            return $this->render('pwd', $_data);
        }

        $oldpassword = trim($this->req('oldpassword'));
        $password = trim($this->req('password'));
        $password_confirm = trim($this->req('password_confirm'));
        $userForm = Yii::$app->user->identity;
        if ($password !== $password_confirm)
        {
            return $this->toJson(-40301, '密码和确认密码不相同');
        }
        if (!$userForm->validatePassWord($oldpassword))
        {
            return $this->toJson(-40302, '您输入的旧密码不正确');
        }
        $ret = $userForm->reset($this->req());
        return $this->toJson($ret);
    }



}
