<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\LayoutModule;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\LayoutModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Layout Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layout-module-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Layout Module', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'layout_id',
            'module',
            'position',
            'sort_order',
            [
                'attribute' => 'status',
                'format' => 'html',
                'options' => ['style' => 'width: 65px'],
                'value' => function ($model) {
                    return $model->status ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
                },
                'filter' => [
                    LayoutModule::STATUS_DRAFT => Yii::t('backend', 'Not active'),
                    LayoutModule::STATUS_ACTIVE => Yii::t('backend', 'Active'),
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
