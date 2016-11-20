<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%comment_like}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $cid
 * @property string $create_at
 */
class CommentLike extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_like}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'cid', 'create_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '点赞ID',
            'uid' => '点赞人用户ID',
            'cid' => '评论ID',
            'create_at' => '创建时间',
        ];
    }
}
