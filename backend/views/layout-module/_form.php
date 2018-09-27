<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LayoutModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="layout-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->dropDownList(\backend\models\LayoutModule::$positions) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group pull-left">
        <?= $form->field($model, 'status')->widget(\dosamigos\switchinput\SwitchBox::className(),[
            'clientOptions' => [
                'size' => 'normal',
                'onColor' => 'success',
                'offColor' => 'danger',
            ],
            'inlineLabel' => false
        ])->label(false);?>
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
