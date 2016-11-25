<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%meta}}".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $create_at
 * @property string $update_at
 */
class Meta extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
            [['create_at', 'update_at'], 'integer'],
            [['key'], 'string', 'max' => 100],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '公司介绍ID',
            'key' => '扩展字段key',
            'value' => '扩展字段值',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
