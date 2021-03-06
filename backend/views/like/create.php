<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Like */

$this->title = Yii::t('backend', 'Create Like');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Likes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
