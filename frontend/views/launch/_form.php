<?php

use common\models\Template;
use common\models\Module;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\widgets\Pjax;

/* @var $model \common\models\Launch */
/* @var $composit \backend\controllers\LaunchController : update  */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="launch-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-sm-12">
                <?//php $this->beginBlock('control-panel') ?>
                    <div class="control-panel pull-right">
                        <?= $form->field($model, 'status')->widget(\dosamigos\switchinput\SwitchBox::class,[
                            'clientOptions' => [
                                'size' => 'normal',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ],
                            'inlineLabel' => false
                        ])->label(false);?>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
                        <?php if (!$model->isNewRecord) {
                            echo Html::a('<i class="glyphicon glyphicon-eye-open"></i> '.Yii::t('backend', 'View'), ['view', 'id' => $model->id], [
                                    'class' => 'btn btn-success',
                                ])." ";
                            echo Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => Yii::t('backend', 'Are you sure you want to delete the resources?'),
                                        'method' => 'post',
                                    ],
                                ])." ";
                            echo Html::a('<i class="glyphicon glyphicon-level-up"></i> '.Yii::t('backend', 'Create child'), ['create', 'parent_id' => $model->parent_id], [
                                    'class' => 'btn btn-default',
                                ])." ";
                        }
                        ?>
                        <?= Html::a('<i class="fa fa-chevron-left"></i>',['update', 'id' => $model->getPrev()], ['class' => 'btn btn-default',]) ?>
                        <?= Html::a('<i class="fa fa-arrow-up"></i>',['index'], ['class' => 'btn btn-default',]) ?>
                        <?= Html::a('<i class="fa fa-chevron-right"></i>',['update', 'id' => $model->getNext()], ['class' => 'btn btn-default',]) ?>
                    </div>
                <?//php $this->endBlock() ?>

            </div>
            <div id="launch-row">
                <div id="launch-left" class="col-md-9">
                    <div class="border-field">

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('Длинна пароля должна быть не более 35 символов.') ?>

                        <?= $form->field($model, 'long_title')->textInput(['maxlength' => true])->hint('Длинна пароля должна быть не более 81 символов.') ?>

                        <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

                        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

                    </div>
                    <pre>
                        <?//= print_r(Yii::$app->fr)?>
                    </pre>

                    <div class="adver-view">
                        <i>Видимость в поисковиках</i>
                        <a href="<?= env('FRONTEND_URL').Yii::$app->urlManager->createUrl(['launch/view', 'id'=>$model->id])?>" >
                            <h2><span id="adver-title"><?= $model->title ? $model->title : 'Титул' ?></span>: <span id="adver-long_title"><?= $model->long_title ?: 'Краткое описание' ?></span></h2>
                            <h4><?= env('FRONTEND_URL')?>›<span id="url"><?= Yii::$app->urlManager->createUrl(['launch/view', 'id'=>$model->id]) /*$model->slug ?: 'url ссылка'*/ ?></span></h4>
                        </a>
                        <h5><span id="adver-description"><?= $model->description ?: 'Обьявление' ?></span></h5>
                    </div>
                </div>
                <div id="launch-right" class="col-md-3">
                    <?= $form->field($model, 'parent_id')->dropDownList(\common\models\Launch::getAll(),
                        ['prompt' => 'Нет'])
                        ->label(
                            $model->template_id ?
                                Yii::t('common', 'Parent ID').'  '.Html::a('<i class="fa fa-external-link" aria-hidden="true"></i>', '/launch/update?id='.$model->template_id) :
                                Yii::t('common', 'Parent ID')
                        )
                    ?>

                    <?= $form->field($model, 'menutitle', [
                        'addon' => [
                            'append' => [
                                'content'=> Html::a(Yii::t('backend', 'Repeat the name'), '#', [
                                    'class' =>['btn btn-default repeat-name']]),
                                'asButton'=>true,
                            ],
                            'groupOptions' => [
                                'id' => 'title-btn'
                            ]
                        ]
                    ]); ?>

                    <?= $form->field($model, 'slug', [
                        'addon' => [
                            'append' => [
                                'content' => ButtonDropdown::widget([
                                    'label' => Yii::t('backend', 'From'),
                                    'dropdown' => [
                                        'items' => [
                                            ['label' => Yii::t('backend', 'From the title'), 'url' => '#', 'options' => ['class'=>'translate-name']],
                                            ['label' => Yii::t('backend', 'From the menutitle'), 'url' => '#', 'options' => ['class'=>'translate-title']],
                                        ],
                                    ],
                                    'options' => ['class'=>'btn-default']
                                ]),
                                'asButton' => true
                            ],
                            'groupOptions' => [
                                'id' => 'alias-btn'
                            ]
                        ]
                    ])->label(
                        $model->template_id ?
                            Yii::t('common', 'Slug').'  '.Html::a('<i class="fa fa-external-link" aria-hidden="true"></i>', Yii::$app->urlManager->createUrl(['launch/view', 'id'=>$model->id])) :
                            Yii::t('common', 'Slug')
                    ); ?>

                    <?//= $form->field($model, 'author_id')->dropDownList(\yii\helpers\ArrayHelper::map($model->author, 'username', $model->author_id))?> <!--TODO: Вывести Автора-->

                    <?//= $form->field($model, 'published_at')->widget(DateTimeWidget::class, ['phpDatetimeFormat' => 'dd.MM.yyyy, HH:mm:ss']) ?>

                    <?= $form->field($model, 'content_type_id')->dropDownList(Module::getAll(),
                        ['prompt' => 'Без типа:']) ?>

                    <?= $form->field($model, 'template_id')->dropDownList(Template::getAll(),
                        ['prompt' => 'Пустой шаблон:'])
                        ->label(
                            $model->template_id ?
                            Yii::t('common', 'Template Id').'  '.Html::a('<i class="fa fa-external-link" aria-hidden="true"></i>', '/template/update?id='.$model->template_id) :
                            Yii::t('common', 'Template Id')
                        )
                    ?>
                </div>
            </div>
        </div>

        <?php Pjax::begin(['linkSelector' => false, 'formSelector' => false, 'id' => 'module']) ?>
            <div id="fields" class="forms">
                <?if ($model->module) {
                    echo $this->renderAjax($model->module->form, [
                        'form' => $form,
                        'model' => $model->models ?: (new $model->module->model)
                    ]);
                }?>
            </div>
        <?php Pjax::end() ?>

    <?php ActiveForm::end()?>


</div>

<?php
$id = $model->id;
$launch_id = ($model->isNewRecord) ? 0 : $model->id;
$this->registerJs(<<<JS
    $('.repeat-name').click(function(){
        var text = $('#launch-title').val();
        $('#launch-menutitle').val(text);
    });
    $('.translate-name').click(function(){
        var text = $('#launch-title').val().toLowerCase();
        result = translit(text);
    $('#launch-slug').val(result);
    });
    $('.translate-title').click(function(){
        var text = $('#launch-menutitle').val().toLowerCase();
        result = translit(text);
        $('#launch-slug').val(result);
    });
    $('#launch-content_type_id').on('change', function(){
        $.pjax.reload('#module', {
            'url': window.location.href.replace(/&content_type=[0-9]+/g, '') + '&content_type=' + $(this).val(),
            'replace': false
        })
    });
    $('#launch-title').keyup(function() {
      $('#adver-title')[0].innerHTML = $(this)[0].value
    })
    $('#launch-long_title').keyup(function() {
      $('#adver-long_title')[0].innerHTML = $(this)[0].value
    })
    $('#launch-description').keyup(function() {
      $('#adver-description')[0].innerHTML = $(this)[0].value
    })
JS
);
?>
