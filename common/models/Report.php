<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%report}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $location
 * @property string $self_history
 * @property string $family_history
 * @property string $pic
 * @property string $time
 * @property string $age
 * @property string $weight
 * @property string $height
 * @property string $systolic
 * @property string $diastolic
 * @property integer $heartrate
 * @property string $bmi
 * @property string $vision
 * @property string $data
 * @property string $create_at
 * @property string $update_at
 */
class Report extends BaseModel
{
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
        return '{{%report}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'time', 'age', 'heartrate', 'create_at', 'update_at'], 'integer'],
            [['weight', 'height', 'systolic', 'diastolic', 'bmi', 'vision'], 'number'],
            [['pic', 'self_history', 'family_history'], 'string', 'max' => 250],
            [['location'], 'string', 'max' => 100],
            [['data'], 'string'],
            //必须字段
//            [['uid', 'pic', 'time','heartrate', 'weight', 'height', 'systolic', 'diastolic', 'bmi', 'vision'], 'required'],
            [['uid'], 'required'],
            //用户ID
            ['uid', 'exist', 'targetAttribute' => 'uid', 'targetClass' => User::className(), 'message' => '用户不存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '报告编号',
            'uid' => '用户ID',
            'location' => '地点',
            'self_history' => '个人病史',
            'family_history' => '家族病史',
            'pic' => '体检报告图',
            'time' => '体检时间',
            'age' => '年龄',
            'weight' => '体重（公斤）',
            'height' => '身高（cm）',
            'systolic' => '收缩压（mnHg）',
            'diastolic' => '舒张压（mnHg）',
            'heartrate' => '心率（次/分）',
            'bmi' => '体重指数',
            'vision' => '视力',
            'data' => '体检项目',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 关联用户表
     * @return \yii\db\ActiveQuery
     */
    public function getUser(){
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 状态
     * @param $status int
     * @return array|boolean
     */
    public static function getStatuses($status = null){
        $statusArr = [
            self::STATUS_ON   => '启用',
            self::STATUS_OFF  => '禁用',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }
}
