<?php

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Yii::t('frontend', 'Create post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <div class="col-md-3">
        <ul class="catalog category-products">
            <?= \frontend\widget\MenuWidget::widget(['tpl' => 'menu'])?>
        </ul>
    </div>

    <div class="col-md-9">
    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>
    </div>

</div>
