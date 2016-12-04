<?php

namespace common\models;

use common\lib\Tools;
use Yii;
use common\lib\Filter;
use common\lib\RegexValidator;
use common\behavior\TimeBehavior;
use common\base\BaseModel;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $uid
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $open_id
 * @property string $id_card
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $age
 * @property integer $sex
 * @property string $mobile
 * @property string $address
 * @property integer $status
 * @property integer $update_at
 * @property integer $create_at
 * @property string $login_at
 */
class User extends BaseModel
{
    /**
     * 性别
     */
    const MALE   = 1;//男
    const FEMALE = 2;//女

    /**
     * 状态
     */
    const STATUS_ON  = 1;//启用
    const STATUS_OFF = 2;//禁用

    /**
     * 场景
     */
    const SCENARIO_PERFECT  = 'perfect';//完善用户信息

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'sex', 'status', 'update_at', 'create_at', 'login_at'], 'integer'],
            [['username', 'nick', 'name'], 'string', 'max' => 30],
            //必填字段
            [['id_card', 'password', 'name'], 'required'],
            //id_card
            [['id_card'], 'unique', 'message' => '用户已经被注册了'],
            [['id_card'], RegexValidator::className(),'method' => 'identity', 'message' => '身份证号不合法'],
            //password
            [['password'], 'string', 'max' => 32],
            ['password', 'filter',  'filter' => [$this, 'genPwd']],
            //name
            ['name', 'string', 'max' => 30],
            ['name', 'filter', 'filter' => function($val){
                return Filter::filters_title($val);//姓名过滤
            }],
            //sex
            ['sex', 'in', 'range' => [self::MALE, self::FEMALE], 'message' => '性别错误'],
            //authKey
            [['authKey', 'open_id'], 'string', 'max' => 50],
            [['authKey'], 'unique', 'message' => 'authKey必须唯一'],
            //avatar
            [['avatar'], 'string', 'max' => 250],
            //mobile
            [['mobile'], 'string', 'max' => 11],
            //address
            [['address'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'username' => '账号',
            'password' => '密码',
            'authKey' => 'authKey',
            'open_id' => '微信Open ID',
            'id_card' => '身份证号',
            'nick' => '用户微信昵称',
            'name' => '用户真实姓名',
            'avatar' => '用户头像',
            'age' => '年龄',
            'sex' => '性别（1-男；2-女）',
            'mobile' => '用户手机号码',
            'address' => '通讯地址',
            'status' => '状态（1-启用；2-禁用）',
            'update_at' => '更新时间',
            'create_at' => '创建时间',
            'login_at' => ' 自动登录时间',
        ];
    }

    /**
     * 公共模型的行为，比如对某些字段自动更新时间戳操作
     * @return array
     */
    public function behaviors()
    {
        return [
            'timeStamp' => [
                'class' => TimeBehavior::className(),
                'create' => ['create_at', 'login_at'],
                'update' => 'update_at',
            ],
        ];
    }

    /**
     * 应用场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //完善
        $scenarios[self::SCENARIO_PERFECT] = [
            'name',
            'nick',
            'sex',
            'avatar',
            'id_card',
            'mobile',
            'address',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }

        if($insert){ //插入操作
            $this->authKey = $this->genAuthKey();
            $this->nick = !empty($this->nick) ? $this->nick : $this->name;//默认昵称
            $this->age =  Tools::getAgeByID($this->id_card);//根据身份证计算年龄
            $this->avatar =  '/images/tx.png';//默认头像
        }

        return true;
    }

    /**
     * 生成加密密码
     * @return string
     */
    public static function genPwd($pwd) {
        $salt = 'XYCY!@$@YNI';
        return md5(sha1($pwd . $salt));
    }

    /**
     * 生成唯一用户authKey
     * @return string
     */
    protected function genAuthKey() {
        $authKey = Yii::$app->security->generateRandomString();
        $exist = static::find()->where(['authKey' => $authKey])->exists();
        if($exist){
            $this->genAuthKey();
        }
        return $authKey;
    }

    /**
     * 用户信息完善
     * @param array $param
     * @return array
     */
    public function perfect($param)
    {
        $this->scenario = self::SCENARIO_PERFECT;
        $this->load($param, '');
        if (!$this->validate())
        {
            return ['code' => '-40301', 'msg' => reset($this->getFirstErrors())];
        }
        $ret = $this->save();
        if ($ret['code'] < 0)
        {
            return ['code' => '-50001', 'msg' => '保存失败'];
        }
        return ['code' => '20000', 'msg' => '用户信息完善成功'];
    }
}
