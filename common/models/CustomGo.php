<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%custom_go}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property integer $call_at
 * @property string $purpose
 * @property string $result
 * @property string $next_plan
 * @property string $note
 * @property integer $status
 * @property integer $create_at
 * @property integer $update_at
 */
class CustomGo extends \common\base\BaseModel
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
        return '{{%custom_go}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['call_at', 'status', 'create_at', 'update_at'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
            [['purpose', 'result', 'next_plan', 'note'], 'string', 'max' => 250],
            //必填字段
            [['name', 'mobile'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '拜访记录ID',
            'name' => '客户姓名',
            'mobile' => '联系方式',
            'call_at' => '拜访时间',
            'purpose' => '拜访目的',
            'result' => '拜访结果',
            'next_plan' => '下次拜访计划',
            'note' => '备注',
            'status' => '状态（1-启用；2-禁用）',
            'create_at' => '创建时间',
            'update_at' => '修改时间',
        ];
    }
}
