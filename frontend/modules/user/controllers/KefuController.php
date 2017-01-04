<?php

namespace frontend\modules\user\controllers;

use app\components\Wechat\Wechat;
use Yii;
use yii\web\Controller;


class KefuController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    /**
     * 微信客服
     * @return type
     */
    public function actionIndex()
    {
        $weObj = new Wechat(yiiParams('wechat'));
        $weObj->valid();
        $type = $weObj->getRev()->getRevType();
        switch ($type)
        {
            case Wechat::MSGTYPE_TEXT:
                $weObj->text("hello, I'm wechat, haha,haha")->reply();
                exit;
                break;
            case Wechat::MSGTYPE_EVENT:
                $weObj->text("hello, it is a event")->reply();
                exit;
                break;
            case Wechat::MSGTYPE_IMAGE:
                $weObj->text("hello, it is a image")->reply();
                exit;
                break;
            default:
                $weObj->text("help info")->reply();
        }
    }

}
