<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'app-backend',
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'site/settings',
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storage',
                    'path' => '/',
                    'access' => ['read' => 'manager', 'write' => 'manager'],
                    'options' => [
                       'attributes' => [
                            [
                                'pattern' => '#.*(\.gitignore|\.htaccess)$#i',
                                'read' => false,
                                'write' => false,
                                'hidden' => true,
                                'locked' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'components' => [
        'configManager' => [
            'class' => 'yii2tech\config\Manager',
            'items' => [

            ],
        ],
        'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
//            'as YandexMetrika' => [
//                'class' => \hiqdev\yii2\YandexMetrika\Behavior::class,
//                'builder' => [
//                    'class' => \hiqdev\yii2\YandexMetrika\CodeBuilder::class,
//                    'id' => $params['yandexMetrika.id'],
//                    'params' => $params['yandexMetrika.params'],
//                ],
//            ],
        ],
        'fileStorage' => [
            'class' => 'fbalabanov\filekit\Storage',
            'baseUrl' => env('STORAGE_URL').'/images',
            'filesystem' => function() {
                $adapter = new \League\Flysystem\Adapter\Local(Yii::getAlias('@storage/images'));
                return new League\Flysystem\Filesystem($adapter);
            },
        ],
        'dispatcher' => [
            'class' => 'common\components\dispatcher\Dispatcher',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'app-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php'),
    ],
    'modules' => [

        'eav' => [
            'class' =>  'mirocow\eav\Module',
        ],
//        'metrica' => [
//            'class' => 'common\modules\metrica\YandexMetricaWidget',
//        ],

        'construction' => [
            'class' => \common\modules\construction\Module::class,
        ],
        'shop' => [
            'class' => \common\modules\shop\Module::class,
        ],
        'order' => [
            'class' => common\modules\order\Module::class,
        ],
        'comment' => [
            'class' => common\modules\comment\Module::class,
        ],

        'dispatcher' => [
            'class' => common\Module::class,
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'db-manager' => [
            'class' => 'bs\dbManager\Module',
            // path to directory for the dumps
            'path' => '@root/backups',
            // list of registerd db-components
            'dbList' => ['db'],
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
        'rbac' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
        'webshell' => [
            'class' => 'samdark\webshell\Module',
            'yiiScript' => '@root/yii', // adjust path to point to your ./yii script
            'allowedIPs' => ['*'],
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
        'phpsysinfo' => [
            'class' => 'bs\phpSysInfo\Module',
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
    ],
    'as globalAccess' => [
        'class' => 'common\behaviors\GlobalAccessBehavior',
        'rules' => [
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['login'],
                'roles' => ['?'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['logout'],
                'roles' => ['@'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['error'],
                'roles' => ['?', '@'],
            ],
            [
                'controllers' => ['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers' => ['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager'],
            ],
        ],
    ],
    'as beforeAction' => [
        'class' => 'common\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '10.0.75.1'],
        'as access' => [
            'class' => 'common\behaviors\GlobalAccessBehavior',
            'rules' => [
                [
                    'allow' => true,
                ],
            ],
        ],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '10.0.75.1'],
        'as access' => [
            'class' => 'common\behaviors\GlobalAccessBehavior',
            'rules' => [
                [
                    'allow' => true,
                ],
            ],
        ],
    ];
}

return $config;
