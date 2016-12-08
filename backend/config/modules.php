<?php
return [
    //默认模块
    'admin' => 'app\modules\admin',
    //后台用户管理
    'team' => 'app\modules\team\TeamModule',
    'treemanager' => ['class' => '\kartik\tree\Module'],//后台分类管理插件模块引用，
    // 公用
    'common' => [
        'class' => 'backend\modules\common\Module',
    ],
    // 用户
    'user' => [
        'class' => 'backend\modules\user\Module',
    ],
    // 产品
    'product' => [
        'class' => 'backend\modules\product\Module',
    ],
    // 标签
    'tag' => [
        'class' => 'backend\modules\tag\Module',
    ],
    // 发帖
    'comment' => [
        'class' => 'backend\modules\comment\Module',
    ],
    // 发帖
    'content' => [
        'class' => 'backend\modules\content\Module',
    ],
    //细胞
    'cell' => [
        'class' => 'backend\modules\cell\Module',
    ],


];
