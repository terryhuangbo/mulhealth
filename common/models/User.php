<?php

namespace common\models;

use common\lib\Filter;
use common\lib\RegexValidator;
use Yii;
use common\behavior\TimeBehavior;
use common\base\BaseModel;
use yii\validators\FilterValidator;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $uid
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $id_card
 * @property string $nick
 * @property string $name
 * @property string $avatar
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
            [['sex', 'status', 'update_at', 'create_at', 'login_at'], 'integer'],
            [['username', 'nick', 'name'], 'string', 'max' => 30],
            //必填字段
            [['id_card', 'password', 'name'], 'required'],
            //id_card
            [['id_card'], 'unique', 'message' => '用户已经被注册了'],
            [['id_card'], RegexValidator::className(),'method' => 'identity', 'message' => '身份证号不合法'],
            //password
            [['password'], 'string', 'max' => 32],
            ['password', 'filter' => function($val){
                return md5(sha1($val));//密码生成规则
            }],
            //name
            ['name', 'string', 'max' => 30],
            ['name', 'filter' => function($val){
                return Filter::filters_title($val);//姓名过滤
            }],
            //sex
            ['sex', 'in', 'range' => [self::MALE, self::FEMALE], 'message' => '性别错误'],
            //authKey
            [['authKey'], 'string', 'max' => 50],
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
            'id_card' => '身份证号',
            'nick' => '用户微信昵称',
            'name' => '用户真实姓名',
            'avatar' => '用户头像',
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
     * 获取手机号
     **/
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){ //插入操作
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function login($param)
    {
        if (empty($param['mobile'])) {
            return ['code' => '-40301', 'msg' => '手机号码不能为空'];
        }
        $mobile = $param['mobile'];
        $user = static::findOne(['mobile' => $mobile]);

        $reg = false;
        if (empty($user)) {
            $user = new static();
            $user->mobile = $mobile;
            $user->authKey = $this->genAuthKey();
            if (!$user->validate()) {
                return ['code' => '-40302', 'msg' => reset($user->getFirstErrors())];
            }
            $ret = $user->save();
            if ($ret['code'] < 0) {
                return ['code' => '-40303', 'msg' => $ret['code']];
            }
            $reg = true;
        }
        Yii::$app->user->login($user, 24*24*60);
        $user->touch('login_at');//更新登录时间
        return ['code' => '20000', 'msg' => $reg ? '注册成功' : '登录成功'];

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
     * 关联购物车
     **/
    public function getCart() {
        return $this->hasOne(Cart::className(), ['uid' => 'uid']);
    }
}
