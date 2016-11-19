<?php

namespace frontend\modules\user\controllers;

use Yii;
use app\base\BaseController;
use common\models\User;


class IndexController extends BaseController
{
    public $layout = '//home';
    public $enableCsrfValidation = false;
    public $_uncheck = [
        'index',
        'index-login',
        'login',
        'register',
        'foget',
    ];

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
    public function actionIndexLogin()
    {

        $_data = [];
        return $this->render('index-login', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionLogin()
    {
        if ($this->isGet())
        {
            return $this->render('login');
        }
        $id_card = Yii::$app->request->post('id_card');
        $password = trim(Yii::$app->request->post('password'));
        $user = User::findOne(['id_card' => $id_card, 'password' => md5(sha1($password))]);
        if (!$user)
        {
            return $this->toJson(-40301, '账号或者密码不存在');
        }
        //登录用户
        Yii::$app->user->login($user, 1*24*60);
        //更新登录时间
        $user->touch('login_at');
        return $this->redirect(Yii::$app->homeUrl);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionRegister()
    {
        if ($this->isGet())
        {
            return $this->render('register');
        }
        $user = new User();

        $ret = $user->register(Yii::$app->request->post());
        if ($ret['code'] < 0)
        {
            return $this->toJson($ret['code'], $ret['msg']);
        }
        return $this->redirect('/my/profile/index');
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionForget()
    {
        $_data = [];
        return $this->render('forget', $_data);
    }










}
