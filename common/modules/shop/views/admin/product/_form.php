<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mirocow\eav\admin\widgets\Fields;
use vova07\imperavi\Widget;
use mirocow\eav\widgets\ActiveField;
use yii\helpers\Url;
use common\modules\shop\models\Product;
use kartik\number\NumberControl;

use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this)

/* @var $this yii\web\View */
/* @var $model Product */
/* @var $launch \common\models\Launch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="construction-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-sm-10">
                    <?= $form->field($launch, 'title')->textInput() ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'price')->widget(NumberControl::class, [
                        'maskedInputOptions' => [
                            'prefix' => '$ ',
                            'suffix' => ' ¢',
                            'allowMinus' => false
                        ],
                        'options' => [
                            'type' => 'text',
                            'label'=>'<label>Saved Value: </label>',
                            'class' => 'kv-saved',
                            'readonly' => true,
                            'tabindex' => 1000
                        ],
                        'displayOptions' => ['class' => 'form-control kv-monospace'],
                        'saveInputContainer' => ['class' => 'kv-saved-cont']
                    ]);
                    ?>
                    <?= $form->field($model, 'old_price')->widget(NumberControl::class, [
                        'maskedInputOptions' => [
                            'prefix' => '$ ',
                            'suffix' => ' ¢',
                            'allowMinus' => false
                        ],
                        'options' => [
                            'type' => 'text',
                            'label'=>'<label>Saved Value: </label>',
                            'class' => 'kv-saved',
                            'readonly' => true,
                            'tabindex' => 1000
                        ],
                        'displayOptions' => ['class' => 'form-control kv-monospace'],
                        'saveInputContainer' => ['class' => 'kv-saved-cont']
                    ]);
                    ?>
                </div>
            </div>


            <?= $form->field($launch, 'long_title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($launch, 'description')->textarea(['rows' => 5]) ?>

            <?= $form->field($launch, 'keywords')->textInput(['maxlength' => true]) ?>

            <div class="adver-view">
                <i>Видимость в поисковиках</i>
                <h2><span id="title"><?= $launch->title ? $launch->title : 'Титул' ?></span>: <span id="long_title"><?= $launch->long_title ? $launch->long_title : 'Краткое описание' ?></span></h2>
                <h4><?= env('FRONTEND_URL')?>›<span id="url"><?= $launch->slug ? $launch->slug : 'url ссылка' ?></span></h4>
                <h5><span id="description"><?= $launch->description ? $launch->description : 'Обьявление' ?></span></h5>
            </div>

            <h1>||</h1>

            <?= Fields::widget([
                'model' => $model,
                'categoryId' => $model->launch_id,
                'entityName' => 'Продукт',
                'entityModel' => Product::class,
            ])?>

            <?php
            if(!empty($model->launch->parent_id)){
                foreach($model->getEavAttributes()->all() as $attr){
                    echo $form->field($model, $attr->name, ['class' => ActiveField::class])->eavInput();
                }
            }
            ?>

            <?php foreach($model->getEavAttributes()->all() as $attr){
                echo $model[$attr->name];
            }
            ?>


            <?= $form->field($model, 'content')->widget(Widget::class, [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'filemanager',
                        'fullscreen',
                        'fontcolor',
                        'imagemanager',
                        'table',
                        'video',
                    ],
                    'imageManagerJson' => Url::to(['/site/images-get']),
                    'fileManagerJson' => Url::to(['/site/files-get']),
                    'imageUpload' => Url::to(['/site/image-upload']),
                    'fileUpload' => Url::to(['/site/file-upload']),
                ],
            ]) ?>

        </div>
        <div class="col-md-3">

            <?= $form->field($launch, 'parent_id')->dropDownList(\common\models\Launch::getAll(),
                ['prompt' => 'Нет']) ?>

            <?= $form->field($launch, 'slug')->textInput() ?>

            <div class="form-group pull-left">
                <?= $form->field($launch, 'status')->widget(\dosamigos\switchinput\SwitchBox::class,[
                    'clientOptions' => [
                        'size' => 'normal',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ],
                    'inlineLabel' => false
                ])->label(false);?>
            </div>

            <div class="form-group pull-right">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
