<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\pet\models\Pet;

/* @var $this yii\web\View */
/* @var $model common\modules\pet\models\Pet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ties_id')->textInput() ?>

    <?= $form->field($model, 'sex')->dropDownList(Pet::sexTitle()) ?>

    <?= $form->field($model, 'birth_date')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
