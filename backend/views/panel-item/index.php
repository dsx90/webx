<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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

            //'id',
            //'key',
            'parent_id',
            'panel.title',
            'visible',
            'title',
            //'description',
            'icon',
            //'url:url',
            //'options',
            //'slug',
            //'sort',
            'status',
            //'richtext:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
