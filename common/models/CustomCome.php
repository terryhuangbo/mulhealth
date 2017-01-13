<?php

namespace common\models;

use common\lib\Filter;
use common\lib\RegexValidator;
use Yii;

/**
 * This is the model class for table "{{%custom_come}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $source
 * @property integer $call_at
 * @property string $purpose
 * @property string $result
 * @property string $mark
 * @property string $note
 * @property integer $status
 * @property integer $create_at
 * @property integer $update_at
 */
class CustomCome extends \common\base\BaseModel
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
        return '{{%custom_come}}';
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
            [['source'], 'string', 'max' => 50],
            [['purpose', 'result', 'mark', 'note'], 'string', 'max' => 250],
            //必填字段
            [['name', 'mobile'], 'required'],
            //name姓名过滤
            ['name', 'filter', 'filter' => function($val){
                return Filter::filters_title($val);//姓名过滤
            }],
            //mobile
            ['mobile', RegexValidator::className(), 'method' => 'mobile', 'message' => '手机格式不正确']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '来访记录ID',
            'name' => '客户姓名',
            'mobile' => '联系方式',
            'source' => '客户来源',
            'call_at' => '来访时间',
            'purpose' => '来访目的',
            'result' => '过程内容',
            'mark' => '用户评级',
            'note' => '备注',
            'status' => '状态（1-启用；2-禁用）',
            'create_at' => '创建时间',
            'update_at' => '修改时间',
        ];
    }
}
