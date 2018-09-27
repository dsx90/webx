<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View
 * @var \common\modules\tehnic\models\Tehnic
 */

?>

    <div class="col-md-6 row">
        <div class="sp-article">
            <a href="<?= Url::to(['view', 'slug' => $model->launch->slug]);?>">
                <?= $model->getImage(190, 150) ?>
            <div class="description">
                <h4><?= $model->launch->parent->title ?><br><small> <?= $model->launch->title ?></small></h4>
                <h5>
                    <?= $model->getAttribut('<br>') ?>
                </h5>
                <h4><b><?= $model->price ?> ₽/час</b></h4>
                <?= Html::a('Заказать', ['client', 'slug' => $model->launch->slug], ['data-id' => $model->launch_id, 'class' => 'pull-right btn btn-xs btn-success order_click'])?>
            </div>
            </a>
        </div>
    </div>