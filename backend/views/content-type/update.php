<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentType */

$this->title = Yii::t('backend', 'Update Content Type: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Content Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="content-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
