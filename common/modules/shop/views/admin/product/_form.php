<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\construction\models\Construction */
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
                    <?= $form->field($model, 'price')->textInput() ?>
                    <?= $form->field($model, 'old_price')->textInput() ?>
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

            <?/*= $form->field($model, 'attachment')->widget(
                \fbalabanov\filekit\widget\Upload::class,
                [
                    'url' => ['/site/upload'],
                    'targetDir' => 'construction/'.$launch->slug,
                    'sortable' => true,
                    'maxFileSize' => 10000000, // 10 MiB
                    'maxNumberOfFiles' => 10,
                ]);
            */?>
            <h1>||</h1>
            <?= empty($model->launch->parent_id) ?: $model->launch->parent_id ?>
            <?/*= \mirocow\eav\admin\widgets\Fields::widget([
                'model' => $model,
                'categoryId' => $model->launch->parent_id,
                'entityName' => 'Продукт',
                'entityModel' => 'common\modules\shop\models\Product',
            ])*/?>

            <?php
            if(!empty($model->launch->parent_id)){
                foreach($model->getEavAttributes(['entityId' => 1, 'typeId' => 1])->all() as $attr){
                    echo $form->field($model, $attr->name, ['class' => '\mirocow\eav\widgets\ActiveField'])->eavInput();
                }
            }
            ?>

            <?php /*foreach($model->getEavAttributes()->all() as $attr){
                echo $model[$attr->name];
            }*/
            ?>


            <?/*= $form->field($model, 'content')->widget(Widget::class, [
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
            ]) */?>

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
