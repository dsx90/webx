<?php
/**
 * Created by PhpStorm.
 * User: ideaPad
 * Date: 12.10.2017
 * Time: 8:46
 */
?>

<div class="container-fluid line-cat">
    <div class="col-md-2">
        <h2>Категории:</h2>
    </div>
    <?php $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\modules\tehnic\models\TehnicCat::find()->where(['parent_id'=>null])->orderBy('title DESC'),
    ]);

    echo \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'itemOptions' => ['tag' => 'div', 'class' => 'col-md-2'],
        'summary' => '',
    ]); ?>
</div>
