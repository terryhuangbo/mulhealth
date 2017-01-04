<?php

namespace frontend\modules\user\controllers;

use common\utils\Wechat;
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
        $wechat = Yii::$app->wechat;
        $wechat->valid();
        $type = $wechat->getRev()->getRevType();
        switch ($type)
        {
            case Wechat::MSGTYPE_TEXT:
                $wechat->text("hello, I'm wechat, haha,haha")->reply();
                exit;
                break;
            case Wechat::MSGTYPE_EVENT:
                $wechat->text("hello, it is a event")->reply();
                exit;
                break;
            case Wechat::MSGTYPE_IMAGE:
                $wechat->text("hello, it is a image")->reply();
                exit;
                break;
            default:
                $wechat->text("help info")->reply();
        }
    }

}
