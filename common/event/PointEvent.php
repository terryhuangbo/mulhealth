<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\event;

use yii\base\Event;

/**
 * 赠送积分事件
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2.0
 */
class PointEvent extends Event
{

    /**
     * @var int 要赠送的积分数量
     */
    public $points = 0;


    /**
     * @var int 事件处理结果代码
     */
    public $code = 0;

    /**
     * @var string 事件处理结果消息
     */
    public $msg = '';



}
