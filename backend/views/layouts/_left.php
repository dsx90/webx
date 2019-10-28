<?php

use backend\models\Log;
use backend\widgets\Menu;
use yii\bootstrap\Tabs;
use common\models\PanelItem;
use yii\helpers\Json;
use common\widget\coreCase\getCase;

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
//                [
//                    'label' => 'Ресурсы',
//                    'content' => TreeWidget::widget(['data' => Launch::find()->orderBy(['position' => SORT_ASC])->all()]),
//                    'active' => true // указывает на активность вкладки
//                ],
                [
                    'label' => 'Основное',
                    'content' => Menu::widget([
                            'options' => ['class' => 'sidebar-menu'],
                            'items' => getItems(getCase::mapTree(PanelItem::find()->asArray()->indexBy('id')->all()))
                        ])
                ],
                [
                    'label' => 'Виджеты',
                    'content' => '',
                ],
            ]
        ]);
        ?>

        <div class="col-sm-12 widget">
            <p>IP: <?= Yii::$app->request->userIP?></p>
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
