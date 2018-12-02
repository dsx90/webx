<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Launch */
/* @var $composit \backend\controllers\LaunchController : update  */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'ресурс',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Launches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="launch-update">

    <?= $this->render('_form', [
        'model' => $model,
        //'composit' => $composit
    ]) ?>

</div>
