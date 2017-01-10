<?php

namespace common\utils;

use yii\base\Component;
use Yii;

/**
 * 微信oAuth认证，用户公众号内网页功能开发
 */
class WechatAuth extends Component
{
    public $appid;
    public $appsecret;
    public $token;
    public $encodingaeskey = '';

    public $open_id;
    public $wxuser;

    public function init()
    {
        parent::init();
        $this->wxoauth();
        session_start();
    }


    public function wxoauth()
    {
        $scope = 'snsapi_base';
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        $token_time = isset($_SESSION['token_time']) ? $_SESSION['token_time'] : 0;
        if (!$code && isset($_SESSION['open_id']) && isset($_SESSION['user_token']) && $token_time > time() - 3600)
        {
            if (!$this->wxuser)
            {
                $this->wxuser = $_SESSION['wxuser'];
            }
            $this->open_id = $_SESSION['open_id'];
            return $this->open_id;
        } else
        {
            $options = array(
                'token' => $this->token, //填写你设定的key
                'encodingaeskey' => $this->encodingaeskey, //填写加密用的EncodingAESKey
                'appid' => $this->appid, //填写高级调用功能的app id
                'appsecret' => $this->appsecret //填写高级调用功能的密钥
            );
//            $we_obj = new Wechat($options);
            $options['class'] = Wechat::className();
            $we_obj = Yii::createObject($options);
            if ($code)
            {
                $json = $we_obj->getOauthAccessToken();
                if (!$json)
                {
                    unset($_SESSION['wx_redirect']);
                    die('获取用户授权失败，请重新确认');
                }
                $_SESSION['open_id'] = $this->open_id = $json["openid"];
                $access_token = $json['access_token'];
                $_SESSION['user_token'] = $access_token;
                $_SESSION['token_time'] = time();
                $userinfo = $we_obj->getUserInfo($this->open_id);
                if ($userinfo && !empty($userinfo['nickname']))
                {
                    $this->wxuser = array(
                        'open_id' => $this->open_id,
                        'nickname' => $userinfo['nickname'],
                        'sex' => intval($userinfo['sex']),
                        'location' => $userinfo['province'] . '-' . $userinfo['city'],
                        'avatar' => $userinfo['headimgurl']
                    );
                } elseif (strstr($json['scope'], 'snsapi_userinfo') !== false)
                {
                    $userinfo = $we_obj->getOauthUserinfo($access_token, $this->open_id);
                    if ($userinfo && !empty($userinfo['nickname']))
                    {
                        $this->wxuser = array(
                            'open_id' => $this->open_id,
                            'nickname' => $userinfo['nickname'],
                            'sex' => intval($userinfo['sex']),
                            'location' => $userinfo['province'] . '-' . $userinfo['city'],
                            'avatar' => $userinfo['headimgurl']
                        );
                    } else
                    {
                        return $this->open_id;
                    }
                }
                if ($this->wxuser)
                {
                    $_SESSION['wxuser'] = $this->wxuser;
                    $_SESSION['open_id'] = $json["openid"];
                    unset($_SESSION['wx_redirect']);
                    return $this->open_id;
                }
                $scope = 'snsapi_userinfo';
            }
            if ($scope == 'snsapi_base')
            {
                $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $_SESSION['wx_redirect'] = $url;
            } else
            {
                $url = $_SESSION['wx_redirect'];
            }
            if (!$url)
            {
                unset($_SESSION['wx_redirect']);
                die('获取用户授权失败');
            }
            $oauth_url = $we_obj->getOauthRedirect($url, "wxbase", $scope);
            header('Location: ' . $oauth_url);
        }
    }

    public function __destruct()
    {
        unset($this->wxuser);
        session_destroy();
    }
}

