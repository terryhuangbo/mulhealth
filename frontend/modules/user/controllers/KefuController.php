<?php

namespace frontend\modules\user\controllers;

use common\lib\Http;
use common\utils\Wechat;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;


class KefuController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    /**
     * 公众号会话
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

    /**
     * 公众号会话-微信客服
     * @return type
     */
    public function actionTest()
    {
        $touser = "oMpUMwgw98JIH_kwryDpiYf79LZ8";
        $content = 'huangbo is good man' . time();

        $wechat = Yii::$app->wechat;
        $ACC_TOKEN = $wechat->checkAuth();
        VarDumper::export($wechat);exit;
        $data = [
            'touser' => $touser,
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],

        ];





        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $ACC_TOKEN;
//        $url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=" . $ACC_TOKEN;
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$ACC_TOKEN}";
        $data = json_encode($data);
//        $result = json_decode(Http::post($url, $data), true);
        $result = json_decode(Http::get($url, $data), true);
        return VarDumper::export($result);

//        return $this->render('index');
    }

    /**
     * 微信网页认证
     */
    public function actionWechatAuth()
    {
        $auth = Yii::$app->wechatAuth;
        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];
        VarDumper::export($nickname);

    }



}
