<?php

namespace app\models;

use common\base\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $create_at
 * @property integer $update_at
 */
class Tags extends BaseModel
{

    /**
     * 类型
     */
    const TYPE_PROJECT   = 1;//项目
    const TYPE_CASE      = 2;//案例
    const TYPE_KNOWLEDGE = 3;//知识

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'create_at', 'update_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            //name必须唯一
            [['name'], 'unique', 'message' => '你已经添加过该标签了'],
            //type类型限制
            [['type'], 'in','range' => [self::TYPE_PROJECT, self::TYPE_CASE, self::TYPE_KNOWLEDGE], 'message' => '你已经添加过该标签了'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '标签类型（1-项目；2-案例；3-知识）',
            'name' => '标签',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    
}
