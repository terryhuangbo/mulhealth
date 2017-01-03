<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'mulhealth-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => '/home/index/index',
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [],
    'layout' => '//main',
    'modules' => [
        //公共
        'common' => [
            'class' => 'frontend\modules\common\Module',
        ],
        //用户
        'redeem' => [
            'class' => 'frontend\modules\redeem\Module',
        ],
        //首页
        'home' => [
            'class' => 'frontend\modules\home\Module',
        ],
        //用户
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        //个人中心
        'my' => [
            'class' => 'frontend\modules\my\Module',
        ],
        //公司
        'company' => [
            'class' => 'frontend\modules\company\Module',
        ],
        //产品
        'product' => [
            'class' => 'frontend\modules\product\Module',
        ],
        //评论
        'comment' => [
            'class' => 'frontend\modules\comment\Module',
        ],
    ],
    'components' => [
        'db' => require(__DIR__ . '/../../common/config/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'file-upload' => 'common/file/upload',
                'file-delete' => 'common/file/delete',
                'index-login' => 'home/index/index-login',
                'login' => 'user/index/login',
                'register' => 'user/index/register',
                'logout' => 'user/index/logout',
                'reset' => 'user/index/reset',
                'perfect' => 'my/profile/perfect',
            ],
        ],
        'user' => [
            'identityClass' => 'frontend\models\UserForm',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/index/login'],
        ],
        'jssdk' => [
            'class' => 'app\components\Wechat\Jssdk',
            'appId' => 'wx9462dd181a56c284',
            'appSecret' => '6a6d79adca5a20309e05350da253bdae',
        ],
        'wechat' => [
            'class' => 'app\components\Wechat\WechatAuth',
            'appid' => 'wx9462dd181a56c284',
            'appsecret' => '6a6d79adca5a20309e05350da253bdae',
            'token' => 're123de456m'
        ],
        'userData' => [
            'class' => 'app\modules\user\models\UserData',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/" . date('Y/m/d', time()) . '/log.txt',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'categories' => ['frontend\*'],
                    'except' => [],
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
