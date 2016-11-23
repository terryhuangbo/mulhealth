<?php

namespace frontend\modules\product\controllers;

use common\models\Project;
use Yii;
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
        $orderBy = trim($this->req('order', ''));
        $tags = trim($this->req('tags', ''));
        $query = Project::find();
        $query->andFilterWhere(['like', 'tags', $tags]);
        if (!empty($orderBy)) {
            $query->orderBy($orderBy);
        }
        $projectList = $query->asArray()->all();
        foreach ($projectList as $key => &$value) {
            $value['create_at'] = date('Y/m/d H:i:s', $value['create_at']);
        }
        $_data = [
            'projectList' => $projectList,
        ];
        if (!$this->isAjax()) {
            return $this->render('index', $_data);
        }
        return $this->toJson(20000, '', $_data);
    }



}
