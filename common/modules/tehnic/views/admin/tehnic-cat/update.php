<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCat */

$this->title = 'Update Tehnic Cat: ' . $model->launch->title;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->launch->title, 'url' => ['view', 'id' => $model->launch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tehnic-cat-update">

    <?= $this->render('_form', [
        'model' => $model,
        'launch' => $launch
    ]) ?>

</div>
