<?php

namespace backend\modules\content\controllers;

use Yii;
use app\base\BaseController;
use common\models\Meta;

class IndexController extends BaseController
{
    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'content',
        ];
    }

    /**
     * 添加财务
     * @return array
     */
    function actionContent()
    {
        $meta = new Meta();
        if(!$this->isAjax()){
            $_data = $meta->asArray();
            $_data['banners'] = !empty($_data['banners']) ? json_decode($_data['banners'], true) : [];
            return $this->render('content', $_data);
        }
        $configs = Yii::$app->request->post('config', []);
        foreach($configs as $key => $val){
            $meta->setConfig($key, $val);
        }
        return $this->toJson(20000, '保存成功');
    }






}
