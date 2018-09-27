<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOption */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-option-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scale')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
