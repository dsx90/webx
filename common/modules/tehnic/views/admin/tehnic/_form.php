<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;
use common\models\Launch;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\Tehnic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-12 control">
            <div class="pull-right">
                <?= $form->field($launch, 'status')->widget(\dosamigos\switchinput\SwitchBox::className(),[
                    'clientOptions' => [
                        'size' => 'normal',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ],
                    'inlineLabel' => false
                ])->label(false);?>
                <?//= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
                <?php if (!$model->isNewRecord) {
                    echo Html::a('<i class="glyphicon glyphicon-eye-open"></i> '.Yii::t('backend', 'View'), ['view', 'id' => $model->launch_id], [
                            'class' => 'btn btn-success',
                        ])." ";
                    echo Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('backend', 'Delete'), ['delete', 'id' => $model->launch_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete the resources?'),
                                'method' => 'post',
                            ],
                        ])." ";
                    echo Html::a('<i class="glyphicon glyphicon-level-up"></i> '.Yii::t('backend', 'Create child'), ['create', 'parent_id' => $launch->parent_id], [
                            'class' => 'btn btn-default',
                        ])." ";
                }
                ?>
                <?= Html::a('<i class="fa fa-chevron-left"></i>',['update', 'id' => $launch->getPrev()], ['class' => 'btn btn-default',]) ?>
                <?= Html::a('<i class="fa fa-arrow-up"></i>',['index'], ['class' => 'btn btn-default',]) ?>
                <?= Html::a('<i class="fa fa-chevron-right"></i>',['update', 'id' => $launch->getNext()], ['class' => 'btn btn-default',]) ?>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">

                <div class="col-sm-5">

                    <?//= $form->field($model, 'attachment')->widget(
                      //  \fbalabanov\filekit\widget\Upload::className(),
                      //  [
                      //      'url' => ['/site/upload'],
                      //      'targetDir' => 'tehnic/'.$model->category->launch->slug.'/'.$model->launch_id,
                      //      'sortable' => true,
                      //      'maxFileSize' => 10000000, // 10 MiB
                      //      'maxNumberOfFiles' => 10,
                      //  ]);
                    ?>

                </div>

                <div class="col-sm-7">

                    <div class="row">
                        <div class="col-sm-9">
                            <?= $form->field($launch, 'title')->textInput() ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'price')->textInput() ?>
                        </div>
                    </div>

                    <?php if (isset($model->category)) : ?>
                        <?= $form->field($models[0], 'option')->widget(MultipleInput::className(), [
                            'model' => $models[0],
                            'data' => $models,
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

                    <div class="adver-view">
                        <i>Видимость в поисковиках</i>
                        <h2><span id="title"><?= isset($model->category->launch->title) ? $model->category->launch->title : null ?> <?= $launch->title ? $launch->title : 'Титул' ?></span>: <span id="longtitle"><?= $model->price ? $model->price.'р/час' : 'Краткое описание' ?></span></h2>
                        <h4><?= env('FRONTEND_URL')?> › <span id="url"><?= $launch->slug ? $launch->slug : 'url ссылка' ?></span></h4>
                        <h5><span id="description"><?= strip_tags($model->content) ? $model->cut(strip_tags($model->content), 140).'...' : 'Обьявление' ?> <br> <b><?= $model->getAttribut(', ') ?></b></span></h5>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-3">

            <?= $form->field($launch, 'parent_id')->dropDownList(Launch::getAll(13), ['prompt' => 'Тип документа:']) ?>


            <?= $form->field($launch, 'slug')->textInput() ?>

            <?= $form->field($model, 'status')->dropDownList(\common\modules\tehnic\models\Tehnic::$statuses) ?>

            <hr>
            <h5>
                <?= $model->getAttribut('<br>') ?>
            </h5>

            <?= $form->field($model, 'views')->textInput() ?>

        </div>
    <?php ActiveForm::end(); ?>

</div>

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