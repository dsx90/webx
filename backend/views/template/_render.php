<?php

use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

    <div class="render-tpl">
        <?= $this->render('@template/'.$model->template->title.'.tpl', ['model' => $model,]) ?>
    </div>


    <?= $form->field($template, 'code')->widget(
        'trntv\aceeditor\AceEditor',
        [
            'mode'=>'html',      // programing language mode. Default "html"
            'theme'=>'monokai',  // editor theme. Default "github" ace/theme/
            'readOnly'=>'false'  // Read-only mode on/off = true/false. Default "false"
        ])
    ?>

    <?= \yii\helpers\Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
<?php $this->registerCss('
.render-tpl{
    border: 1px solid #c5c5c5;
    padding: 5px;
    margin: 10px 0;
}
')?>