<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\construction\models\Construction */

$this->title = 'Create Construction';
$this->params['breadcrumbs'][] = ['label' => 'Constructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-create">

    <?= $this->render('_table', [
        'model' => $model,
        'launch' => $launch
    ]) ?>

</div>
