<?php

use common\models\Launch;
use common\models\Template;
use common\models\ContentType;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\ArrayHelper;
use common\models\User;
use execut\widget\TreeView;

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
            <div id="launch-row">
                <div id="launch-left" class="col-md-9">
                    <div class="border-field">

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('Длинна пароля должна быть не более 35 символов.') ?>

                        <?= $form->field($model, 'long_title')->textInput(['maxlength' => true])->hint('Длинна пароля должна быть не более 81 символов.') ?>

                        <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

                        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

                    </div>

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
                    <?= $form->field($model, 'parent_id')->dropDownList(Launch::getAll(),
                        ['prompt' => 'Нет'])
                        ->label(
                            $model->template_id ?
                                Yii::t('common', 'Parent ID').'  '.Html::a('<i class="fa fa-external-link" aria-hidden="true"></i>', '/launch/update?id='.$model->template_id) :
                                Yii::t('common', 'Parent ID')
                        )
                    ?>

                    <?php if ($model->addCategories):?>
                    <?php print_r($model->categories)?>
                        <?= \delikatesnsk\treedropdown\DropdownTreeWidget::widget([
                            //'id' => 'organizationsList',
                            'form' => $form,
                            'model' => $model,
                            'attribute' => 'categories',
                            'label' => \Yii::t('app', 'Parents'),
                            'multiSelect' => true,
//                            'searchPanel' => [
//                                'visible' => true,
//                                'label' => \Yii::t('app', 'Choose Organization'),
//                                'placeholder' => '',
//                                'searchCaseSensivity' => false
//                            ],
//                            'rootNode' => [
//                                'visible' => true,
//                                'label' => \Yii::t('app', 'Root Node')
//                            ],
                            'expand' => false,
                            'items' => [],
                            'ajax' => [
                                //в момент когда узел распахнется будет отправлен ajax-запрос с указанными ниже параметрами
                                //обратите внимание, возвращаемые данные должны быть в формате json как параметр `items` из примера выше
                                'onNodeExpand' => [
                                    'url' => 'getchilds', //Тут укажите URL куда будет отправлен ajax-запрос
                                    'method' => 'post', //Метод (POST или GET), по-умолчанию POST
                                    //отправляемые параметры
                                    'params' => [
//                                        'param1' => 'value1',  // <-- Ваши дополнительные параметры (если нужно)
//                                        'param2' => 'value1',
//                                        'param3' => 'value1',
                                        'node_id' => '%nodeId' // <-- алиас %nodeId будет заменен на ID узла
                                        // вы можете изменить ключ 'node_id' на любой другой, по-умолчанию ключ всегда 'id'
                                    ]
                                ],
                                //в момент когда узел свернется будет отправлен ajax-запрос с указанными ниже параметрами
                                //обратите внимание, возвращаемые данные никак не обрабатываются, по сути это отправка данных в одну сторону
                                'onNodeCollapse' => [
                                    'url' => 'setchilds', //Тут укажите URL куда будет отправлен ajax-запрос
                                    'method' => 'get', //Метод (POST или GET), по-умолчанию POST
                                    'params' => [
//                                        'param1' => 'value1',  // // <-- Ваши дополнительные параметры (если нужно)
                                        'collapsed_node_id' => '%nodeId' // <-- алиас %nodeId будет заменен на ID узла
                                        // вы можете изменить ключ 'node_id' на любой другой, по-умолчанию ключ всегда 'id'
                                    ]
                                ]
                            ],

                        ]);?>
                    <?php endif;?>

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
                            Yii::t('common', 'Slug').'  '.Html::a(Html::tag('i', '', ['class' => 'fa fa-external-link']), ['launch/view', 'id'=>$model->id]) :
                            Yii::t('common', 'Slug')
                    ); ?>

                    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'))?> <!--TODO: Вывести Автора-->

<!--                    --><?//= $form->field($model, 'published_at')->widget(DateTimeWidget::class, ['phpDatetimeFormat' => 'dd.MM.yyyy, HH:mm:ss']) ?>

                    <?= $form->field($model, 'content_type_id')->dropDownList(ContentType::getTypes('name'), ['prompt' => 'Без типа:']) ?>

                    <?= $form->field($model, 'template_id')->dropDownList(Template::getAll(),
                        ['prompt' => 'Пустой шаблон:'])
                        ->label(
                            $model->template_id ?
                            Yii::t('common', 'Template Id').'  '.Html::a(Html::tag('i', '', ['class' => 'fa fa-external-link']), ['template/update', 'id'=>$model->template_id]) :
                            Yii::t('common', 'Template Id')
                        )
                    ?>
                </div>
            </div>
        </div>

        <?php Pjax::begin(['linkSelector' => false, 'formSelector' => false, 'id' => 'content_type']) ?>
            <div id="fields" class="forms">
                <?php if ($model->content_type_id) {
                    $contentType = $model->contentType->section;
                    echo $this->renderAjax($contentType['form'], [
                        'form' => $form,
                        'model' => $model->model ?: (new $contentType['model'])
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
        $.pjax.reload('#content_type', {
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
