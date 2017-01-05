<?php

namespace backend\modules\wechat\controllers;

use common\lib\Http;
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
            'reply',
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
                'status',
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
    function actionReply()
    {
        $id = intval($this->req('id'));

        //检验参数是否合法
        if (empty($id)) {
            return $this->toJson(-20001, '客服编号id不能为空');
        }
        //检验客服是否存在
        $msg = WechatMsg::findOne($id);
        if (!$msg) {
            $this->toJson(-20003, '客服信息不存在');
        }

        if ($this->isGet())
        {
            $_data = [
                'msg' => $msg->toArray()
            ];
            return $this->render('reply', $_data);
        }

        $wechat = Yii::$app->wechat;
        $ACC_TOKEN = $wechat->checkAuth();

        $open_id = $msg->open_id;
        $content = $this->req('content');
        $service_account = Yii::$app->user->identity->username . '@' . $wechat->appAccount;

        $msg->scenario = WechatMsg::SCENARIO_REPLY;
        $msg->setAttributes([
            'reply' => $content,
            'service_account' => $service_account,
            'status' => WechatMsg::STATUS_REPLIED,
            'reply_at' => time(),
        ]);
        if (!$msg->validate())
        {
            return $this->toJson(-20002, reset($msg->getFirstErrors()));
        }
        //发送消息
        $data = [
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],
            'customservice' => [
                'kf_account' => $service_account
            ],
        ];
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $ACC_TOKEN;
        $result = json_decode(Http::post($url, json_encode($data)), true);
        if ($result['errcode'] != 0)
        {
            return $this->toJson(-20003, '发送消息失败');
        }

        if (!$msg->save(false))
        {
            return $this->toJson(-20004, '保存消息失败');
        }

        return $this->toJson(20000, '消息发送成功');
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
