<?php

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = Yii::t('backend', 'Update article: {title}', ['title' => $launch->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="article-update">

    <div class="col-md-3">
        <ul class="catalog category-products">
            <?= \common\widget\coreCase\Menu::widget([
                'parents' => $launch->parent_id,
                'limit' => 10,
                'select' => ['id', 'parent_id', 'title', 'slug', 'status'],
                'resources' => 16,
                'tpl' => 'menu',
                'controller' => 'frontend/tehnic/view'
            ]) ?>
        </ul>
    </div>

    <div class="col-md-9">
    <?= $this->render('_form', [
        'model' => $model,
        'launch' => $launch,
    ]) ?>
    </div>

</div>
