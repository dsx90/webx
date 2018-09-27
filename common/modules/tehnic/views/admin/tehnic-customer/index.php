<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\tehnic\search\TehnicCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tehnic Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-customer-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tehnic Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'customer.name',
            'customer.phone',
            'order_id',
            'address',
            'customer.status',
            //'work_time:datetime',
            // 'order_time:datetime',
            // 'order_on_time:datetime',
            // 'value_work',
            // 'percent',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
