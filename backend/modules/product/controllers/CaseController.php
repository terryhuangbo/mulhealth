<?php

namespace backend\modules\product\controllers;

use common\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Cases;

/**
 * 产品案例相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class CaseController extends BaseController
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
     * 产品案例列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 产品案例数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Cases();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query->where(['status' => [Cases::STATUS_ON, Cases::STATUS_OFF]]);
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
        $caseArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $caseList = ArrayHelper::toArray($caseArr, [
            'common\models\Cases' => [
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
                    return Cases::getStatuses($m->status);
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
            'caseList' => $caseList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加产品案例
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            $tags = Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_CASE], 'json_encode');
            return $this->render('add', ['tags' => $tags]);
        }
        $mdl = new Cases();
        $mdl->load($this->req(), '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加产品案例
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $case_info = $this->req();

        $case = Cases::findOne($id);
        //检验参数是否合法
        if (empty($case)) {
            return $this->toJson(-20001, '产品案例信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'case' => $case,
                'tags' => Tag::getTags([Tag::TYPE_ALL, Tag::TYPE_CASE], 'json_encode'),
            ];
            return $this->render('update', $_data);
        }
        //保存
        $case->load($case_info, '');
        if (!$case->validate()) {
            return $this->toJson(-40301, reset($case->getFirstErrors()));
        }
        return $this->toJson($case->save());
    }

    /**
     * 加载案例详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $case = Cases::findOne($id);
        //检验参数是否合法
        if (!$case) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $case['update_at'] = date('Y-m-d h:i:s', $case['update_at']);
        $case['create_at'] = date('Y-m-d h:i:s', $case['create_at']);
        $_data = [
            'case' => $case
        ];
        return $this->render('info', $_data);
    }

    /**
     * 改变产品案例状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $case_status = intval($this->req('case_status', 0));
        $mdl = Cases::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '案例不存在');
        }
        $mdl->status = $case_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
