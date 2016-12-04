<?php

namespace backend\modules\tag\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Tag;

/**
 * 产品标签相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class TagController extends BaseController
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
            'del',
            'ajax-change-status',
        ];
    }

    /**
     * 产品标签列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 产品标签数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Tag();
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
        $tagArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $tagList = ArrayHelper::toArray($tagArr, [
            'common\models\Tag' => [
                'id',
                'name',
                'type_name' => function ($m) {
                    return Tag::getTypes($m->type);
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
            'tagList' => $tagList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加产品标签
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){

            return $this->render('add', ['types' => Tag::getTypes()]);
        }
        $mdl = new Tag();
        $mdl->load($this->req(), '');
        if (!$mdl->validate()) {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

    /**
     * 添加产品标签
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $tag_info = $this->req();

        $tag = Tag::findOne($id);
        //检验参数是否合法
        if (empty($tag)) {
            return $this->toJson(-20001, '产品标签信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'tag' => $tag
            ];
            return $this->render('update', $_data);
        }
        //保存
        $tag->load($tag_info, '');
        if (!$tag->validate()) {
            return $this->toJson(-40301, reset($tag->getFirstErrors()));
        }
        return $this->toJson($tag->save());
    }

    /**
     * 加载标签详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $tag = Tag::findOne($id);
        //检验参数是否合法
        if (!$tag) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $tag['update_at'] = date('Y-m-d h:i:s', $tag['update_at']);
        $tag['create_at'] = date('Y-m-d h:i:s', $tag['create_at']);
        $_data = [
            'tag' => $tag
        ];
        return $this->render('info', $_data);
    }

    /**
     * 改变产品标签状态
     * @return array
     */
    function actionDel()
    {
        $id = intval($this->req('id', 0));
        $mdl = Tag::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(20001, '删除成功');
        }
        return $this->toJson($mdl->delete());
    }

    /**
     * 改变产品标签状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $tag_status = intval($this->req('tag_status', 0));
        $mdl = Tag::findOne($id);
        if (!$mdl)
        {
            return $this->toJson(-40301, '标签不存在');
        }
        $mdl->status = $tag_status;
        if (!$mdl->validate())
        {
            return $this->toJson(-40301, reset($mdl->getFirstErrors()));
        }
        return $this->toJson($mdl->save());
    }

}
