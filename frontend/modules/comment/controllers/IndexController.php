<?php

namespace frontend\modules\comment\controllers;

use Yii;
use app\base\BaseController;
use common\models\Comment;

/**
 * 评论，点赞功能
 * 评论每个用户每天有一定的数量限制，回复评论也有限制
*/
class IndexController extends BaseController
{
    public $enableCsrfValidation = true;
    public $_uncheck = [
        'index',
        'release',
    ];
    /**
     * 同一用户一天最多评论条数
     */
    private $_maxComment = 50;
    /**
     * 同一用户针对同一个评论最多回复条数
     */
    private $_maxReplay = 20;


    /**
     * 评论列表
     * @return type
     */
    public function actionIndex()
    {
        $with = [
            'user'
        ];
        $comments = (new Comment())->getRelationAll(
            '*',
            ['status' => Comment::STATUS_ON, 'pid' => 0],
            ['with' => $with],
            'id DESC',
            0,
            5
        );
        array_walk($comments, function (&$val, $key){
            $val['create_at'] = date('Y/m/d H:i:s', $val['create_at']);
            $val['avatar'] = getValue($val, ['user', 'avatar'], '/images/tx.png');
            $val['nick'] = getValue($val, ['user', 'nick'], '游客');
        });
        $_data = [
            'comments' => $comments,
        ];

        return $this->render('index', $_data);
    }

    /**
     * 首页-未登录
     * @return type
     */
    public function actionRelease()
    {
        if ($this->isGet()) {
            $_data = [
                'pid' => $this->req('pid', 0)
            ];
            return $this->render('release', $_data);
        }
        $param = $this->req();
        $param['uid'] = !Yii::$app->user->isGuest ? Yii::$app->user->identity->uid : 0;
        $param['pid'] = intval($this->req('pid'));
        $param['open_id'] = '1234';//TODO 获取open_id

        //检查是否可以评论
        if (!$this->can($param)) {
            return $this->toJson(-43002, '你的' . $param['pid'] === 0 ? '评论' : '回复' . '已达到数量限制');
        }

        $mdl = new Comment();
        $mdl->setAttributes($param);
        if (!$mdl->validate()) {
            return $this->toJson(-43001, reset($mdl->getFirstErrors()));
        }
        $ret = $mdl->save(false);
        if ($ret['code'] < 0) {
            return $this->toJson($ret);
        }
        return $this->redirect('/comment/index/index');
    }

    /**
     * 校验是否可以发表评论/回复
     * @return bool
     */
    protected function can($param)
    {
        if (!isset($param['open_id'], $param['pid'])) {
            return false;
        }

        $mdl = new Comment();

        //评论的情况
        if (intval($param['pid']) === 0) {
            $num = $mdl->getCount([
                    'and',
                    ['open_id' => $param['open_id']],
                    ['pid' => $param['pid']],
                    ['between', 'create_at', strtotime('today'), time()]]
            );
            return $num < $this->_maxComment;
        }
        //回复的情况
        if (intval($param['pid']) > 0) {
            $num = $mdl->getCount([
                    'and',
                    ['open_id' => $param['open_id']],
                    ['pid' => $param['pid']]]
            );
            return $num < $this->_maxReplay;
        }

        return false;
    }


}
