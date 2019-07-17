<?php

use backend\models\Log;
use backend\widgets\Menu;
use yii\bootstrap\Tabs;
use common\models\PanelItem;
use yii\helpers\Json;

use backend\components\tree\TreeWidget;
use common\models\Launch;
use yii\helpers\Html;

$a = disk_total_space("/") / 100;
$freely = disk_free_space("/") / $a;

/* @var $this \yii\web\View */
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        function getItems($items){
            $result = [];
            foreach ($items as $item){
                $result[] = [
                    'label'     => isset($item['title']) ? Yii::t('backend', $item['title']) : 'label',
                    'url'       => isset($item['url']) ? $item['url'] : '#',
                    'icon'      => Html::tag('i', '', ['class' => isset($item['icon']) ? $item['icon'] : 'fa fa-sticky-note-o']),
                    //'options'   => isset($item['options']) ? $item['options'] : [],
                    'visible'   => isset($item['visible']) ? Yii::$app->user->can($item['visible']) : null,
                    'items'     => isset($item['childs']) ? getItems($item['childs']) : null
                ];
            };
            return $result;
        }
        ?>
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => 'Ресурсы',
                    'content' => TreeWidget::widget(['data' => Launch::find()->orderBy(['position' => SORT_ASC])->all()]),
                    'active' => true // указывает на активность вкладки
                ],
                [
                    'label' => 'Основное',
                    'content' => Menu::widget([
                            'options' => ['class' => 'sidebar-menu'],
                            'items' => getItems(\common\widget\coreCase\getCase::mapTree(PanelItem::find()->asArray()->indexBy('id')->all()))
                        ])
                        /*Menu::widget([
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Main'),
                                'options' => ['class' => 'header'],
                            ],
                            [
                                'label' => Yii::t('backend', 'Panel'),
                                'url' => ['/panel'],
                                'icon' => '<i class="fa fa-sitemap"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Panel Item'),
                                'url' => ['/panel-item'],
                                'icon' => '<i class="fa fa-sitemap"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Context'),
                                'url' => ['/context'],
                                'icon' => '<i class="fa fa-sitemap"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Context Key'),
                                'url' => ['/context-key'],
                                'icon' => '<i class="fa fa-sitemap"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Like'),
                                'url' => ['/like'],
                                'icon' => '<i class="fa fa-star-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Visit'),
                                'url' => ['/visit'],
                                'icon' => '<i class="fa fa-eye"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Menu'),
                                'url' => ['/menu'],
                                'icon' => '<i class="fa fa-sitemap"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Tags'),
                                'url' => ['/tag'],
                                'icon' => '<i class="fa fa-tags"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Tehnic'),
                                'options' => ['class' => 'header'],
                            ],

                            [
                                'label' => Yii::t('backend', 'Tehnic'),
                                'url' => ['/tehnic/admin/tehnic'],
                                'icon' => '<i class="fa fa-angle-double-right"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Tehnic Category'),
                                'url' => ['/tehnic/admin/tehnic-cat'],
                                'icon' => '<i class="fa fa-angle-double-right"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Tehnic Customer'),
                                'url' => ['/tehnic/admin/tehnic-customer'],
                                'icon' => '<i class="fa fa-angle-double-right"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Setings'),
                                'url' => '#',
                                'icon' => '<i class="fa fa-edit"></i>',
                                'options' => ['class' => 'treeview'],
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Tehnic Option'),
                                        'url' => ['/tehnic/admin/tehnic-option'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Tehnic Option Assignment'),
                                        'url' => ['/tehnic/admin/tehnic-option-assignment'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Tehnic Option Value'),
                                        'url' => ['/tehnic/admin/tehnic-option-value'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    ],
                                ]
                            ],
                            [
                                'label' => Yii::t('backend', 'Content'),
                                'url' => '#',
                                'icon' => '<i class="fa fa-edit"></i>',
                                'options' => ['class' => 'treeview'],
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Static pages'),
                                        'url' => ['/page/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>'
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Articles'),
                                        'url' => ['/article/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>'
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Article categories'),
                                        'url' => ['/article-category/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>'
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Construction'),
                                        'url' => ['/construction/admin/construction'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>'
                                    ],
                                ],
                            ],
                            [
                                'label' => Yii::t('backend', 'System'),
                                'options' => ['class' => 'header'],
                            ],
                            [
                                'label' => Yii::t('backend', 'Users'),
                                'url' => ['/user/index'],
                                'icon' => '<i class="fa fa-users"></i>',
                                'visible' => Yii::$app->user->can('administrator'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Customer'),
                                'url' => ['/customer/index'],
                                'icon' => '<i class="fa fa-id-card-o"></i>',
                                'visible' => Yii::$app->user->can('administrator'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Other'),
                                'url' => '#',
                                'icon' => '<i class="fa fa-terminal"></i>',
                                'options' => ['class' => 'treeview'],
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Layout Module'),
                                        'url' => ['/layout-module/index'],
                                        'icon' => '<i class="fa fa-puzzle-piece"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Launch'),
                                        'url' => ['/launch'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Group'),
                                        'url' => ['/group'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Template'),
                                        'url' => ['/template'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Chunk'),
                                        'url' => ['/chunk'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Snippet'),
                                        'url' => ['/snippet'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Module'),
                                        'url' => ['/module'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => 'Gii',
                                        'url' => ['/gii'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => YII_ENV_DEV,
                                    ],
                                    [
                                        'label' => 'Web shell',
                                        'url' => ['/webshell'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    ['label' => Yii::t('backend', 'File manager'), 'url' => ['/file-manager/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                                    [
                                        'label' => Yii::t('backend', 'DB manager'),
                                        'url' => ['/db-manager/default/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'System information'),
                                        'url' => ['/phpsysinfo/default/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'visible' => Yii::$app->user->can('administrator'),
                                    ],
                                    ['label' => Yii::t('backend', 'Key storage'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                                    ['label' => Yii::t('backend', 'Cache'), 'url' => ['/service/cache'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                                    ['label' => Yii::t('backend', 'Clear assets'), 'url' => ['/service/clear-assets'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                                    [
                                        'label' => Yii::t('backend', 'Logs'),
                                        'url' => ['/log/index'],
                                        'icon' => '<i class="fa fa-angle-double-right"></i>',
                                        'badge' => Log::find()->count(),
                                        'badgeOptions' => ['class' => 'label-danger'],
                                    ],
                                ],
                            ],
                        ],
                    ]),*/
                ],
                [
                    'label' => 'Виджеты',
                    'content' => '',
                ],
            ]
        ]);
        ?>

        <div class="col-sm-12 widget">
            <!-- Progress bars -->
            <div class="clearfix" style="color:#fff">
                <span class="pull-left">Места на диске:</span>
                <small class="pull-right"><?= (int)$freely ?>%</small>
            </div>
            <div class="progress xs">
                <div class="progress-bar progress-bar-green" style="width: <?= $freely ?>%;"></div>
            </div>
        </div>

    </section>
</aside>

<?php $this->registerJs("
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href=\"#' + url.split('#')[1] + '\"]').tab('show');
} 

$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})
")?>
