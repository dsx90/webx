<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pet\models\Pet */

$this->title = Yii::t('app', 'Create Pet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
