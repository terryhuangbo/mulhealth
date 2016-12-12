<?php

namespace backend\modules\cell\controllers;

use common\lib\Tools;
use common\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Cell;

/**
 * 细胞相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class CellController extends BaseController
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
     * 细胞列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 细胞数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Cell();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query->where(['status' => [Cell::STATUS_ON, Cell::STATUS_OFF]]);
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
        //只能是上架，或者下架的
        $_order_by = 'id DESC';
        $count = $query->count();
        $cellArr = $query
            ->with(['user'])
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $cellList = ArrayHelper::toArray($cellArr, [
            'common\models\Cell' => [
                'id',
                'uid',
                'description',
                'status',
                'user_name' => function($m){
                    return getValue($m, ['user', 'name']);
                },
                'pics' => function($m){
                    return Tools::toArray($m->pics, true);
                },
                'status_name' => function ($m) {
                    return Cell::getStatuses($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d H:i:s', $m->create_at);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d H:i:s', $m->update_at);
                },
            ],
        ]);
        $_data = [
            'cellList' => $cellList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加细胞
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $mdl = new Cell();
        $param = $this->req();
        $param['report_at'] = strtotime($param['report_at']);
        $param['pics'] = Tools::toJson($this->req('pics', []));
        $mdl->load($param, '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加细胞
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $cell_info = $this->req();

        $cell = Cell::findOne($id);
        //检验参数是否合法
        if (empty($cell)) {
            return $this->toJson(-20001, '细胞信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'cell' => $cell,
            ];
            return $this->render('update', $_data);
        }
        //保存
        $cell_info['report_at'] = strtotime($cell_info['report_at']);
        $cell->load($cell_info, '');
        if (!$cell->validate()) {
            return $this->toJson(-40301, reset($cell->getFirstErrors()));
        }
        return $this->toJson($cell->save());
    }

    /**
     * 加载细胞详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $cell = Cell::findOne($id);
        //检验参数是否合法
        if (!$cell) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $cell['update_at'] = date('Y-m-d H:i:s', $cell['update_at']);
        $cell['create_at'] = date('Y-m-d H:i:s', $cell['create_at']);
        $_data = [
            'cell' => $cell
        ];
        return $this->render('info', $_data);
    }

    /**
     * 改变细胞状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $cell_status = intval($this->req('cell_status', 0));
        $mdl = Cell::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '细胞不存在');
        }
        $mdl->status = $cell_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
