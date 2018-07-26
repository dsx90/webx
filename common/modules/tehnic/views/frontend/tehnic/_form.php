<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bupy7\dynafields\DynaFields;
use \unclead\multipleinput\MultipleInput;


/* @var $this yii\web\View */
/* @var $model common\models\post */
/* @var $form yii\widgets\ActiveForm */
?>

<h1 class="mt-0"><?= Yii::t('frontend', 'Create post') ?>
    <input class="pull-right btn btn-grey" type="button" onclick="history.back();" value="Вернуться назад"/>
</h1>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-6 pull-right row">

        <?= $form->field($launch, 'parent_id')->dropDownList(\dsx90\launcher\models\Launch::getAll(13)) ?>

        <?= $form->field($launch, 'title')->textInput(['maxlength' => true]) ?>

        <?php if (isset($model->category)) : ?>
            <?= $form->field($model->fetchoptions[0], 'option')->widget(MultipleInput::className(), [
                'model' => $model->fetchoptions[0],
                'data' => $model->fetchoptions,
                'max' => count($model->category->options),
                'enableGuessTitle'  => false,
                'allowEmptyList' => true,
                'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
                'columns' => [
                    [
                        'name' => 'option_id',
                        'items' => array_column($model->category->options, 'selectName', 'option_id'),
                        'type'  => 'dropDownList',
                        'title' => Yii::t('common', 'Options'),
                        'options' => [
                            'class' => 'multiple-select',
                        ]
                    ],
                    [
                        'name' => 'value',
                        'title' => Yii::t('common', 'Value'),
                    ],
                ],
            ])->label(false);
            ?>
            <h5><small>Добавьте доступные характеристики вашей техники, для удобного поиска</small></h5>
        <?php endif; ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

        <div class="col-sm-6 p-0">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 p-0">
            <div class="pull-right" style="margin-top: 25px">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

                <?= Html::a('Удалить', ['delete', 'id' => $launch->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>

    </div>

    <div id="tehnic-attachment" class="col-sm-6">

        <?= $form->field($model, 'attachment')->widget(
            \fbalabanov\filekit\widget\Upload::className(),
            [
                'url' => ['/site/upload'],
                'targetDir' => 'tehnic/'.$model->launch->parent->slug.'/'.$model->launch_id,
                'sortable' => true,
                'maxFileSize' => 10000000, // 10 MiB
                'maxNumberOfFiles' => 10,
            ])?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerCss('
#tehnic-attachment{
    border: 1px solid #cccccc;
    border-radius: 4px;
    min-height: 465px;
    max-height: 100%;
}
#tehnic-attachment .upload-kit-item, #tehnic-attachment .upload-kit-input{
    width: 104px;
    height: 104px;
}
#tehnic-attachment .upload-kit-item img{
    width:100px;
    height:100px;
}
');
$js = <<< JS
    $('.multiple-input').on('afterInit', function(e, row) {
        multi_inp_add_sync($(this));
    });
    $('.multiple-input').on('afterAddRow', function(e, row) {
        var row_select = row.find('.multiple-select');
       
        $(this).find('.multiple-select').slice(0, -1).each(function(index, select) {
            row_select.find('option[value='+ $(select).val()+']').remove();
        });
        row_select.find('option:first-child').attr('selected', true).trigger('change');
        multi_inp_add_sync($(this));
    });
    $('.multiple-input').on('afterDeleteRow', function(e, row) {
        var row_select = row.find('.multiple-select');
        var option = row_select.find('option[value='+row_select.val()+']').attr('selected', false);
        $(e.target).find('.multiple-select').append(option.clone());
    });
    function multi_inp_add_sync(cont) {
        var selected = [];
        cont.find('.multiple-select').each(function(index, select) {
            selected.push($(select).val());
        });
        cont.find('.multiple-select').each(function(index, select) {
            $(select).find('option').each(function(index, option) {
                if ($(select).val() !== $(option).attr('value') && $.inArray($(option).attr('value'), selected) !== -1){
                    $(option).remove();
                }
            })
        });
        

    }
JS;
$this->registerJs($js);

?>
