<?php

namespace common\models;

use common\lib\Filter;
use common\lib\Tools;
use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%cell}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $description
 * @property string $pics
 * @property string $status
 * @property string $report_at
 * @property string $create_at
 * @property string $update_at
 */
class Cell extends BaseModel
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
        return '{{%cell}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'create_at', 'update_at', 'report_at'], 'integer'],
            //必填字段
            [['pics', 'description', 'pics', 'report_at'], 'required'],
            //uid
            ['uid', 'exist', 'targetAttribute' => 'uid', 'targetClass' => User::className(), 'message' => '用户必须存在'],
            //description
            [['description'], 'string', 'max' => 500],
            [['description'], 'filter', 'filter' => [Filter::className(), 'filters_outcontent']],
            //status
            ['status', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF]],
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
            'status' => '状态（1-正常；2-删除）',
            'report_at' => '记录的时间',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 关联用户表
     * @return \yii\db\ActiveQuery
     */
    public function getUser(){
        return $this->hasOne(User::className(), ['uid' => 'uid']);
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
