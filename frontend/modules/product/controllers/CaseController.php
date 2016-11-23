<?php

namespace frontend\modules\product\controllers;

use common\models\Cases;
use Yii;
use app\base\BaseController;


class CaseController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
     * 案例列表
     * @return string
     */
    public function actionItems()
    {
        $orderBy = trim($this->req('order', ''));
        $tags = trim($this->req('tags', ''));
        $query = Cases::find();
        $query->andFilterWhere(['like', 'tags', $tags]);
        if (!empty($orderBy)) {
            $query->orderBy($orderBy);
        }
        $caseList = $query->asArray()->all();
        foreach ($caseList as $key => &$value) {
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }

        $_data = [
            'caseList' => $caseList,
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }



}
