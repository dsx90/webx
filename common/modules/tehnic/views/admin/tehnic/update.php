<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\Tehnic */

$this->title = 'Update Tehnic: ' . $model->category->launch->title.' '.$model->launch->title;
$this->params['breadcrumbs'][] = ['label' => 'Tehnics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->launch->title, 'url' => ['view', 'id' => $model->category->launch_id]];
$this->params['breadcrumbs'][] = ['label' => $model->launch->title, 'url' => ['view', 'id' => $model->launch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-update">

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $options,
        'launch' => $launch
    ]) ?>

</div>
