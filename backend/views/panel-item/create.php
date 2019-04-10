<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PanelItem */

$this->title = Yii::t('backend', 'Create Panel Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Panel Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
