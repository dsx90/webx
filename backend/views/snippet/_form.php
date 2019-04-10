<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->widget(
        'trntv\aceeditor\AceEditor',
        [
            'mode'=>'php',      // programing language mode. Default "html"
            'theme'=>'monokai',  // editor theme. Default "github" ace/theme/
            'readOnly'=>'false'  // Read-only mode on/off = true/false. Default "false"
        ]
    ) ?>

    <?= $form->field($model, 'is_file')->textInput() ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
