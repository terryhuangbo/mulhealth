<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%cell}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $description
 * @property string $pics
 * @property string $create_at
 * @property string $update_at
 */
class Cell extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cell}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'create_at', 'update_at'], 'integer'],
            [['pics'], 'required'],
            [['pics'], 'string'],
            [['description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '细胞培养ID',
            'uid' => '用户ID',
            'description' => '描述',
            'pics' => '细胞培养图片',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
