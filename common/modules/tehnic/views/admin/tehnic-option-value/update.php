<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOptionValue */

$this->title = 'Update Tehnic Option Value: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Option Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-option-value-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
