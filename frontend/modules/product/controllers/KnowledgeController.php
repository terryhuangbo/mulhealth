<?php

namespace frontend\modules\product\controllers;

use common\models\Knowledge;
use Yii;
use app\base\BaseController;


class KnowledgeController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
     * 知识列表
     * @return string
     */
    public function actionItems()
    {
        $orderBy = trim($this->req('order', ''));
        $tags = trim($this->req('tags', ''));
        $query = Knowledge::find();
        $query->andFilterWhere(['like', 'tags', $tags]);
        if (!empty($orderBy)) {
            $query->orderBy($orderBy);
        }
        $knowledgeList = $query->asArray()->all();
        foreach ($knowledgeList as $key => &$value) {
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }
        $_data = [
            'knowledgeList' => $knowledgeList,
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }



}
