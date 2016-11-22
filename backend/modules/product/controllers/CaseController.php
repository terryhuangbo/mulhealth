<?php

namespace backend\modules\product\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\lib\Tools;
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
        $query->where(['status' => [Cases::STATUS_ON, Cases::STATUS_ON]]);
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
        $casesArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $casesList = ArrayHelper::toArray($casesArr, [
            'common\models\Cases' => [
                'id',
                'title',
                'pic',
                'tags',
                'status',
                'pic' => function($m){
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
            'caseList' => $casesList,
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
            return $this->render('add');
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
        $cases_info = $this->req('cases', []);

        //检验参数是否合法
        if (empty($id)) {
            return $this->toJson(-20001, '产品案例序号id不能为空');
        }

        //检验产品案例是否存在
        $mdl = new Cases();
        $cases = Cases::findOne($id);
        if (!$cases) {
            return $this->toJson(-20002, '产品案例信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'cases' => $cases
            ];
            return $this->render('update', $_data);
        }
        //保存
        $cases_info['id'] = $id;
        $cases_info['images'] = getValue($cases_info, 'thumb', '');
        $ret = $mdl->saveCases($cases_info);
        return $this->toJson($ret['code'], $ret['msg']);
    }

    /**
     * 改变产品案例状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $cases_status = $this->req('cases_status', 0);
        $mdl = new Cases();
        $update_info = [
            'id' => $id,
            'status' => $cases_status,
        ];
        $ret = $mdl->saveCases($update_info);
        return $this->toJson($ret['code'], $ret['msg']);
    }

}
