<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\pet\models\TiesPets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ties-pets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'male')->textInput() ?>

    <?= $form->field($model, 'female')->textInput() ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
