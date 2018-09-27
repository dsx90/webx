<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\tehnic\search\TehnicCatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tehnic Cats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-cat-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tehnic Cat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-condensed table-hover table-striped table-gv'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'launch_id',
            [
                'attribute'=>'attachment',
                'contentOptions' =>['class' => 'table_image'],
                'format' => 'image',
                'value' => function($model) {
                    return isset($model->thumbnail) ? $model->thumbnail['base_url'].'/'.\common\lib\Imager::thumbnail($model->thumbnail['path'], 135, 135) : null;
                }
            ],
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return  $model->launch->parent->title;
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model) {
                    return  '<h5><b>'.$model->launch->title.'</b></h5>'.
                        '<h5>'.$model->launch->longtitle.'</h5>'.
                        '<h6>'.$model->launch->description.'</h6>';
                },
            ],
            //'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
