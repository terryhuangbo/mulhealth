<?php

namespace frontend\modules\home\controllers;

use common\models\Meta;
use Yii;
use app\base\BaseController;
use common\models\User;


class IndexController extends BaseController
{

    public $layout = '//home';
    public $enableCsrfValidation = false;

    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $meta = new Meta();
        $_data = $meta->asArray();
        $_data['banners'] = !empty($_data['banners']) ? json_decode($_data['banners'], true) : [];

        if (Yii::$app->user->isGuest)
        {

            return $this->render('index', $_data);
        }
        return $this->render('index-login', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionIndexLogin()
    {
        $_data = [];
        return $this->render('index-login', $_data);
    }





}
