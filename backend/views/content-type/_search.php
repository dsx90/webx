<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ContentTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'icon') ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'controller') ?>

    <?php // echo $form->field($model, 'form') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
