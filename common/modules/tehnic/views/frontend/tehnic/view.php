<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\Tehnic */
/* @var $launch common\models\Launch */

$crumbs = [];
$parent = $model->category->launch;
$crumbs[] = ['label' => $parent->title, 'url' => ['category', 'slug' => $parent->slug]];
while ($parent = $parent->parent) {
    $crumbs[] = ['label' => $parent->title, 'url' => ['category', 'slug' => $parent->slug]];
}
$this->params['breadcrumbs'] = array_reverse($crumbs);
$this->params['breadcrumbs'][] = $launch->title;
$this->params['category'] = $model->category;
?>

<div class="post-view">
    <div class="col-md-3">
        <ul class="catalog category-products">
            <?php
//            echo \common\widget\coreCase\Menu::widget([
//                //'parents' => $launch->parent_id,
//                'limit' => 10,
//                'select' => ['id', 'parent_id', 'title', 'slug', 'status'],
//                //'resources' => 16,
//                'tpl' => 'menu',
//                'controller' => 'frontend/tehnic/view',
//                //'last' => false,
//            ])
            ?>
        </ul>
    </div>
    <div class="col-md-9 row" style="padding-right: 0">
        <div class="col-sm-6 pull-right" style="padding-right: 0">
            <h2 style="margin-top: -4px"><?= Html::encode($model->category->launch->title) ?> <small><?= Html::encode($launch->title) ?></small>
                <div class="pull-right">
                    <?= Html::a('Update', ['update', 'slug' => $launch->slug], ['class' => 'btn btn-sm btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'slug' => $launch->slug], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </h2>
            <hr style="margin-top: 0">
            <h4>
                <?= $model->getAttribut('<br>') ?>
            </h4>
            <h5>
                <strong>Описание:</strong>
                <p><?= Html::encode($model->content) ?></p>
            </h5>
            <hr>
            <h4><strong>Цена: <?= Html::encode($model->price)?></strong> <i class="fa fa-rub" aria-hidden="true"></i>/час

                <?=Html::a('Заказать', ['customer/add', 'slug' => $launch->slug], ['data-id' => $launch->id, 'class' => 'pull-right btn btn-sm btn-success order_click'])?>
            </h4>
            <h6><i class="fa fa-eye" aria-hidden="true"></i> <sup><?= ($model->views)?></sup> <i class="fa fa-id-card-o" aria-hidden="true"> <?//= ($model->orders_activ)?><sup><?//= ($model->orders)?></sup></i>
            </h6>
        </div>

        <div class="col-sm-6" style="display:flow-root">
            <?php $items = [];
            foreach ($model->attachment as $attach) {
                $items[] = [
                    'content' => Html::img(\common\lib\Imager::thumbnail($attach['path'], 450, 300)),
                    'options' => ['style' => 'width:100%']
                ];
            }
            echo \yii\bootstrap\Carousel::widget([
                'items' => $items,
                'options' => ['class' => 'slide'],
                'controls' => [
                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-left']),
                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-right']),
                ],
            ]) ?>
        </div>
        <div class="col-sm-12">
            <center><h3>СМОТРИТЕ ТАК ЖЕ</h3></center>
            <?/*= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => false,
            ]) */?>
        </div>
    </div>
</div>
<?= $orderUrl =  Url::current([], true);?>
<pre>
            <?
//                echo \common\widget\coreCase\Menu::widget([
//                    //'parents' => $launch->parent_id,
//                    'limit' => 10,
//                    'select' => ['id', 'parent_id', 'title', 'slug', 'status'],
//                    //'resources' => 16,
//                    'tpl' => 'menu',
//                    'controller' => 'frontend/tehnic',
//                    'debug' => true,
//                    //'last' => false,
//                ]);

                /*echo \common\widget\coreCase\Menu::widget([
                    //'parents' => $launch->parent_id,
                    'limit' => 10,
                    'select' => ['id', 'parent_id', 'title', 'slug', 'status'],
                    //'resources' => 16,
                    'tpl' => 'menu',
                    'controller' => 'frontend/tehnic/view',
                    'debug' => true,

                ])*/
            ?>
            </pre>
<pre>
<?
    echo \common\widget\coreCase\Breadcrumps::widget([
        'id' => $launch->id,
        'limit' => 10,
        'select' => ['id', 'parent_id', 'title', 'slug', 'status'],
        'resources' => 16,
        'tpl' => 'menu',
        'controller' => 'frontend/tehnic/view'
    ])
?>
</pre>

<?php $model->updateCounters(['views' => 1]);?>
