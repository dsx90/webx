<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $launch \common\models\Launch */
/* @var $model \common\modules\construction\models\Construction */

$this->title = 'Update: ' . $launch->title;
$this->params['breadcrumbs'][] = ['label' => 'Constructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $launch->title, 'url' => ['view', 'id' => $model->launch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="construction-update">

    <?= $this->render('_form', [
        'model' => $model,
        'launch' => $launch
    ]) ?>

</div>
