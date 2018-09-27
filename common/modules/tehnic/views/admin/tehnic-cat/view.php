<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\TehnicCat */

$this->title = $model->launch_id;
$this->params['breadcrumbs'][] = ['label' => 'Tehnic Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tehnic-cat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->launch_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->launch_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'launch_id',
            'content:ntext',
            // 'thumbnail',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
        ],
    ]) ?>
    <pre>
        <?= print_r($model->thumbnail) ?>
    </pre>


</div>
