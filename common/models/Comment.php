<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $pid
 * @property string $uid
 * @property string $pics
 * @property string $content
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Comment extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'uid', 'status', 'create_at', 'update_at'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['pics'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论ID',
            'pid' => '评论父ID',
            'uid' => '评论者用户ID',
            'pics' => '评论图片',
            'content' => '评论内容',
            'status' => '状态（1-正常；2-删除）',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
