<?php

namespace frontend\modules\redeem\controllers;

use common\behavior\PointBehavior;
use common\models\Activity;
use common\models\Points;
use common\models\PointsRecord;
use Yii;
use app\base\BaseController;


class ActivityController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    private $_hlj_id = 10;//黑龙江
    private $_ln_id = 8;//辽宁
    private $_jl_id = 9;//吉林

    /**
     * 关于我们
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 黑龙江地区
     * @return type
     */
    public function actionHlj()
    {
        $zone = $this->_hlj_id;
        $class_array = ['mdl', 'dfjzw', 'zz', 'lm', 'wdyc', 'drf', 'wlcs', 'hll', 'lccb', 'zyhcs'];
        $mdl = new Activity();
        $format = [
            'begin_end' => function($m){
                return '开始-' . date('Y-m-d H:i:s', $m->begin_at) . '  截止-' . date('Y-m-d H:i:s', $m->begin_at);
            }
        ];
        $format = array_merge($mdl->attributes(), $format);
        $activities = $mdl->getAll(['zone' => $zone, 'status' => Activity::STATUS_ON], 'list_order asc, id desc', 0, 10, $format);
        $_data = [
            'activities' => $activities,
            'class_array' => $class_array,
        ];
        return $this->render('hlj', $_data);
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionLn()
    {

        $zone = $this->_ln_id;
        $class_array = ['hll_ln', 'tmjt', 'drf_ln', 'xtd', 'jy', 'gwzx', 'jyj', 'ysd', 'kdj'];
        $mdl = new Activity();
        $format = [
            'begin_end' => function($m){
                return '开始-' . date('Y-m-d H:i:s', $m->begin_at) . '  截止-' . date('Y-m-d H:i:s', $m->begin_at);
            }
        ];
        $format = array_merge($mdl->attributes(), $format);
        $activities = $mdl->getAll(['zone' => $zone, 'status' => Activity::STATUS_ON], 'list_order asc, id desc', 0, 9, $format);
        $_data = [
            'activities' => $activities,
            'class_array' => $class_array,
        ];
        return $this->render('ln', $_data);
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionJl()
    {
        $zone = $this->_jl_id;
        $class_array = ['hll_jl', 'xtdcs', 'drf_jl', 'oyjt', 'ct', 'gpp'];
        $mdl = new Activity();
        $format = [
            'begin_end' => function($m){
                return '开始-' . date('Y-m-d H:i:s', $m->begin_at) . '  截止-' . date('Y-m-d H:i:s', $m->begin_at);
            }
        ];
        $format = array_merge($mdl->attributes(), $format);
        $activities = $mdl->getAll(['zone' => $zone, 'status' => Activity::STATUS_ON], 'list_order asc, id desc', 0, 6, $format);
        $_data = [
            'activities' => $activities,
            'class_array' => $class_array,
        ];

        return $this->render('jl', $_data);
    }

    /**
     * 赠送积分
     * @return type
     */
    public function actionPoints()
    {
        $id = intval($this->_request('id'));
        $sign = PointsRecord::find()
            ->where(['uid' => $this->uid])
            ->andWhere(['point_id' => $id])
            ->andWhere(['>', 'create_at', strtotime('today')])
            ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
            ->asArray()
            ->one();
        if($sign){
            $this->_json(-20001, '今天已经签到过了');
        }
        $user = Yii::$app->user->identity;//当前登录用户
        //附属添加积分行为到登录用户
        $user->attachBehavior('signpoints', [
                'class' =>  PointBehavior::className(),
                'points' => 1,
                'type' =>   $id,
            ]);
        $user->points += Points::SIGNIN_POINTS;
        $ret = $user->save();
        $this->_json($ret['code'], $ret['msg']);

    }

}
