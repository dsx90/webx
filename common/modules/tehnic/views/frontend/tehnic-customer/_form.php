<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->label(false)->textInput(array('maxlength' => true, 'placeholder' => 'Ваше имя', 'class'=>'form-control')); ?>

        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7 (999) 999 99 99',])->label(false)->textInput(array('placeholder' => 'Номер телефона', 'class'=>'form-control')) ?>

        <?= $form->field($model, 'email')->label(false)->textInput(array('maxlength' => true, 'placeholder' => 'Email почта', 'class'=>'form-control')); ?>

        <?= $form->field($customer, 'address')->label(false)->textInput(array('maxlength' => true, 'placeholder' => 'Адрес куда подать технику', 'class'=>'form-control')); ?>

        <?/*= $form->field($model, 'order_on_time')->widget(
            \trntv\yii\datetime\DateTimeWidget::className(),
            [
                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
            ]
        ) */?>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
        </div>

    <?= $orderUrl =  Url::current([], true);?>

    <?php ActiveForm::end(); ?>

</div>
