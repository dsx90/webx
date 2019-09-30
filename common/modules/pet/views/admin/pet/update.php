<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pet\models\Pet */

$this->title = Yii::t('app', 'Update Pet: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
