<?php

namespace frontend\modules\product\controllers;

use common\lib\Tools;
use common\models\Project;
use common\models\Tag;
use app\base\BaseController;


class ProjectController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
     * 项目列表
     * @return string
     */
    public function actionItems()
    {
        $orderBy = $this->req('order');
        $tags = $this->req('tags');
        $from = $this->req('from');
        $to = $this->req('to');
        //获取（筛选）列表
        $query = Project::find()->where('1=1');
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
        $projectList = $query->asArray()->all();
        foreach ($projectList as $key => &$value) {
            $value['pic'] = reset(json_decode($value['pic']));
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }
        $_data = [
            'projectList' => $projectList,
            'tagList' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_PROJECT]),
            'timeFilters' => Tools::getTimeFilter(),
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }

    /**
     * 项目详情
     * @return string
     */
    public function actionDetail()
    {
        $id = $this->req('id');
        $project = (new Project)->getOne(['id' => $id]);
        $project['pic'] = json_decode($project['pic'], true);
        if (empty($project)) {
            return $this->redirect('product/projec/items');
        }
        $_data = [
            'project' => $project
        ];
        return $this->render('detail', $_data);
    }

}
