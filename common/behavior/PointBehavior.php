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
     * @var int 点击规则积分
     */
    public $point_id = 0;
    /**
     * @var int 积分类型
     */
    public $points_name = 'share';

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
        if (!is_int($this->points ) || $this->points <= 0) {
            throw new Exception("the points must be greater than 0");
        }
        //每天每人签到和分享只能有一次
        if (in_array($this->points_name, [PointsRecord::POINTS_SHARE, PointsRecord::POINTS_SIGH])) {
            $sign = PointsRecord::find()
                ->where(['uid' => $user->uid])
                ->andWhere(['points_name' => $this->points_name])
                ->andWhere(['>', 'create_at', strtotime('today')])
                ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
                ->exists();
            if($sign){
                throw new Exception("今天已经签到过了");
            }
        }else if($this->points_name === PointsRecord::POINTS_DETAIL){
            //每天每人查看规则只能有三次
            $total = (new Query())
                ->from(PointsRecord::tableName())
                ->where(['uid' => $user->uid])
                ->andWhere(['points_name' => $this->points_name])
                ->andWhere(['>', 'create_at', strtotime('today')])
                ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
                ->count('*', PointsRecord::getDb());
            if($total >= 3){
                throw new Exception("您已经获得3个查看细则积分");
            }
        }

        $pmdl = new PointsRecord();
        $pmdl->attributes = [
            'points' => $this->points,
            'point_id' => $this->point_id,
            'points_name' => $this->points_name,
            'uid' => $user->uid,
        ];
        $ret = $pmdl->save();
        if ($ret['code'] < 0) {
            throw new Exception("the points record saved fail");
        }
    }


}
