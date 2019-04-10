<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mirocow\eav\models\EavEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eav-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entityName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entityModel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoryId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
