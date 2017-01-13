<?php

namespace common\models;

use common\lib\Filter;
use common\lib\RegexValidator;
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
            //姓名过滤
            ['name', 'filter', 'filter' => [Filter::className(), 'filters_title']],
            //mobile
            ['mobile', RegexValidator::className(), 'method' => 'mobile', 'message' => '手机格式不正确'],
            //状态
            [['status'], 'in', 'range' => array_keys(static::getStatuses()), 'message' => '状态不正确'],
            //输入过滤
            [['purpose', 'result', 'next_plan', 'note'], 'filter', 'filter' => [Filter::className(), 'filters_outcontent']],
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