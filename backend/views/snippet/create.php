<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */

$this->title = Yii::t('backend', 'Create Snippet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Snippets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
