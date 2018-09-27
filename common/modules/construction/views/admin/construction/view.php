<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\construction\models\Construction */

$this->title = $launch->title;
$this->params['breadcrumbs'][] = ['label' => 'Constructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->launch_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $launch->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?/*= DetailView::widget([
        'model' => $launch,
        'attributes' => [
            'title',
            'slug',
            'status',
            'author_id',
            'updater_id',
            'published_at',
            'created_at',
            'updated_at',
        ],
    ]) */?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'launch_id',
            'content:ntext',
            'price',
            'launch.title',
            'launch.slug:url',
            'launch.status',
            'launch.author_id',
            'launch.updater_id',
            'launch.published_at',
            'launch.created_at:datetime',
            'launch.updated_at:datetime',
        ],
    ]) ?>

</div>
