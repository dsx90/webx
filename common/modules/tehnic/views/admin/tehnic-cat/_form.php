<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use fbalabanov\filekit\widget\Upload;
use common\models\Launch;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tehnic-cat-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">

            <?= $form->field($launch, 'title')->textInput() ?>

            <?= $form->field($launch, 'longtitle')->textInput(['maxlength' => true]) ?>

            <?= $form->field($launch, 'description')->textarea(['rows' => 5]) ?>

            <?= $form->field($launch, 'keywords')->textInput(['maxlength' => true]) ?>

            <div class="adver-view">
                <i>Видимость в поисковиках</i>
                <h2><span id="title"><?= $launch->title ? $launch->title : 'Титул' ?></span>: <span id="longtitle"><?= $launch->longtitle ? $launch->longtitle : 'Краткое описание' ?></span></h2>
                <h4><?= env('FRONTEND_URL')?>›<span id="url"><?= $launch->slug ? $launch->slug : 'url ссылка' ?></span></h4>
                <h5><span id="description"><?= $launch->description ? $launch->description : 'Обьявление' ?></span></h5>
            </div>

            <?= $form->field($model, 'content')->widget(Widget::className(), [
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

            <?= $form->field($model, 'thumbnail')->widget(
                Upload::className(),
                [
                    'url' => ['/site/upload'],
                    'maxFileSize' => 5000000, // 5 MiB
                ]);
            ?>

            <?= $form->field($launch, 'parent_id')->dropDownList(Launch::getAll(),
                ['prompt' => 'Нет']) ?>

            <?= $form->field($launch, 'slug')->textInput() ?>

            <?= $form->field($model, 'category')->checkboxList(Launch::getAll(13), ['prompt' => 'Тип документа:']) ?>

            <?= $form->field($model, 'option')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\modules\tehnic\models\TehnicOption::find()->all(),'option','option'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Select a state ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            ]); ?>

            <div class="form-group pull-left">
                <?= $form->field($launch, 'status')->widget(\dosamigos\switchinput\SwitchBox::className(),[
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

<?php $this->registerCss('
.upload-kit-input, .upload-kit-item{
    width: 100% !important;
    height: 256px !important;
    margin-bottom: 0 !important;
    border: 1px dashed #999 !important;
    background: #fbfbfb;
}
.select2-selection__clear{
    margin: 2px 10px 0 10px !important;
}
.select2-selection__rendered{
    padding: 5px 25px 5px 5px !important;
}
.select2-selection__choice__remove{
    padding: 2px;
}
.select2-selection__choice{
    float: inherit !important;
    margin: 2px 0 !important;
    width: 100% !important;
    padding: 2px 6px !important;
}
')
?>
