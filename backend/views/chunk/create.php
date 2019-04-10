<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Chunk */

$this->title = Yii::t('backend', 'Create Chunk');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Chunks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chunk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
