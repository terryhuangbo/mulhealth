<?php

namespace app\base;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\lib\Tools;

class BaseController extends Controller
{
    public $enableCsrfValidation = true;
    public $open_id = '';//微信公众号
    public $uid = '';//微信公众号
    public $user = '';//用户信息
    public $signPackage = '';//微信jssdk实例
    public $_uncheck = []; //不用校验登录的方法,可子类复写

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    //用户认证登录
                    [
                        'allow' => true,
                        'matchCallback' => function ($role, $action) {
                            if (in_array($action->id, $this->_uncheck, true)) {
                                return true;
                            }else if(!Yii::$app->user->isGuest){
                                $this->user = Yii::$app->user->identity->toArray();
                                $this->uid = Yii::$app->user->identity->uid;
                                $this->signPackage = Yii::$app->jssdk->getSignPackage();
                                return true;
                            }
                            $absUrl = Yii::$app->getRequest()->absoluteUrl;
                            Yii::$app->session->set('_redirectUrl', $absUrl);
                            return false;
                        },
                        'denyCallback' => function($rule, $action){//跳转登录页面
                            return Yii::$app->user->loginRequired();
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * 判断是否是POST请求
     * @return string
     */
    public function isPost()
    {
        return Yii::$app->request->isPost;
    }

    /**
     * 判断是否是Get请求
     * @return string
     */
    public function isGet()
    {
        return Yii::$app->request->isGet;
    }

    /**
     * 判断是否是Ajax请求
     * @return string
     */
    public function isAjax()
    {
        return Yii::$app->request->isAjax;
    }

    /**
     * 获取浏览器类型
     * @return string
     */
    public function getBrowser()
    {
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11')) //ie11判断
        {
            return "ie";
        } else if (strpos($agent, 'Firefox') !== false) {
            return "firefox";
        } else if (strpos($agent, 'Chrome') !== false) {
            return "chrome";
        } else if (strpos($agent, 'Opera') !== false) {
            return 'opera';
        } else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false) {
            return 'safari';
        } else {
            return 'unknown';
        }
    }


    /**
     * 返回格式化数据转json
     * @param int $code
     * @param string $msg
     * @param bool $data
     * @return string
     */
    public function toJson($code, $msg = '', $data = null) {
        Yii::$app->response->getHeaders()->set('Content-Type', 'application/json;charset=utf-8');

        if (is_array($code) && !empty($code))
        {
            $code['request_ip'] = Tools::getIP();
            return json_encode($code);
        }

        $r_data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'request_ip' => Tools::getIP(),
        ];

        if (empty($code) && $code != 0) {
            $r_data['ret'] = -40400;
        }

        if (empty($msg)) {
            unset($r_data['msg']);
        }

        if ($data === null) {
            unset($r_data['data']);
        }

        $_callback_fun_name = '';
        $jsonp  = $this->req('jsonp');
        if (!empty($jsonp)) {
            $_callback_fun_name = $this->req('jsonp');
        }

        if (!empty($_callback_fun_name)) {
            exit($_callback_fun_name . '(' . $this->toJson($r_data) . ');');
        }

        return json_encode($r_data);
    }

    /**
     * 获取Request参数
     * @param string $key
     * @param bool|array|string $default 当请求的参数不存在时的默认值
     * @return string
     */
    public function req($key = '', $default = null) {
        $request = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        if(empty($key)){
            return $request;
        }
        if(!isset($request[$key])){
            return $default;
        }
        return $request[$key];
    }

    /**
     * 跳转到链接
     * @param string $url
     * @param int $statusCode 状态码，可以是301,302,304,307,308等；默认为302
     * @return string
     */
    public function redirect($url, $statusCode = 302) {
        if (Yii::$app->getRequest()->getIsAjax())
        {
            return $this->toJson(30201, '', ['redirectUrl' => \yii\helpers\Url::to($url)]);
        }else{
            return parent::redirect($url, $statusCode);
        }
    }

}

?>