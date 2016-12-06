<?php

namespace frontend\modules\product\controllers;

use common\lib\Tools;
use common\models\Cases;
use common\models\Tag;
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
        $orderBy = $this->req('order');
        $tags = $this->req('tags');
        $from = $this->req('from');
        $to = $this->req('to');
        //获取（筛选）列表
        $query = Cases::find()->where('1=1');
        if (isset($tags)) {
            $query->andWhere(['like', 'tags', $tags]);
        }
        if (isset($from, $to)) {
            $query->andWhere(['between', 'create_at', strtotime($from), strtotime($to)]);
        }
        if (isset($orderBy)) {
            $query->orderBy($orderBy);
        }else{
            $query->orderBy('id desc');
        }
        $caseList = $query->asArray()->all();
        foreach ($caseList as $key => &$value) {
            $value['pic'] = reset(json_decode($value['pic']));
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }
        $_data = [
            'caseList' => $caseList,
            'tagList' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_CASE]),
            'timeFilters' => Tools::getTimeFilter(),
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }

    /**
     * 案例详情
     * @return string
     */
    public function actionDetail()
    {
        $id = $this->req('id');
        $case = (new Cases)->getOne(['id' => $id]);
        $case['pic'] = json_decode($case['pic'], true);
        if (empty($case)) {
            return $this->redirect('product/projec/items');
        }
        $_data = [
            'case' => $case
        ];
        return $this->render('detail', $_data);
    }

}
