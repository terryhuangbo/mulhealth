<?php

namespace frontend\modules\my;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\my\controllers';

    /**
     * 此模块下的所有action必须要登录校验
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
        {
            return false;
        }
        //没有登录，去登录
        if (Yii::$app->user->isGuest)
        {
            $absUrl = Yii::$app->getRequest()->absoluteUrl;
            Yii::$app->session->set('_redirectUrl', $absUrl);
            return Yii::$app->user->loginRequired();
        }
        return true;
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
