<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model mirocow\eav\models\EavAttribute */

$this->title = Yii::t('backend', 'Create Eav Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Eav Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eav-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
