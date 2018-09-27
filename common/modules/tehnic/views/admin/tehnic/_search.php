<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\search\TehnicSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'launch_id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'views') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
