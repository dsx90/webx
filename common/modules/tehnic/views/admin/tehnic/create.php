<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\Tehnic */

$this->title = 'Create Tehnic';
$this->params['breadcrumbs'][] = ['label' => 'Tehnics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-create">

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $options,
        'launch' => $launch
    ]) ?>

</div>
