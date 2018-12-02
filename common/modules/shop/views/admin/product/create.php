<?php

/* @var $this yii\web\View */
/* @var $model \common\modules\shop\models\Product */
/* @var $launch \common\models\Launch */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-create">

    <?= $this->render('_form', [
        'model' => $model,
        'launch' => $launch
    ]) ?>

</div>