<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContextKey */

$this->title = Yii::t('backend', 'Create Context Key');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Context Keys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="context-key-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
