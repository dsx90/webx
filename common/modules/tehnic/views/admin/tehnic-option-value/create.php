<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOptionValue */

$this->title = 'Create Tehnic Option Value';
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Option Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-option-value-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
