<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCustomer */

$this->title = 'Create Tehnic Customer';
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-customer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'customer' => $customer,
    ]) ?>

</div>
