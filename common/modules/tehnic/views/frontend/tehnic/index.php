<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\modules\tehnic\search\TehnicSearch */

$this->title = Yii::t('frontend', 'Tehnic');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="col-md-3">

        <ul class="catalog category-products">
            <?= \common\modules\tehnic\widget\MenuWidget::widget(['tpl' => 'menu'])?>
        </ul>

        <p>
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </p>
    </div>

    <div class="col-md-9">

            <h1 class="mt-0"><?= Html::encode($this->title) ?> <small><?//= $dataProvider->getCount() ?></small>
                <? if (Yii::$app->user->can('administrator','user') ): ?>
                    <?= Html::a(Yii::t('common', 'Create Post'), ['create'], ['class' => 'pull-right btn btn-grey']) ?>
                <? endif; ?>
            </h1>

        <?php \yii\widgets\Pjax::begin(); ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => 'Показано {count} из {totalCount}',
                'layout' => "{pager}\n{summary}\n{sorter}\n{items}\n{pager}",
                'emptyText' => 'Список пуст',
                'sorter' => [
                    'attributes' => ['price'],
                    'options' => [
                        'itemOptions' => ['class' => 'sorter'], // как тут добавить "active" для текущего? ("sorter active")
                    ],
                ]
            ]) ?>
        <? \yii\widgets\Pjax::end(); ?>
    </div>
</div>