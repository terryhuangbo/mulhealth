<?php

namespace frontend\modules\user\controllers;

use Yii;
use frontend\models\UserForm;
use app\base\BaseController;


class IndexController extends BaseController
{
    public $layout = '//home';
    public $_uncheck = [
        'index',
        'index-login',
        'login',
        'register',
        'reset',
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
        $user = UserForm::findOne(['id_card' => $id_card, 'password' => UserForm::genPwd($password)]);
        if (!$user)
        {
            return $this->toJson(-40301, '账号或者密码不存在');
        }
        //登录用户
        $user->login();
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
        $user = new UserForm();

        $ret = $user->register(Yii::$app->request->post());
        if ($ret['code'] < 0)
        {
            return $this->toJson($ret);
        }
        return $this->redirect('/my/profile/perfect');
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionReset()
    {
        $_data = [];
        if ($this->isGet())
        {
            return $this->render('reset', $_data);
        }
        $id_card = trim($this->req('id_card'));
        $name = trim($this->req('name'));
        $userForm = UserForm::findOne(['id_card' => $id_card, 'name' => $name]);
        if (!$userForm)
        {
            return $this->toJson(-40301, '用户不存在');
        }
        $ret = $userForm->reset($this->req());
        if ($ret['code'] < 0)
        {
            return $this->toJson($ret);
        }
        return $this->redirect(Yii::$app->homeUrl);
    }

    /**
     * 登出
     * @return type
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->homeUrl);
    }

}
