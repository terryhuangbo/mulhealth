<?php
// 配置文件
return [
    'id' => 'mulhealth',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'alias' => [
            '@common' => dirname(__DIR__),
            '@frontend' => dirname(dirname(__DIR__)) . '/frontend',
            '@backend' => dirname(dirname(__DIR__)) . '/backend',
            '@console' => dirname(dirname(__DIR__)) . '/console',
            '@environment' => dirname(dirname(__DIR__)) . '/environment',
            '@upload' => dirname(dirname(__DIR__)) . '/frontend/web/upload/',
        ],
    ],
];

