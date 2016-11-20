<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%report}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $pic
 * @property string $time
 * @property string $weight
 * @property string $height
 * @property string $systolic
 * @property string $diastolic
 * @property integer $heartrate
 * @property string $bmi
 * @property string $vision
 * @property string $create_at
 * @property string $update_at
 */
class Report extends BaseModel
{
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
            [['uid', 'time', 'heartrate', 'create_at', 'update_at'], 'integer'],
            [['weight', 'height', 'systolic', 'diastolic', 'bmi', 'vision'], 'number'],
            [['pic'], 'string', 'max' => 250]
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
            'pic' => '体检报告图',
            'time' => '体检时间',
            'weight' => '体重（公斤）',
            'height' => '身高（cm）',
            'systolic' => '收缩压（mnHg）',
            'diastolic' => '舒张压（mnHg）',
            'heartrate' => '心率（次/分）',
            'bmi' => '体重指数',
            'vision' => '视力',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
