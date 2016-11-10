<?php

namespace frontend\modules\redeem\controllers;

use common\behavior\PointBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class ActivityController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    /**
     * 关于我们
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionHlj()
    {
        return $this->render('hlj');
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionLn()
    {
        return $this->render('ln');
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionJl()
    {
        return $this->render('jl');
    }

    



}
