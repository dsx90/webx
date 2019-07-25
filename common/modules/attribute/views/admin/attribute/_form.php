<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\attribute\models\Attribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'scale')->dropDownList($model::getScale()) ?>
                </div>
            </div>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'required')->checkbox() ?>

            <?= $form->field($model, 'type')->dropDownList($model::getType()) ?>

            <?= $form->field($model, 'max')->textInput() ?>

            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
