<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOptionAssignment */

$this->title = 'Update Tehnic Option Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Option Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-option-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
