<?php

namespace backend\modules\wechat\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\WechatMsg;

/**
 * 后台客服和账号相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
**/
class MsgController extends BaseController
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
     * 客服列表
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 客服数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new WechatMsg();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        if ($search) {
            //客服账号
            if (isset($search['wechatname']))
            {
                $query = $query->andWhere(['wechatname' => $search['wechatname']]);
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
        $wechatArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $wechatList = ArrayHelper::toArray($wechatArr, [
            'common\models\WechatMsg' => [
                'id',
                'open_id',
                'content',
                'service_account',
                'status_name' => function($m){
                    return WechatMsg::getStatuses($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d H:i:s', $m->create_at);
                },
                'reply_time' => function ($m) {
                    if ($m->status == WechatMsg::STATUS_REPLIED)
                    {
                        return date('Y-m-d H:i:s', $m->reply_at);
                    }
                    return '暂无';
                },
                'service_account' => function ($m) {
                    if ($m->status == WechatMsg::STATUS_REPLIED)
                    {
                        return $m->service_account;
                    }
                    return '暂无';
                },
                'reply' => function ($m) {
                    if ($m->status == WechatMsg::STATUS_REPLIED)
                    {
                        return $m->reply;
                    }
                    return '暂无内容';
                },
            ],
        ]);
        $_data = [
            'wechatList' => $wechatList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 加载客服详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $mdl = new WechatMsg();
        //检验参数是否合法
        if (empty($id)) {
            return $this->toJson(-20001, '客服编号id不能为空');
        }

        //检验客服是否存在
        $wechat = $mdl->getOne(['id' => $id]);
        if (!$wechat) {
            $this->toJson(-20003, '客服信息不存在');
        }
        $wechat['create_time'] = date('Y-m-d h:i:s', $wechat['create_at']);
        $wechat['pics'] = !empty($wechat['pics']) ? json_decode($wechat['pics'], false) : [];
        $_data = [
            'wechat' => $wechat
        ];
        return $this->render('info', $_data);
    }

    /**
     * 删除客服
     * @return array
     */
    function actionDel()
    {
        $id = intval($this->req('id', 0));
        $ret = WechatMsg::getDb()->createCommand()->update(
            WechatMsg::tableName(),
            ['status' => WechatMsg::STATUS_OFF],
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
