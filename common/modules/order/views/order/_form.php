<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ContentType;

/* @var $this yii\web\View */
/* @var $model common\modules\order\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <pre>
        <?php foreach(Yii::$app->modules as $module){
            print_r($module);
        } ?>
    </pre>


    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'comment_id')->textInput() ?>

            <?= $form->field($model, 'manager_comment_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'table')->dropDownList(\yii\helpers\ArrayHelper::map(ContentType::find()->all(), 'model', 'title'), ['prompt' => '']) ?>

            <?= $form->field($model, 'link_id')->textInput() ?>

            <?= $form->field($model, 'user_ip_id')->textInput() ?>

            <?= $form->field($model, 'manager_id')->textInput() ?>

            <?= $form->field($model, 'status')->textInput() ?>

            <?= $form->field($model, 'created_at')->textInput() ?>

            <?= $form->field($model, 'update_at')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
