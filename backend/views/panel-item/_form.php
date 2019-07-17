<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Panel;
use common\models\PanelItem;
use trntv\aceeditor\AceEditor;

/* @var $this yii\web\View */
/* @var $model common\models\PanelItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'richtext')->widget(
                AceEditor::class,
                [
                    'mode'=>'html',      // programing language mode. Default "html"
                    'theme'=>'monokai',  // editor theme. Default "github" ace/theme/
                    'readOnly'=>'false'  // Read-only mode on/off = true/false. Default "false"
                ]
            )?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(PanelItem::find()->all(), 'id', 'title'), ['prompt' => 'Нет']) ?>

            <?= $form->field($model, 'panel_id')->dropDownList(ArrayHelper::map(Panel::find()->all(), 'id', 'title')) ?>

            <?= $form->field($model, 'visible')->dropDownList(ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'), ['prompt' => 'Нет']) ?>

            <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'position')->textInput() ?>

            <?= $form->field($model, 'status')->dropDownList(PanelItem::getStatus()) ?>

            <?= $form->field($model, 'options')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
