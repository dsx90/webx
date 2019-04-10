<?php

use common\models\Panel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PanelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Panels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create Panel'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'context.title',
                'format' => 'raw',
                'content' => function(Panel $model){
                    return Html::a($model->context->title, ['context/update', 'id' => $model->context->id]);
                }
            ],
            'title',
            //'description',
            'key',
            'status',
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
