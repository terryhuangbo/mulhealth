<?php

namespace backend\modules\report\controllers;

use common\lib\Tools;
use common\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Report;

/**
 * 细胞相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class ReportController extends BaseController
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
        $mdl = new Report();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
//        $query->where(['status' => [Report::STATUS_ON, Report::STATUS_OFF]]);
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
        $reportArr = $query
            ->with(['user'])
            ->offset($offset)
            ->limit($pageSize)
            ->orderBy($_order_by)
            ->all();
        $reportList = ArrayHelper::toArray($reportArr, [
            'common\models\Report' => [
                'id',
                'uid',
                'location',
                'age',
                'status',
                'weight',
                'height',
                'user_name' => function($m){
                    return getValue($m, ['user', 'name']);
                },
                'status_name' => function ($m) {
                    return Report::getStatuses($m->status);
                },
                'tj_time' => function ($m) {
                    return date('Y-m-d H:i:s', $m->time);
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
            'reportList' => $reportList,
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
        $mdl = new Report();
        $param = $this->req();
        $param['time'] = strtotime($param['time']);
        $param['age'] = intval($param['age']);
        $param['height'] = floatval($param['height']);
        $param['weight'] = floatval($param['weight']);
        $data = [];
        foreach ($param as $key => $val){
            if(is_array($val)){
                unset($param[$key]);
                if(!empty($val)){
                    $data[$key] = $val;
                }
            }
        }
        $param['data'] = json_encode($data);
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
        $param = $this->req();

        $report = Report::findOne($id);
        //检验参数是否合法
        if (empty($report)) {
            return $this->toJson(-20001, '细胞信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'report' => $report,
                'data' => json_decode($report->data, true),
            ];
            return $this->render('update', $_data);
        }
        //保存
        $param['time'] = strtotime($param['time']);
        $param['age'] = intval($param['age']);
        $param['height'] = floatval($param['height']);
        $param['weight'] = floatval($param['weight']);
        $data = [];
        foreach ($param as $key => $val){
            if(is_array($val)){
                unset($param[$key]);
                if(!empty($val)){
                    $data[$key] = $val;
                }
            }
        }
        $param['data'] = json_encode($data);
        $report->load($param, '');
        if (!$report->validate()) {
            return $this->toJson(-40301, reset($report->getFirstErrors()));
        }
        return $this->toJson($report->save());
    }

    /**
     * 查看细胞详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $report = Report::findOne($id);
        //检验参数是否合法
        if (empty($report)) {
            return $this->toJson(-20001, '细胞信息不存在');
        }
        $_data = [
            'report' => $report,
            'data' => json_decode($report->data, true),
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
        $report_status = intval($this->req('report_status', 0));
        $mdl = Report::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '细胞不存在');
        }
        $mdl->status = $report_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
