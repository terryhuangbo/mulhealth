<?php

namespace backend\modules\comment\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Comment;

/**
 * 后台评论和账号相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
**/
class CommentController extends BaseController
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
            'export',
            'info',
            'update',
            'del',
        ];
    }

    /**
     * 评论列表
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 评论数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Comment();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query = $query->andWhere(['status' => Comment::STATUS_ON]);
        if ($search) {
            //评论账号
            if (isset($search['commentname']))
            {
                $query = $query->andWhere(['commentname' => $search['commentname']]);
            }
            //注册时间
            if (isset($search['regtimeStart'])) 
            {
                $query = $query->andWhere(['>', 'reg_time', strtotime($search['regtimeStart'])]);
            }
            if (isset($search['regtimeEnd'])) 
            {
                $query = $query->andWhere(['<', 'reg_time', strtotime($search['regtimeEnd'])]);
            }
            //最近登录
            if (isset($search['logtimeStart'])) 
            {
                $query = $query->andWhere(['>', 'login_time', strtotime($search['logtimeStart'])]);
            }
            if (isset($search['logtimeEnd'])) 
            {
                $query = $query->andWhere(['<', 'login_time', strtotime($search['logtimeEnd'])]);
            }
        }

        $_order_by = 'id DESC';
        $count = $query->count();
        $commentArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $commentList = ArrayHelper::toArray($commentArr, [
            'common\models\Comment' => [
                'id',
                'pid',
                'id',
                'open_id',
                'content',
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_at);
                },
            ],
        ]);
        $_data = [
            'commentList' => $commentList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 加载评论详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $mdl = new Comment();
        //检验参数是否合法
        if (empty($id)) {
            return $this->toJson(-20001, '评论编号id不能为空');
        }

        //检验评论是否存在
        $comment = $mdl->getOne(['id' => $id]);
        if (!$comment) {
            $this->toJson(-20003, '评论信息不存在');
        }
        $comment['create_time'] = date('Y-m-d h:i:s', $comment['create_at']);
        $comment['pics'] = !empty($comment['pics']) ? json_decode($comment['pics'], false) : [];
        $_data = [
            'comment' => $comment
        ];
        return $this->render('info', $_data);
    }

    /**
     * 删除评论
     * @return array
     */
    function actionDel()
    {
        $id = intval($this->req('id', 0));
        $ret = Comment::getDb()->createCommand()->update(
            Comment::tableName(),
            ['status' => Comment::STATUS_OFF],
            [
                'or',
                ['pid' => 0, 'id' => $id],
                ['pid' => $id],
            ]
        )->execute();
        if ($ret === false)
        {
            return $this->toJson(-20001, '删除失败');
        }
        return $this->toJson(20000, '删除成功');
    }

}
