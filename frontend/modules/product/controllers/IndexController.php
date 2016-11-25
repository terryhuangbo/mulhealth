<?php

namespace frontend\modules\product\controllers;

use Yii;
use app\base\BaseController;
use common\models\Cases;
use common\models\Project;
use common\models\Knowledge;


class IndexController extends BaseController
{

    public $enableCsrfValidation = false;
    public $_pageNum = 5;//首页默认展示条数

    /**
     * 首页-未登录
     * @return type
     */
    public function actionIndex()
    {
        $mdlArr = [new Cases, new Project, new Knowledge];
        $keyArr = ['cases', 'project', 'knowledge'];
        foreach ($mdlArr as $key => $mdl) {
            $data[$keyArr[$key]] = $mdl::find()
                ->select(['id', 'pic', 'title'])
                ->orderBy('id DESC')
                ->limit($this->_pageNum)
                ->asArray()
                ->all();
            array_walk($data[$keyArr[$key]], function (&$v, $k){
                $v['pic'] =  json_decode($v['pic'], true);
            });
        }
        $_data = [
            'data' => $data
        ];
        return $this->render('index', $_data);
    }

    /**
     * 首页-登录
     * @return type
     */
    public function actionIndexLogin()
    {
        $_data = [];
        return $this->render('index-login', $_data);
    }



}
