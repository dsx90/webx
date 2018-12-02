<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Launch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Launches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="launch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'title',
            'long_title',
            'description',
            'keywords',
            'menutitle',
            'slug',
            'status',
            'content_type_id',
            'author_id',
            'updater_id',
            'published_at',
            'created_at',
            'updated_at',
            [
                'attribute' => Yii::t('common', 'Views'),
                'format' => 'raw',
                'value' =>  $views,
            ],
            [
                'attribute' => Yii::t('common', 'Likes'),
                'format' => 'raw',
                'value' =>  $likes,
            ]
        ],
    ]) ?>

</div>
