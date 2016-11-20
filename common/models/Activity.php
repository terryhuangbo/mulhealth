<?php

namespace common\models;

use common\base\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%activity}}".
 *
 * @property string $id
 * @property integer $zone
 * @property integer $list_order
 * @property string $poster
 * @property string $logo
 * @property string $begin_at
 * @property string $end_at
 * @property string $aims
 * @property string $way
 * @property string $limitation
 * @property string $details
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Activity extends BaseModel
{
    /**
     * 活动状态
     */
    const STATUS_ON  = 1;//上线
    const STATUS_OFF = 2;//下线

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%activity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zone', 'list_order', 'begin_at', 'end_at', 'create_at', 'update_at'], 'integer'],
            [['details'], 'string'],
            [['poster', 'logo'], 'string', 'max' => 300],
            [['aims', 'way', 'limitation'], 'string', 'max' => 400],
            [['zone', 'begin_at', 'end_at', 'details', 'end_at', 'aims', 'way', 'limitation'], 'required'],
            //开始，结束时间
            ['begin_at', 'compare', 'compareAttribute' => 'end_at', 'operator' => '<', 'message' => '开始时间必须小于结束时间'],
            //活动区域
            ['zone', 'in', 'range' => array_keys(yiiParams('activityZone')), 'message' => '活动区域不正确'],
            //活动状态
            ['status', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF], 'message' => '活动状态不正确'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '活动编号',
            'zone' => '活动区域编号(省ID)',
            'list_order' => '默认排序',
            'poster' => '活动图片',
            'logo' => '活动logo',
            'begin_at' => '活动开始时间',
            'end_at' => '活动结束时间',
            'aims' => '活动对象',
            'way' => '活动形式',
            'limitation' => '限额说明',
            'details' => '活动细则',
            'status' => '活动状态(1-上线；2-下线)',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 活动状态列表
     * @return array|boolean
     */
    public static function getActivityStatus($status = null){
        $statusArr = [
            self::STATUS_ON     => '上线',
            self::STATUS_OFF      => '下线',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }




}
