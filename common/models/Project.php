<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%project}}".
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
class Project extends BaseModel
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
        return '{{%project}}';
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
            'id' => '项目ID',
            'title' => '标题',
            'pic' => '项目图片',
            'detail' => '项目描述',
            'tags' => '标签',
            'status' => '状态（1-正常；2-删除）',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
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
