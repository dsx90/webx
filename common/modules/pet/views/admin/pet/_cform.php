<?php

use common\modules\pet\models\Pet;
use trntv\yii\datetime\DateTimeWidget;
use kartik\date\DatePicker;

/**
 * @var $model Pet
 */

?>

<?= $form->field($model, 'ties_id')->textInput() ?>

<?= $form->field($model, 'sex')->dropDownList(Pet::sexTitle()) ?>

<?= $form->field($model, 'birth_date')->widget(DatePicker::class) ?>

<?= $form->field($model, 'status')->textInput() ?>