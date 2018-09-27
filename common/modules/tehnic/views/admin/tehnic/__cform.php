<?php
use unclead\multipleinput\MultipleInput;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'price')->textInput() ?>

        <?= $form->field($model, 'status')->dropDownList(\common\modules\tehnic\models\Tehnic::$statuses) ?>

        <?= $form->field($model, 'views')->textInput() ?>

        <hr>
        <h5>
            <?//= $model->getAttribut('<br>') ?>
        </h5>

        <?= $form->field($model, 'attachment')->widget(
            \fbalabanov\filekit\widget\Upload::className(),
            [
                'url' => ['/site/upload'],
                'targetDir' => 'tehnic/'.$model->category->launch->slug.'/'.$model->launch_id,
                'sortable' => true,
                'maxFileSize' => 10000000, // 10 MiB
                'maxNumberOfFiles' => 10,
            ]) ?>

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

        <?= $form->field($model, 'content')->textarea(['rows' => 5]) ?>

<?php ActiveForm::end(); ?>


<?php $this->registerCss('
#tehnic-content{
    height: 182px !important;
}
.list-cell__button{
    padding-right: 0 !important;
}
');?>
<?php
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