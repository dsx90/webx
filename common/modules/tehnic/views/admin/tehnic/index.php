<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\tehnic\search\TehnicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tehnics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tehnic', ['create'], ['class' => 'btn btn-success']) ?>
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
                    if($model->attachment) {
                        foreach ($model->attachment as $attaching) {
                            return \common\lib\Imager::thumbnail($attaching['path'], 80, 80);
                        }
                    }
                }
            ],
            [
                'attribute' => 'launch.parent.title',
                'options' => ['style' => 'width: 100px'],
                //'filter' => \common\models\Launch::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'launch.parent.title',
            ],
            [
                'attribute' => 'launch.title',
                'format' => 'html',
                //'options' => ['style' => 'width: 25%'],
                'value' => function ($model) {
                    return  '<h5><b>'.$model->launch->parent->title.' '.$model->launch->title.'</b></h5>'.
                        '<h5>'.$model->cut(strip_tags($model->content), 130).'</h5>'.
                        '<h6><b>'.$model->getAttribut(', ').'</b></h6>'
                        ;
                },
            ],
            'price',
            'status',
            'views',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
