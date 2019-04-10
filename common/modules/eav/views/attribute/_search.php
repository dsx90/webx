<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mirocow\eav\models\EavAttributeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eav-attribute-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'entityId') ?>

    <?= $form->field($model, 'typeId') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'defaultValue') ?>

    <?php // echo $form->field($model, 'defaultOptionId') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'categoryId') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
