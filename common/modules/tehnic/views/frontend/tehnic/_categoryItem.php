<?php

use yii\bootstrap\Nav;

/* @var $this yii\web\View */

?>

<div class="post-category-item">
    <?= Nav::widget([
        'items' => $menuItems,
        'options' => [
            'class' => 'nav nav-pills nav-stacked',
        ],
    ]) ?>
</div>
