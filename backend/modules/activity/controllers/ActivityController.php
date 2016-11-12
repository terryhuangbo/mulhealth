<?php

namespace backend\modules\activity\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Activity;
use app\modules\team\models\Team;

class ActivityController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $checker_id = '';

    /**
     * 放置需要初始化的信息
     */
    public function init()
    {
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
    }

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
     * 商品列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 商品数据
     */
    public function actionList()
    {

        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Activity();
        $query = $mdl::find();
        $search = $this->_request('search');
        $page = $this->_request('page', 0);
        $pageSize = $this->_request('pageSize', 10);
        $offset = $page * $pageSize;
        $memTb = $mdl::tableName();
        $teamTb = Team::tableName();
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $memTb . '.created_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $memTb . '.created_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['grouptype'])) //时间范围
            {
                $query = $query->andWhere(['group_id' => $search['grouptype']]);
            }
            if (isset($search['filtertype']) && !empty($search['filtercontent'])) {
                if ($search['filtertype'] == 2)//按照商品名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                } elseif ($search['filtertype'] == 1)//按照商品ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer'])) {
                $query = $query->andWhere(['like', $teamTb . '.nickname', trim($search['filtercontent'])]);
            }
            if (isset($search['inputercompany'])) //筛选条件
            {
                $query = $query->andWhere([$teamTb . '.company_id' => $search['inputercompany']]);
            }
            if (isset($search['checkstatus'])) //筛选条件
            {
                $query->andWhere([$memTb . '.check_status' => $search['checkstatus']]);
            }
        }
        //只能是上架，或者下架的产品
        $query->andWhere(['in', 'status', [$mdl::STATUS_ON, $mdl::STATUS_OFF]]);

        $_order_by = 'list_order ASC,id DESC';
        $query_count = clone($query);
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $count = $query_count->count();
        $activityList = ArrayHelper::toArray($userArr, [
            'common\models\Activity' => [
                'id',
                'poster',
                'list_order',
                'aims',
                'way',
                'limitation',
                'details',
                'status',
                'zone' => function ($m) {
                    return yiiParams('activityZone')[$m->zone];
                },
                'status_name' => function ($m) {
                    return Activity::getActivityStatus($m->status);
                },
                'create_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
                'begin_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->begin_at);
                },
                'end_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->end_at);
                },
            ],
        ]);
        $_data = [
            'activityList' => $activityList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 添加商品
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            $_data = [
                'zoneList' => yiiParams('activityZone'),
            ];
            return $this->render('add', $_data);
        }
        $activity = $this->_request('activity', []);
        $activity['begin_at'] = strtotime(getValue($activity, 'begin_at', ''));
        $activity['end_at'] = strtotime(getValue($activity, 'end_at', ''));


        $mdl = new Activity();
        $mdl->setAttributes($activity);
        if (!$mdl->validate())
        {
            $this->_json(-40304, reset($mdl->getFirstErrors()));
        }
        if (!$mdl->save(false))
        {
            $this->_json(-50001, '添加失败');
        }

        $this->_json(20000, '添加成功');
    }

    /**
     * 添加商品
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->_request('id'));
        $activity_info = $this->_request('activity', []);

        //检验参数是否合法
        if (empty($id)) {
            $this->_json(-20001, '商品序号id不能为空');
        }
        //检验商品是否存在
        $activity = Activity::findOne($id);
        if (!$activity) {
            $this->_json(-20002, '商品信息不存在');
        }

        //加载
        if(!$this->isAjax()){
            $_data = [
                'activity' => $activity->toArray(),
                'zoneList' => yiiParams('activityZone'),
            ];
            return $this->render('update', $_data);
        }
        //保存
        $activity_info['begin_at'] = strtotime(getValue($activity_info, 'begin_at', ''));
        $activity_info['end_at'] = strtotime(getValue($activity_info, 'end_at', ''));
        $activity->setAttributes($activity_info);
        if (!$activity->validate())
        {
            $this->_json(-40304, reset($activity->getFirstErrors()));
        }
        if (!$activity->save(false))
        {
            $this->_json(-50001, '添加失败');
        }
        $this->_json(20000, '保存成功');
    }

    /**
     * 改变商品状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->_request('id'));
        $status = intval($this->_request('status'));

        //检验参数是否合法
        if (empty($id)) {
            $this->_json(-20001, '活动id不能为空');
        }

        $activity = Activity::findOne($id);
        if (empty($activity)) {
            $this->_json(-20002, '活动不能为空');
        }

        //保持状态
        $activity->status = $status;
        if (!$activity->validate(['status']))
        {
            $this->_json(-40304, reset($activity->getFirstErrors()));
        }
        if (!$activity->save(false))
        {
            $this->_json(-50001, '添加失败');
        }
        $this->_json(20000, '保存成功');
    }








}
