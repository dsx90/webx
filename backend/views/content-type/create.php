<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentType */

$this->title = Yii::t('backend', 'Create Content Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Content Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
