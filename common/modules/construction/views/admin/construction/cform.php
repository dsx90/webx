<?php
use vova07\imperavi\Widget;
use yii\helpers\Url;
use fbalabanov\filekit\widget\Upload;
?>
<div id="construction-attachment">
    <?= $form->field($model, 'attachment')->widget(
        Upload::className(),
        [
            'url' => ['/site/upload'],
            'targetDir' => 'tehnic/'.$model->launch_id,
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10,
        ])->hint('/consruction/'.$model->launch_id) ?>
</div>
<div id="construct-content">
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
    $('.field-construction-price').addClass('col-md-3').appendTo( $('#title-price') );
    $('#construction-attachment').appendTo( $('#launch-left') );
    $('#construct-content').appendTo( $('#launch-left') );
JS;
$this->registerJs($js);
?>