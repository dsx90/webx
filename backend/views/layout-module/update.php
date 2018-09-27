<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LayoutModule */

$this->title = 'Update Layout Module: ' . $model->module;
$this->params['breadcrumbs'][] = ['label' => 'Layout Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->module, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="layout-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
