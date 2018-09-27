<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\tehnic\search\TehnicOptionValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tehnic Option Values';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-option-value-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tehnic Option Value', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'tehnic_id',
                'value' => function ($model) {
                    return  $model->tehnic->category->launch->title.': '.$model->tehnic->launch->title;
                },
            ],
            [
                'attribute' => 'option_id',
                'value' => function ($model) {
                    return  $model->options->option;
                },
            ],
            [
                'attribute' => 'value',
                'value' => function ($model) {
                    return  $model->value.' '.$model->options->scale;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
