<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%knowledge}}".
 *
 * @property string $id
 * @property string $title
 * @property string $pic
 * @property string $detail
 * @property string $tags
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Knowledge extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%knowledge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail'], 'required'],
            [['detail'], 'string'],
            [['status', 'create_at', 'update_at'], 'integer'],
            [['title'], 'string', 'max' => 60],
            [['pic'], 'string', 'max' => 250],
            [['tags'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '知识ID',
            'title' => '标题',
            'pic' => '知识图片',
            'detail' => '知识描述',
            'tags' => '标签',
            'status' => '状态（1-正常；2-删除）',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
