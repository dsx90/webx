<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\search\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'owner_id',
            'manager_id',
            'name',
            'phone',
            // 'email:email',
            // 'comment:ntext',
            // 'comment_manager:ntext',
            // 'status',
            // 'order_get',
            // 'debt',
            // 'debt_time:datetime',
            // 'passport',
            // 'company',
            // 'iin',
            // 'duration_time:datetime',
            // 'thumbnail',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
