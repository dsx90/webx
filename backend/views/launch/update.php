<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model \common\models\Launch
 * @var $composit \backend\controllers\LaunchController : update
 * @var $template \common\models\Template;
 */

//$crumbs = [];
//if ($parent = $model->parent){
//    $crumbs[] = ['label' => $meta->title, 'url' => ['update', 'id' => $parent->id]];
//    while ($parent = $parent->parent) {
//        $crumbs[] = ['label' => $meta->title, 'url' => ['update', 'id' => $parent->id]];
//    }
//    $this->params['breadcrumbs'] = array_reverse($crumbs);
//
//    $this->params['category'] = $model->parent;
//};
//
//$this->params['breadcrumbs'][] = $meta->title;


//$this->title = Yii::t('backend', 'Update {modelClass}: ', [
//    'modelClass' => 'ресурс',
//]) . $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Launches'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="launch-update">
    <?php $form = ActiveForm::begin(); ?>
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
            <?php if (!$model->isNewRecord) : ?>
                <?= Html::a('<i class="glyphicon glyphicon-eye-open"></i> '.Yii::t('backend', 'View'), ['view', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                ]) ?>
                <?= Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete the resources?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<i class="glyphicon glyphicon-level-up"></i> '.Yii::t('backend', 'Create child'), ['create', 'parent_id' => $model->id], [
                    'class' => 'btn btn-default',
                ]) ?>
            <?php endif;?>
            <?= Html::a('<i class="fa fa-chevron-left"></i>',['update', 'id' => $model->getPrev()], ['class' => 'btn btn-default',]) ?>
            <?= Html::a('<i class="fa fa-arrow-up"></i>',['index'], ['class' => 'btn btn-default',]) ?>
            <?= Html::a('<i class="fa fa-chevron-right"></i>',['update', 'id' => $model->getNext()], ['class' => 'btn btn-default',]) ?>
        </div>

        <?= \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Рендер шаблона',
                'visible'   => !empty($template),
                'content'   => empty($template) ? '' :
                    //$this->render('@backend/views/template/_render.php', [
                    Yii::$app->getView()->render('@backend/views/template/_render.php', [
                        'model' => $model,
                        'template' => $template
                    ])
            ],
            [
                'label' => 'Таблица полей',
                'content' => $this->render('_form', compact('model', 'meta'))

            ],
            [
                'label' => 'Потомки',
                'content' => $this->render('index', compact('searchModel', 'dataProvider')),
                'visible' => !empty($model->module['hideChildTable']) ? !$model->module['hideChildTable'] : true
            ],

        ]
    ])?>
    <?php ActiveForm::end()?>

</div>
