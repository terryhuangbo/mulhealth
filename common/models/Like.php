<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%like}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $open_id
 * @property integer $cid
 * @property integer $create_at
 */
class Like extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%like}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'cid', 'create_at'], 'integer'],
            [['open_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '点赞ID',
            'uid' => '用户ID',
            'open_id' => '微信Open ID',
            'cid' => '评论ID',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联用户表
     * @return \yii\db\ActiveQuery
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联评论表
     * @return \yii\db\ActiveQuery
     **/
    public function getComment() {
        return $this->hasOne(Comment::className(), ['cid' => 'id']);
    }





}
