<?php
return [
    'db' => require(__DIR__ . '/../../common/config/db.php'),
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        //路由管理
        'rules' => [
            "<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
            "<module:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>" => "<module>/<controller>/<action>",
            "<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
            "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
        ],
    ],
    'user' => [
        'identityClass' => 'app\models\YiiUser',//模型自动登录
        'enableAutoLogin' => true,
        'loginUrl' => ['admin/index/login'],//定义后台默认登录界面[权限不足跳到该页]
    ],
    'wechat' => [
        'class' => 'common\utils\Wechat',
        'appid' => 'wx9462dd181a56c284',
        'appsecret' => '6a6d79adca5a20309e05350da253bdae',
        'token' => 're123de456m',
        'debug' => false,
        'appAccount' => 'kangheyuan2015',
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
];
