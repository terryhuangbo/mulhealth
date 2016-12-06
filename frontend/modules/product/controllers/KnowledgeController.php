<?php

namespace frontend\modules\product\controllers;

use common\lib\Tools;
use common\models\Knowledge;
use common\models\Tag;
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
        $orderBy = $this->req('order');
        $tags = $this->req('tags');
        $from = $this->req('from');
        $to = $this->req('to');
        //获取（筛选）列表
        $query = Knowledge::find()->where('1=1');
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
        $knowledgeList = $query->asArray()->all();
        foreach ($knowledgeList as $key => &$value) {
            $value['pic'] = reset(json_decode($value['pic']));
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }
        $_data = [
            'knowledgeList' => $knowledgeList,
            'tagList' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_KNOWLEDGE]),
            'timeFilters' => Tools::getTimeFilter(),
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }

    /**
     * 知识详情
     * @return string
     */
    public function actionDetail()
    {
        $id = $this->req('id');
        $knowledge = (new Knowledge)->getOne(['id' => $id]);
        $knowledge['pic'] = json_decode($knowledge['pic'], true);
        if (empty($knowledge)) {
            return $this->redirect('product/projec/items');
        }
        $_data = [
            'knowledge' => $knowledge
        ];
        return $this->render('detail', $_data);
    }

}
