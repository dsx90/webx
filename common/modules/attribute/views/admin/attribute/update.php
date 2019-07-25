<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\attribute\models\Attribute */

$this->title = 'Update Attribute: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attribute-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
