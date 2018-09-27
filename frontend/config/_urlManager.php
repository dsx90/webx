<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Index page
        '' => 'site/index',
        // Pages
        //'tehnic/<slug:[\w\-]+>' => 'tehnic/frontend/tehnic/category',
        //'tehnic/<slug>'                 => 'tehnic/frontend/tehnic/view',
        //'tehnic/<slug>/<_a:\[\w-]+>'    => 'tehnic/frontend/tehnic/<_a>',
        '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
        'page/<slug>' => 'page/view',
        // Articles
        'article/page/<page>' => 'article/index',
        'article/index' => 'article/index',
        'article/<slug>' => 'article/view',
        'article/category/<slug>' => 'article/category',
        'article/tag/<slug>' => 'article/tag',
    ],
];
