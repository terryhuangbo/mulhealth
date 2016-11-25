<?php

namespace backend\modules\product\controllers;

use common\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Project;

/**
 * 产品项目相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class ProjectController extends BaseController
{

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'add',
            'info',
            'save',
            'update',
            'ajax-save',
            'ajax-change-status',
        ];
    }

    /**
     * 产品项目列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 产品项目数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Project();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query->where(['status' => [Project::STATUS_ON, Project::STATUS_OFF]]);
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', 'create_time', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', 'create_time', strtotime($search['uptimeEnd'])]);
            }
            if (!empty($search['name'])) {
                $query = $query->andWhere(['like', 'name', trim($search['name'])]);
            }
            if (isset($search['status'])) //筛选条件
            {
                $query->andWhere(['status' => (int) $search['status']]);
            }
        }
        //只能是上架，或者下架的产品
        $_order_by = 'id DESC';
        $count = $query->count();
        $projectArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $projectList = ArrayHelper::toArray($projectArr, [
            'common\models\Project' => [
                'id',
                'title',
                'pic',
                'tags',
                'status',
                'pic' => function($m){
                    return reset(json_decode($m->pic, true));
                },
                'status_name' => function ($m) {
                    return Project::getStatuses($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_at);
                },
            ],
        ]);
        $_data = [
            'projectList' => $projectList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加产品项目
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            $tags = Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_PROJECT], 'json_encode');
            return $this->render('add', ['tags' => $tags]);
        }
        $mdl = new Project();
        $mdl->load($this->req(), '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加产品项目
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $project_info = $this->req();

        $project = Project::findOne($id);
        //检验参数是否合法
        if (empty($project)) {
            return $this->toJson(-20001, '产品项目信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'project' => $project,
                'tags' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_PROJECT], 'json_encode'),
            ];
            return $this->render('update', $_data);
        }
        //保存
        $project->load($project_info, '');
        if (!$project->validate()) {
            return $this->toJson(-40301, reset($project->getFirstErrors()));
        }
        return $this->toJson($project->save());
    }

    /**
     * 加载项目详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $project = Project::findOne($id);
        //检验参数是否合法
        if (!$project) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $project['update_at'] = date('Y-m-d h:i:s', $project['update_at']);
        $project['create_at'] = date('Y-m-d h:i:s', $project['create_at']);
        $_data = [
            'project' => $project
        ];
        return $this->render('info', $_data);
    }

    /**
     * 改变产品项目状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $project_status = intval($this->req('project_status', 0));
        $mdl = Project::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '项目不存在');
        }
        $mdl->status = $project_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
