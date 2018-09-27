<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicOption */

$this->title = 'Create Tehnic Option';
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-option-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
