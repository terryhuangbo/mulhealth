<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\behavior;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\base\Behavior;
use yii\db\Exception;
use common\models\User;
use common\models\Card;
use common\models\CardGroup;


/**
 * 赠送积分的行为
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-14 16:19
 */
class PointBehavior extends Behavior
{

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            User::EVENT_POINTS => 'handlePoints', //将事件和事件处理器绑定
        ];

    }

    /**
     * @inheritdoc
     */
    public function handlePoints($event) {
        $user = $event->owner;

    }





}
