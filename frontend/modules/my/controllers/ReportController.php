<?php

namespace frontend\modules\my\controllers;

use common\behavior\PointBehavior;
use common\models\Report;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class ReportController extends BaseController
{


    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $_data = [];
        return $this->render('index', $_data);
    }

    /**
     * 首页-未登录
     * @return type
     */
    public function actionUpload()
    {
        $_data = [];
        return $this->render('upload', $_data);
    }

    /**
     * 首页-未登录
     * @return type
     */
    public function actionAdd()
    {
        if(!$this->isAjax()){
            $pic = $this->req('pic');
            if (empty($pic))
            {
                return '必须上传图片！';
            }
            $_data = [
                'pic' => $pic
            ];
            return $this->render('add', $_data);
        }

        $param = $this->req();
        $param['uid'] = Yii::$app->user->identity->uid;

        $report = new Report();
        $report->setAttributes($param);
        if (!$report->validate())
        {
            return $this->toJson(-50001, reset($report->getFirstErrors()));
        }
        $ret = $report->save();
        if ($ret['code'] < 0)
        {
            Yii::warning(logUser() . "上传健康报告失败！", __METHOD__);
            return $this->toJson(-50002, '添加失败');
        }

        Yii::info(logUser() . "上传健康报告成功！报告ID:{$report->id}", __METHOD__);
        return $this->toJson($ret);
    }



}
