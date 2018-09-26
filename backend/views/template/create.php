<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Template */

$this->title = Yii::t('document', 'Новый шаблон');
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Шаблоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
