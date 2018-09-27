<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Template */

$this->title = Yii::t('document', 'Редактирование шаблона');
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Шаблоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('document', 'Редактирование');
?>

<div class="template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?/*= $this->render('_fields', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ]); */?>
</div>
