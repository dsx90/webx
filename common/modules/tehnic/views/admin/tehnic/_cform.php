<?php
/**
 * @var $model \common\modules\tehnic\models\Tehnic
 */

use unclead\multipleinput\MultipleInput;
use common\modules\tehnic\models\TehnicOptionValue;
?>

<?php //$form = ActiveForm::begin(); ?>
<div id="tehnic-right">
    <?= $form->field($model, 'status')->dropDownList(\common\modules\tehnic\models\Tehnic::$statuses) ?>

    <?= $form->field($model, 'views')->textInput() ?>
</div>
<div id="tehnic-content">
    <?php if (isset($model->category)) : ?>
        <?= $form->field($model->optionform[0], 'option')->widget(MultipleInput::class, [
            'model' => $model->optionform[0],
            'data' => $model->optionform,
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
</div>
<div id="tehnic-attachment">
    <?= $form->field($model, 'attachment')->widget(
        \fbalabanov\filekit\widget\Upload::class,
        [
            'url' => ['/site/upload'],
            'targetDir' => $model->isNewRecord ? '' : 'tehnic/'.$model->launch->parent->slug.'/'.$model->launch_id, //TODO: продумать способ сохранения нового документа
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10,
        ])->hint($model->isNewRecord ? '' : '/tehnic/'.$model->launch->parent->slug.'/'.$model->launch_id) ?>
</div>
<?= $form->field($model, 'price')->textInput() ?>

<?php $this->registerCss('
.list-cell__button{
    padding-right: 0 !important;
}
.field-launch-slug .dropdown-menu{
    left: -94px;
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
    $('.field-launch-title').addClass('col-md-9').wrap( "<div id='title-price' class='row'></div>" );
    $('.field-tehnic-price').addClass('col-md-3').appendTo( $('#title-price') );
    $('.field-launch-longtitle,.field-launch-description,.field-launch-keywords,.field-launch-slug,.field-launch-menutitle').detach();
    $('#launch-left').removeClass('col-md-9').addClass('col-md-6');
    $('#tehnic-attachment').prependTo( $('#launch-row') ).addClass('col-md-3');
    $('#tehnic-right').prependTo( $('#launch-right') );
    $('#tehnic-content').appendTo( $('#launch-left') );
    
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