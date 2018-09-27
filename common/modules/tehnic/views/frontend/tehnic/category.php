<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\modules\tehnic\models\Tehnic */
/* @var $dataProvider yii\data\ActiveDataProvider */

$parent = $launch;
$crumbs = [];
while ($parent = $parent->parent) {
    $crumbs[] = ['label' => $parent->title, 'url' => ['category', 'slug' => $parent->slug]];
}
$this->params['breadcrumbs'] = array_reverse($crumbs);
$this->params['breadcrumbs'][] = $launch->title;
?>

<div class="article-index">
    <div class="col-md-3">

        <?//php $this->beginContent('@app/views/layouts/CopanyLogo.php'); ?>
        <?//php $this->endContent(); ?>

        <ul class="catalog category-products">
            <?//= \frontend\widget\MenuWidget::widget(['tpl' => 'menu'])?>
        </ul>
    </div>

    <div class="col-md-9">
        <h1 class="mt-0"><?= Html::encode($launch->title) ?>
            <?= Html::a(Yii::t('common', 'Create Post'), ['create'], ['class' => 'pull-right btn btn-grey']) ?>
        </h1>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'summary' => false,
        ]) ?>
    </div>
</div>
