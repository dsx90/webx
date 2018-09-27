<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCat */

$this->title = 'Create Tehnic Cat';
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-cat-create">

    <?= $this->render('_form', [
        'model' => $model,
        'launch' => $launch
    ]) ?>

</div>
