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
 * @property string $begin_at
 * @property string $end_at
 * @property string $aims
 * @property string $way
 * @property string $limitation
 * @property string $details
 * @property string $create_at
 * @property string $update_at
 */
class Activity extends BaseModel
{
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
            [['poster'], 'string', 'max' => 300],
            [['aims', 'way', 'limitation'], 'string', 'max' => 400],
            [['zone', 'begin_at', 'end_at', 'details', 'end_at', 'aims', 'way', 'limitation'], 'required'],
            //开始，结束时间
            ['begin_at', 'compare', 'compareAttribute' => 'end_at', 'operator' => '<', 'message' => '开始时间必须小于结束时间'],
            //活动区域
            ['zone', 'in', 'range' => array_keys(yiiParams('activityZone')), 'message' => '活动区域不正确'],
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
            'begin_at' => '活动开始时间',
            'end_at' => '活动结束时间',
            'aims' => '活动对象',
            'way' => '活动形式',
            'limitation' => '限额说明',
            'details' => '活动细则',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }




}
