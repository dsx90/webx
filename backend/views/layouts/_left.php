<?php

use backend\models\Log;
use backend\widgets\Menu;

use backend\components\tree\TreeWidget;
use common\models\Launch;

/* @var $this \yii\web\View */
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#left-resources">Ресурсы</a></li>
                <li><a data-toggle="tab" href="#left-main">Основное</a></li>
                <li><a data-toggle="tab" href="#left-widget">Виджеты</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="left-resources" class="tab-pane fade in active">
                <?= TreeWidget::widget(['data' => Launch::find()->orderBy(['position' => SORT_ASC])->all()]) ?>
            </div>
            <div id="left-main" class="tab-pane fade">
                <?= Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => [
                [
                    'label' => Yii::t('backend', 'Main'),
                    'options' => ['class' => 'header'],
                ],
                [
                    'label' => Yii::t('backend', 'Menu'),
                    'url' => ['/menu/index'],
                    'icon' => '<i class="fa fa-sitemap"></i>',
                ],
                [
                    'label' => Yii::t('backend', 'Tags'),
                    'url' => ['/tag/index'],
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
                            'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('backend', 'Articles'),
                            'url' => ['/article/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('backend', 'Article categories'),
                            'url' => ['/article-category/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>'],
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
                            'label' => Yii::t('backend', 'Template'),
                            'url' => ['/template'],
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
                        ['label' => Yii::t('backend', 'Key storage'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Cache'), 'url' => ['/cache/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('backend', 'Logs'),
                            'url' => ['/log/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'badge' => Log::find()->count(), 'badgeBgClass' => 'label-danger',
                        ],
                    ],
                ],
            ],
        ]) ?>
            </div>
            <div id="left-widget" class="tab-pane fade">

            </div>
        </div>
        <?php
            $a = disk_total_space("/")/100;
            $freely = disk_free_space("/")/$a;
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
