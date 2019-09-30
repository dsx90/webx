<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pet\models\TiesPets */

$this->title = Yii::t('app', 'Create Ties Pets');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ties Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ties-pets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
