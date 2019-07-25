<?php

use vova07\imperavi\Widget;
use yii\helpers\Url;
use fbalabanov\filekit\widget\Upload;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\modules\attribute\models\Attribute;
use common\models\Launch;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCat */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="tehnic_cat-content">
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

<div id="tehnic_cat-right">
    <?= $form->field($model, 'thumbnail')->widget(
        Upload::class,
        [
            'url' => ['/site/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>
    <?= $form->field($model, 'attributesForm')->widget(Select2::class, [
        'data' => ArrayHelper::map(Attribute::find()->all(),'id','name'),
        'language' => 'ru',
        'options' => ['placeholder' => Yii::t('backend', 'Select a value ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]); ?>
</div>


<?= $form->field($model, 'category')->checkboxList(Launch::getAll($model->launch_id)) ?>


<?php
$js = <<< JS
$('#tehnic_cat-right').prependTo( $('#launch-right') );
$('#tehnic_cat-content').appendTo( $('#launch-left') );
JS;
$this->registerJs($js);
$this->registerCss('
.upload-kit-input, .upload-kit-item{
    width: 100% !important;
    height: 256px !important;
    margin-bottom: 0 !important;
    border: 1px dashed #999 !important;
    background: #fbfbfb;
}
.select2-selection__clear{
    margin: 0 !important;
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
