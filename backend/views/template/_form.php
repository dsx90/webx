<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
            <p>
                <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
                <?php
                if (!$model->isNewRecord) {
                    echo Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this template?'),
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-menu-left']).Yii::t('document', 'Отмена'), ['index'], [
                    'class' => 'btn btn-default',
                ]) ?>
            </p>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'display')->dropDownList(\common\models\Template::getDisplayArray()) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'description')->textarea() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'code')->widget(
                'trntv\aceeditor\AceEditor',
                [
                    'mode'=>'html',      // programing language mode. Default "html"
                    'theme'=>'monokai',  // editor theme. Default "github" ace/theme/
                    'readOnly'=>'false'  // Read-only mode on/off = true/false. Default "false"
                ]
            )->hint(Yii::getAlias('@template').'\\'.$model->title.'.tpl') ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>