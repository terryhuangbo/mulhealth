<?php

namespace frontend\modules\comment\controllers;

use Yii;
use app\base\BaseController;
use common\models\Like;

class LikeController extends BaseController
{

    public $enableCsrfValidation = false;
    public $_uncheck = [
        'add',
    ];

    /**
     * 添加/取消点赞
     * @return type
     */
    public function actionAdd()
    {
        $cid = $this->req('cid');
        $open_id = 1234;//TODO 获取open_id
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
