<?php

namespace backend\modules\customer\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\CustomerGo;

/**
 * 客户拜访相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class GoController extends BaseController
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
     * 客户拜访列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 客户拜访数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new CustomerGo();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
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
        $customArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $customList = ArrayHelper::toArray($customArr, [
            'common\models\CustomerGo' => [
                'id',
                'name',
                'mobile',
                'next_plan',
                'status',
                'purpose',
                'result',
                'note',
                'status_name' => function ($m) {
                    return CustomerGo::getStatuses($m->status);
                },
                'call_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->call_at);
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
            'customerList' => $customList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加客户拜访
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $mdl = new CustomerGo();
        $param = $this->req();
        $param['call_at'] = strtotime($param['call_at']);
        $mdl->load($param, '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加客户拜访
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $custom_info = $this->req();

        $customer = CustomerGo::findOne($id);
        //检验参数是否合法
        if (empty($customer)) {
            return $this->toJson(-20001, '客户拜访信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'customer' => $customer,
            ];
            return $this->render('update', $_data);
        }
        //保存
        $custom_info['call_at'] = strtotime($custom_info['call_at']);
        $customer->load($custom_info, '');
        if (!$customer->validate()) {
            return $this->toJson(-40301, reset($customer->getFirstErrors()));
        }
        return $this->toJson($customer->save());
    }

    /**
     * 加载项目详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $customer = CustomerGo::findOne($id);
        //检验参数是否合法
        if (!$customer) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $customer['update_at'] = date('Y-m-d h:i:s', $customer['update_at']);
        $customer['create_at'] = date('Y-m-d h:i:s', $customer['create_at']);
        $customer['call_at'] = date('Y-m-d h:i:s', $customer['call_at']);
        $_data = [
            'customer' => $customer
        ];

        return $this->render('info', $_data);
    }

    /**
     * 改变客户拜访状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $status = intval($this->req('status', 0));
        $mdl = CustomerGo::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '项目不存在');
        }
        $mdl->status = $status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
