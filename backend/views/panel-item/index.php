<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PanelItem;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PanelItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Panel Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-item-index">
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Panel Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'parent.title',
            [
                'attribute' => 'title',
                'content' => function(PanelItem $item){
                    return Html::tag('i', '', ['class' => $item->icon])." $item->title";
                }
            ],
            //'id',
            //'key',
            'panel.title',
            'visible',
            //'description',
            //'url:url',
            //'options',
            //'slug',
            //'position',

            [
                'attribute' => 'status',
                'content'   => function(PanelItem $item){
                    return PanelItem::getStatus()[$item->status];
                }
            ],
            //'richtext:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
