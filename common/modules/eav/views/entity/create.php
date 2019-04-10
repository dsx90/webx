<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model mirocow\eav\models\EavEntity */

$this->title = Yii::t('backend', 'Create Eav Entity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Eav Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eav-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
