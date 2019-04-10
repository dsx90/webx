<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Context */

$this->title = Yii::t('backend', 'Create Context');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contexts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="context-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
