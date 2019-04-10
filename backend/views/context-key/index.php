<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ContextKey;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContextKeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Context Keys');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="context-key-index">
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Context Key'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'context.title',
                'format' => 'raw',
                'content' => function(ContextKey $model){
                    return Html::a($model->context->title, ['context/update', 'id' => $model->context->id]);
                }
            ],
            'key',
            //'namespace',
            'title',
            //'description',
            'value:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
