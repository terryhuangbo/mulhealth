<?php

namespace frontend\modules\comment\controllers;

use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Comment;


class IndexController extends BaseController
{

    public $enableCsrfValidation = true;
    public $_uncheck = [
        'index',
        'release',
    ];



    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $with = [
            'user'
        ];
        $comments = (new Comment())->getRelationAll(
            '*',
            ['status' => Comment::STATUS_ON],
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
        $mdl = new Comment();
        $param = $this->req();
        $param['uid'] = !Yii::$app->user->isGuest ? Yii::$app->user->identity->uid : 0;
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




}
