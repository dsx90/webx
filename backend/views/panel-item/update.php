<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PanelItem */

$this->title = Yii::t('backend', 'Update Panel Item: ' . $model->title, [
    'nameAttribute' => '' . $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Panel Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="panel-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
