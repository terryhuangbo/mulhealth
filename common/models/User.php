<?php

namespace common\models;

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
class User extends BaseModel implements IdentityInterface
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
    const SCENARIO_LOGIN   = 'login';
    const SCENARIO_REGISTER = 'register';

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
            ['password', 'filter',  'filter' => function($val){
                return md5(sha1($val));//密码生成规则
            }],
            //name
            ['name', 'string', 'max' => 30],
            ['name', 'filter', 'filter' => function($val){
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
        //登录
        $scenarios[self::SCENARIO_LOGIN] = [
            'name',
            'id_card',
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
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }

        if($insert){ //插入操作
            $this->authKey = $this->genAuthKey();
        }

        return true;
    }

    /**
     * 用户注册
     */
    public function register($param)
    {
        $this->scenario = self::SCENARIO_REGISTER;
        $this->load($param, '');
        $ret = $this->save(true);
        if ($ret['code'] < 0) {
            return ['code' => '-40302', 'msg' => reset($this->getFirstErrors())];
        }
        Yii::$app->user->login($this, 1*24*60);
        return ['code' => '20000', 'msg' => '注册成功'];
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
