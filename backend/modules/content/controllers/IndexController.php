<?php

namespace backend\modules\content\controllers;

use common\models\Goods;
use common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
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
            'add',
            'info',
            'save',
            'update',
            'web',
            'content',
        ];
    }

    /**
     * 路由权限控制
     * @return array
     */

    /**
     * 添加财务
     * @return array
     */
    function actionWeb()
    {
        $meta = new Meta();
        if(!$this->isAjax()){
            return $this->render('web-config', $meta->asArray());
        }
        $configs = Yii::$app->request->post('config', []);
        foreach($configs as $key => $val){
            $meta->setConfig($key, $val);
        }
        return $this->toJson(20000, '保存成功');
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
            $_data['project'] = [
                'https://s.tbcdn.cn/g/fi/act/finder/img/test/1.jpg',
                'https://s.tbcdn.cn/g/fi/act/finder/img/test/2.jpg',
            ];
            return $this->render('content', $_data);
        }
        $configs = Yii::$app->request->post('config', []);

        foreach($configs as $key => $val){
            $meta->setConfig($key, $val);
        }
        return $this->toJson(20000, '保存成功');
    }






}
