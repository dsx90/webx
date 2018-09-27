<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCustomer */

$this->title = 'Update Tehnic Customer: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-customer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
