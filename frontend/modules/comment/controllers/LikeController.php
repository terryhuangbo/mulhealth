<?php

namespace frontend\modules\comment\controllers;

use Yii;
use app\base\BaseController;
use common\models\Like;

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
        $auth    = Yii::$app->wechatAuth;
        $open_id = $auth->wxuser['open_id'];
//        $open_id = getValue($auth, ['wxuser', 'open_id'], '');
        Yii::info($open_id, __METHOD__);
        $like = Like::findOne(['cid' => $cid, 'open_id' => $open_id]);
        if ($like) {
            $ret = $like->delete();
            if ($ret['code'] > 0) {
                return $this->toJson(20001, '取消点赞成功');
            }
            return $this->toJson(-20001, '取消点赞失败');
        } else {
            $like = new Like();
            $like->setAttributes(['cid' => $cid, 'open_id' => $open_id]);
            $ret = $like->save(true);
            if ($ret['code'] > 0) {
                return $this->toJson(20000, '点赞成功');
            }
            return $this->toJson(-20000, '点赞失败' . $open_id);
        }
    }


}
