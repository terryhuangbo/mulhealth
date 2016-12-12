<?php

namespace frontend\modules\my\controllers;

use common\behavior\PointBehavior;
use common\lib\Tools;
use common\models\Cell;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class CellController extends BaseController
{

    public $enableCsrfValidation = false;

    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $uid = Yii::$app->user->identity->uid;
        $cellList = (new Cell())->getAll(
            ['uid' => $uid, 'status' => Cell::STATUS_ON],
            'report_at desc',
            1,
            4
        );

        array_walk($cellList, function(&$val, $i){
            $val['pics'] = Tools::toArray($val['pics']);
            $val['report_at'] = getDiffDate($val['report_at']);
        });
        $_data = [
            'cellList' => $cellList
        ];
        return $this->render('index', $_data);
    }

    /**
     * 首页-未登录
     * @return type
     */
    public function actionDetail()
    {

        $_data = [];
        return $this->render('detail', $_data);
    }




}
