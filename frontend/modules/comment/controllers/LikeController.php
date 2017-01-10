<?php

namespace frontend\modules\comment\controllers;

use Yii;
use app\base\BaseController;
use common\models\Like;
use yii\helpers\VarDumper;

class LikeController extends BaseController
{

    public $layout = false;
    public $enableCsrfValidation = false;

    /**
     * 添加/取消点赞
     * @return type
     */
    public function actionAdd()
    {
        $cid = $this->req('cid');
        $session = Yii::$app->session;
        $open_id = $session->get('openid');
        $wxuser = $session->get('wxuser');
        Yii::info(VarDumper::export($wxuser), __METHOD__);
        $like = Like::findOne(['cid' => $cid, 'open_id' => $open_id]);
        if ($like)
        {
            $ret = $like->delete();
            if ($ret['code'] > 0)
            {
                return $this->toJson(20001, '取消点赞成功');
            }
            return $this->toJson(-20001, '取消点赞失败');
        } else
        {
            $like = new Like();
            $like->setAttributes(['cid' => $cid, 'open_id' => $open_id]);
            $ret = $like->save(false);
            if ($ret['code'] > 0)
            {
                return $this->toJson(20000, '点赞成功');
            }
            return $this->toJson(-20000, '点赞失败' . $open_id);
        }
    }


}
