<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOptionAssignment */

$this->title = 'Create Tehnic Option Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Option Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-option-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
