<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\LayoutModule */

$this->title = 'Create Layout Module';
$this->params['breadcrumbs'][] = ['label' => 'Layout Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layout-module-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
