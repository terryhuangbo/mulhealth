<?php

namespace frontend\modules\user\controllers;

use common\lib\Http;
use common\models\WechatMsg;
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
                $mdl = new WechatMsg();
                $mdl->scenario = WechatMsg::SCENARIO_RECORD;
                $mdl->setAttributes([
                    'open_id' => $wechat->getRevFrom(),
                    'content' => $wechat->getRevContent(),
                ]);
                //保存消息
                if ($mdl->save())
                {
                    $wechat->text("您好！您的消息已收到，我们的客服人员会在第一时间答复您！！")->reply();
                }
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
        $data = [
            'touser' => $touser,
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],

        ];

        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $ACC_TOKEN;
        $data = json_encode($data);
        $result = json_decode(Http::post($url, $data), true);
//        $result = json_decode(Http::get($url, $data), true);
        return VarDumper::export($result);

    }

    /**
     * 公众号会话-添加微信客服账号
     * @return type
     */
    public function actionAdd()
    {
        $wechat = Yii::$app->wechat;
        $ACC_TOKEN = $wechat->checkAuth();

        $account = 'kefu1' . '@' . $wechat->appAccount;
        $nick = '客服3';
        $password = '123456';
        $data = [
            'kf_account' => $account,
            'nickname' => $nick,
            'password' => $password,
        ];
        $url = "https://api.weixin.qq.com/customservice/kfaccount/add?access_token=$ACC_TOKEN";
        $result = json_decode(Http::post($url, json_encode($data)), true);
        echo '<pre>';
        print_r($result);
        exit;
    }

    /**
     * 公众号会话-添加微信客服账号
     * @return type
     */
    public function actionList()
    {
        $wechat = Yii::$app->wechat;
        $ACC_TOKEN = $wechat->checkAuth();

        $url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=$ACC_TOKEN";
        $result = json_decode(Http::post($url, []), true);
        echo '<pre>';
        print_r($result);
        exit;
    }

    /**
     * 公众号会话-回复
     * @return type
     */
    public function actionReply()
    {
        $wechat = Yii::$app->wechat;
        $ACC_TOKEN = $wechat->checkAuth();
        $open_id = 'onP0htz2OoARzmQzp3NQk_itbB5U';

        $content = 'hait,123!' . time();
        $data = [
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],
            'customservice' => [
                'kf_account' => 'kefu1@kangheyuan2015'
            ],

        ];
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $ACC_TOKEN;
        $result = json_decode(Http::post($url, json_encode($data)), true);
        echo '<pre>';
        print_r($result);
        exit;
    }

    /**
     * 微信网页认证
     */
    public function actionAuth()
    {
        $auth = Yii::$app->wechatAuth;
        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];
        echo $open_id;
        exit;

    }



}
