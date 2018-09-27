<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($customer, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($customer, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($customer, 'email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'order_id')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'order_on_time')->textInput() ?>
                </div>
            </div>
            <?= $form->field($customer, 'comment')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($customer, 'order_get')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($customer, 'status')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($customer, 'thumbnail')->widget(
                        \trntv\filekit\widget\Upload::className(),
                        [
                            'url' => ['/site/upload'],
                            'maxFileSize' => 5000000, // 5 MiB
                        ]);
                    ?>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($customer, 'company')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-8">
                            <?= $form->field($customer, 'iin')->textInput() ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($customer, 'debt')->textInput() ?>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($customer, 'debt_time')->textInput() ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($customer, 'duration_time')->textInput() ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <?= $form->field($customer, 'comment_manager')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <?= $form->field($customer, 'owner_id')->textInput() ?>

    <?= $form->field($customer, 'manager_id')->textInput() ?>

    <?= $form->field($model, 'work_time')->textInput() ?>

    <?= $form->field($model, 'value_work')->textInput() ?>

    <?= $form->field($model, 'percent')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
