<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOption */

$this->title = 'Update Tehnic Option: ' . $model->option_id;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->option_id, 'url' => ['view', 'id' => $model->option_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-option-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
