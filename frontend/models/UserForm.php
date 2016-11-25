<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;
use common\models\User;

/**
 * 此Model继承common\models\User并且实现yii\web\IdentityInterface
 * 接口，完成用户鉴权，登录，登出，改密等相关功能
 */
class UserForm extends User implements IdentityInterface
{

    /**
     * 场景
     */
    const SCENARIO_LOGIN     = 'login';//登录
    const SCENARIO_REGISTER  = 'register';//注册
    const SCENARIO_RESET     = 'reset';//改密

    /**
     * 应用场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //注册
        $scenarios[self::SCENARIO_REGISTER] = [
            'name',
            'id_card',
            'password',
        ];
        //修改密码
        $scenarios[self::SCENARIO_RESET] = [
            'password',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($uid)
    {
        return static::findOne($uid);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->uid;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * 验证密码
     */
    public function validatePassWord($pwd)
    {
        return $this->password === $this->genPwd($pwd);
    }

    /**
     * 用户登录
     */
    public function login()
    {
        Yii::$app->user->login($this, 1*24*60);
        $this->touch('login_at');//更新最近登录时间
    }

    /**
     * 用户注册
     * @param array $param
     * @return array
     */
    public function register($param)
    {
        $this->scenario = self::SCENARIO_REGISTER;
        $this->load($param, '');
        $ret = $this->save(true);
        if ($ret['code'] < 0) {
            return ['code' => '-40302', 'msg' => reset($this->getFirstErrors())];
        }
        $this->login();//登录
        return ['code' => '20000', 'msg' => '注册成功'];
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        Yii::$app->user->logout();
    }

    /**
     * 修改密码
     * @param array $param
     * @return array
     */
    public function reset($param)
    {
        $this->scenario = self::SCENARIO_RESET;
        $this->load($param, '');
        if (!$this->validate())
        {
            return ['code' => '-40301', 'msg' => reset($this->getFirstErrors())];
        }
        $ret = $this->save();
        if ($ret['code'] < 0)
        {
            return ['code' => '-50001', 'msg' => '修改密码失败'];
        }
        $this->logout();//登出用户，让用户重新登录
        return ['code' => '20000', 'msg' => '修改密码成功'];
    }

}
