<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Launch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Launches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="launch-view">

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= \yii\bootstrap\Tabs::widget([
            'items' => [
                [
                    'label' => 'Рендер шаблона',
                    'visible'   => !empty($template),
                    'content'   => empty($template) ?: $this->render(
                            '@template/'.$model->template->title.'.tpl',
                            ['model' => $model]
                        )
                ],
                [
                    'label' => 'Таблица полей',
                    'content' => DetailView::widget([
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
                            'visit',
                            'like'
                        ],
                    ]),

                ],

            ]
        ]);
        ?>
</div>
