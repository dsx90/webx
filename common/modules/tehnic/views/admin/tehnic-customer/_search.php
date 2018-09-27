<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\search\TehnicCustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'work_time') ?>

    <?php // echo $form->field($model, 'order_time') ?>

    <?php // echo $form->field($model, 'order_on_time') ?>

    <?php // echo $form->field($model, 'value_work') ?>

    <?php // echo $form->field($model, 'percent') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
