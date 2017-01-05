<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use backend\modules\team\models\Team;

/**
 * This is the model class for table "{{%wechat_msg}}".
 *
 * @property integer $id
 * @property string $content
 * @property string $reply
 * @property string $open_id
 * @property integer $status
 * @property string $service_account
 * @property integer $create_at
 * @property integer $reply_at
 */
class WechatMsg extends BaseModel
{
    /**
     * 状态
     */
    const STATUS_WAITING  = 1;//待回复
    const STATUS_REPLIED  = 2;//已回复

    /**
     * 应用场景
     */
    const SCENARIO_RECORD = 'record'; //记录消息
    const SCENARIO_REPLY  = 'reply';   //回复消息

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_msg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'create_at', 'reply_at'], 'integer'],
            [['content', 'reply'], 'string', 'max' => 400],
            [['open_id'], 'string', 'max' => 50],
            [['service_account'], 'string', 'max' => 30],
            //必填字段
//            [['content', 'reply', 'open_id', 'service_account'], 'required'],
            //service_account必须存在
//            ['service_account', 'exist', 'targetAttribute' => 'username', 'targetClass' => Team::className()],
            //status
            ['status', 'in', 'range' => [self::STATUS_WAITING, self::STATUS_REPLIED], 'message' => '状态不正确'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '客服消息ID',
            'content' => '消息内容',
            'reply' => '消息内容',
            'open_id' => '发送者openID',
            'status' => '消息状态(1-待回复；2-已回复)',
            'service_account' => '微信客服账号',
            'create_at' => '发布时间',
            'reply_at' => '回复时间',
        ];
    }

    /**
     * 关联表-hasMany
     * @return \yii\db\ActiveRecord
     **/
    public function getAdmin() {
        return $this->hasOne(Team::className(), ['username' => 'service_account']);
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_RECORD => ['open_id', 'content'],
            self::SCENARIO_REPLY  => ['service_account', 'reply', 'status', 'reply_at'],
        ];
    }

    /**
     * 状态
     * @param $status int
     * @return array|boolean
     */
    public static function getStatuses($status = null){
        $statusArr = [
            self::STATUS_WAITING  => '待回复',
            self::STATUS_REPLIED  => '已回复',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }


}
