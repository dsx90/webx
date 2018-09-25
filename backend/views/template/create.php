<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Template */

$this->title = Yii::t('document', 'Новый шаблон');
$this->params['breadcrumbs'][] = ['label' => Yii::t('document', 'Шаблоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="template-create">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
