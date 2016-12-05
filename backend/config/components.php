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
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
];
