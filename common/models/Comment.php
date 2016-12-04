<?php

namespace common\models;

use common\lib\Filter;
use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $pid
 * @property string $uid
 * @property string $open_id
 * @property string $pics
 * @property string $content
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Comment extends BaseModel
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
            //必须字段
            [['content', 'pid'], 'required'],
            //content
            [['content'], 'string', 'max' => 420, 'tooLong' => '不得超过140个字'],
            ['content', 'filter', 'filter' => [Filter::className(), 'filters_outcontent']],
            //pid
            ['pid', 'default', 'value' => 0],
            //pid
            ['open_id', 'required'],
            //pics
            ['pics', 'filter', 'filter' => function($v){
                return !empty($v) ? json_encode((array) $v) : '';
            }],
            //status
            ['status', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF], 'message' => '状态错误'],
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
            'open_id' => '微信Open ID',
            'pics' => '图片',
            'content' => '评论内容',
            'status' => '状态（1-正常；2-删除）',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 关联用户表
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }


}
