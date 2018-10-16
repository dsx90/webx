<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\construction\search\ConstructionSearch */
/* @var $searchLaunch \common\search\LaunchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Constructions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Construction', ['create'], ['class' => 'btn btn-success']) ?>
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

            [
                'attribute'=>'attachment',
                'contentOptions' =>['class' => 'table_image'],
                'format' => 'image',
                'value' => function($model) {
                    if($model->attachment) {
                        foreach ($model->attachment as $attaching) {
                            return \common\lib\Imager::thumbnail($attaching['path'], 80, 80);
                        }
                    }
                }
            ],
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return  isset($model->launch->parent->title) ? $model->launch->parent->title : null;
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model) {
                    return  '<h5><b>'.$model->launch->title.'</b></h5>'.
                        '<h5>'.$model->launch->long_title.'</h5>'.
                        '<h6>'.$model->launch->description.'</h6>';
                },
            ],
            'price',
            'launch.author.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
