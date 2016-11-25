<?php

namespace backend\modules\product\controllers;

use common\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Knowledge;

/**
 * 产品知识相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class KnowledgeController extends BaseController
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
     * 产品知识列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 产品知识数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Knowledge();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query->where(['status' => [Knowledge::STATUS_ON, Knowledge::STATUS_OFF]]);
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
        $knowledgeArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $knowledgeList = ArrayHelper::toArray($knowledgeArr, [
            'common\models\Knowledge' => [
                'id',
                'title',
                'pic',
                'tags',
                'status',
                'pic' => function($m){
                    if (($pic = json_decode($m->pic, true)) !== null) {
                        return reset($pic);
                    }
                    return $m->pic;
                },
                'status_name' => function ($m) {
                    return Knowledge::getStatuses($m->status);
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
            'knowledgeList' => $knowledgeList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加产品知识
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            $tags = Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_KNOWLEDGE], 'json_encode');
            return $this->render('add', ['tags' => $tags]);
        }
        $mdl = new Knowledge();
        $mdl->load($this->req(), '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加产品知识
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $knowledge_info = $this->req();

        $knowledge = Knowledge::findOne($id);
        //检验参数是否合法
        if (empty($knowledge)) {
            return $this->toJson(-20001, '产品知识信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'knowledge' => $knowledge,
                'tags' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_KNOWLEDGE], 'json_encode'),
            ];
            return $this->render('update', $_data);
        }
        //保存
        $knowledge->load($knowledge_info, '');
        if (!$knowledge->validate()) {
            return $this->toJson(-40301, reset($knowledge->getFirstErrors()));
        }
        return $this->toJson($knowledge->save());
    }

    /**
     * 加载知识详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $knowledge = Knowledge::findOne($id);
        //检验参数是否合法
        if (!$knowledge) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $knowledge['update_at'] = date('Y-m-d h:i:s', $knowledge['update_at']);
        $knowledge['create_at'] = date('Y-m-d h:i:s', $knowledge['create_at']);
        $_data = [
            'knowledge' => $knowledge
        ];
        return $this->render('info', $_data);
    }

    /**
     * 改变产品知识状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $knowledge_status = intval($this->req('knowledge_status', 0));
        $mdl = Knowledge::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '知识不存在');
        }
        $mdl->status = $knowledge_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
