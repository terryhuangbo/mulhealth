<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\behavior;

use common\models\PointsRecord;
use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use common\models\User;
use yii\db\Query;


/**
 * 赠送积分的行为
 * @property int $points 要添加的积分数量.
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-14 16:19
 */
class PointBehavior extends Behavior
{
    /**
     * @var int 要添加的积分数量.
     */
    public $points = 0;
    /**
     * @var int 积分类型
     */
    public $type = 0;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'handlePoints', //将事件和事件处理器绑定
        ];

    }

    /**
     * @inheritdoc
     */
    public function handlePoints($event) {

        $user = $this->owner;
        if (!$user instanceof User) {
            throw new Exception("the owner must be a User Instance");
        }
        if (!is_int($this->points ) || $this->points < 0) {
            throw new Exception("the points must be greater than 0");
        }
        //每种签到只能有一次
        $sign = PointsRecord::find()
            ->where(['uid' => $user->uid])
            ->andWhere(['point_id' => $this->type])
            ->andWhere(['>', 'create_at', strtotime('today')])
            ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
            ->exists();
        if($sign){
            throw new Exception("今天已经签到过了");
        }
        //每人每天积分不能超过三次
        $total = (new Query())
            ->from(PointsRecord::tableName())
            ->where(['uid' => $user->uid])
            ->andWhere(['>', 'create_at', strtotime('today')])
            ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
            ->sum('points', PointsRecord::getDb());
        if($total >= 3){
            throw new Exception("您已经获得3个积分");
        }

        $pmdl = new PointsRecord();
        $pmdl->attributes = [
            'points' => $this->points,
            'point_id' => $this->type,
            'uid' => $user->uid,
        ];
        $ret = $pmdl->save();
        if ($ret['code'] < 0) {
            throw new Exception("the points record saved fail");
        }
    }




}
