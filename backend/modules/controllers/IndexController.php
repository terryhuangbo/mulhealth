<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\UserForm;
use app\modules\team\models\RolePrivilege;
use app\modules\team\models\Privilege;

class IndexController extends Controller
{
    public $enableCsrfValidation = true;//yii默认表单csrf验证，如果post不带改参数会报错！
    public $layout = 'layout';

    /**
     * @用户授权规则
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
                            'edit',
                            'index',
                            'users',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @验证码独立操作
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 后台导航输出
     * 输出格式为json
     * 如果路由不在数据库里，这里无法做权限控制的
     * 添加权限->配置角色->配置用户所属角色->实现权限控制
     * 默认的方法，例如ajax加载之类是不做权限控制的，因此理论上是可以绕过权限的
     */
    public function roleArr()
    {
        //获取用户路由权限
        $role_id = Yii::$app->user->identity->role_id;
        $routeArr = [];
        $role_id  = 1;
        if ($role_id === 1)
        { //超级管理不检查
            $isadmin = true;
        }
        else
        {
            $isadmin = false;
            $privilege = RolePrivilege::find()->select('privilege_id')->where(['role_id' => $role_id])->asArray()->all();
            $roteidArr = [];
            foreach ($privilege as $p)
            {
                $roteidArr[] = $p['privilege_id'];
            }
            $userRoute = Privilege::find()->select('route')->where(['id' => $roteidArr])->asArray()->all();

            foreach ($userRoute as $route)
            {
                $routeArr[] = $route['route'];
            }
        }
        //权限路由配置
        $menu = $this->_getMenuArr();

        //重新处理菜单
        $navArr = [];
        $topmenu = [];
        foreach ($menu as $key => $item)
        {
            $show = false;
            $topArr = [];
            $menuArr = [];
            $homepage = '';
            foreach ($item as $menutxt => $nav)
            {
                if ($menutxt != 'top')
                {
                    $arr = [];
                    foreach ($nav as $m)
                    {
                        foreach ($m as $text => $href)
                        {
                            //该分组显示
                            if (!in_array($href, $routeArr) && !$isadmin)
                            {
                                continue;
                            }
                            $show = true;
                            $arr['items'][] = [
                                'id' => $href,
                                'text' => $text,
                                'href' => Yii::$app->urlManager->createUrl($href)
                            ];
                            if (!$homepage)
                            {
                                $homepage = $href;
                            }
                        }
                    }
                    if ($show && $arr)
                    {
                        $arr['text'] = $menutxt;
                        $menuArr['menu'][] = $arr;
                    }
                }
                // top
                else
                {
                    foreach ($nav as $text => $icon)
                    {
                        $topArr = ['text' => $text, 'icon' => $icon];
                    }
                }
            }
            if ($show)
            {
                $menuArr['id'] = $key;
                $menuArr['homePage'] = $homepage;
                $navArr[] = $menuArr;
                $topmenu[] = $topArr;
            }
        }

        return ['topmenu' => $topmenu, 'menu' => json_encode($navArr)];
    }

    /**
     * 获取菜单列表
     * @return array
     */
    private function _getMenuArr()
    {
        return require_once (Yii::$aliases['@menu']);
    }

    /**
     * @return string 后台默认页面
     */
    public function actionIndex()
    {
        return $this->render('index', $this->roleArr());
    }

    /**
     * @return string|\yii\web\Response 用户登录
     */
    public function actionLogin()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->login())
            {
                //查询未读消息
                $count = 0;
                $session = Yii::$app->session;
                $session->set('msg', $count);

                return $this->redirect(['/']);
            }
            else
            {
                return $this->render('login', ['model' => $model]);
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * @后台退出页面
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();

    }

    public function actionMenu()
    {
        echo "x";
        exit();
    }

}
