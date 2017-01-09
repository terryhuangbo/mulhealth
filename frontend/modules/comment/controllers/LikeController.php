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
        $auth = Yii::$app->wechatAuth;
        $open_id = $auth->wxuser['open_id'];
//        echo $open_id;exit;
//        $open_id = getValue($auth, ['wxuser', 'open_id'], '12345');
//        $open_id = isset($auth->wxuser['open_id']) ? $auth->wxuser['open_id'] : 12347;
        $like = Like::findOne(['cid' => $cid, 'open_id' => $open_id]);
        if ($like) {
            return $this->toJson($like->delete());
        }else{
            $like = new Like();
            $like->setAttributes(['cid' => $cid, 'open_id' => $open_id]);
            return $this->toJson($like->save());
        }
    }


}
