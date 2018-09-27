<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\tehnic\search\TehnicCustomerOption */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tehnic Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-option-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tehnic Option', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin();

    echo TabularForm::widget([
        'dataProvider'=>$dataProvider,
        'form'=>$form,
        'attributes'=>$model->formAttribs,
        //'gridSettings'=>[
        //    'floatHeader'=>true,
        //    'panel'=>[
        //        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
        //        'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success']) . ' ' .
        //            Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
        //            Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary'])
        //    ]
        //]
    ]);
    // Add other fields if needed or render your submit button
    echo '<div class="text-right">' .
        Html::submitButton('Submit', ['class'=>'btn btn-primary']) .
        '<div>';
    ActiveForm::end(); ?>
<?php Pjax::end(); ?></div>
