<?php

use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\switchinput\SwitchInput;
use kartik\grid\GridView;
use kartik\helpers\Html;

$form = ActiveForm::begin();
$attribs = $model->formAttribs;
unset($attribs['attributes']['color']);
$attribs['attributes']['status'] = [
    'type'=>TabularForm::INPUT_WIDGET,
    'widgetClass'=>SwitchInput::classname()
];

echo TabularForm::widget([
    'dataProvider'=>$dataProvider,
    'form'=>$form,
    'attributes'=>$attribs,
    'gridSettings'=>[
        'floatHeader'=>true,
        'panel'=>[
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
            'type' => GridView::TYPE_PRIMARY,
            'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success']) . ' ' .
                Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
                Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary'])
        ]
    ]
]);
ActiveForm::end();
