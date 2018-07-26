<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';

use common\Module;

?>
<div class="site-index connectedSortable ui-sortable">

    <?php if (isset($modules[Module::POSITION_HEADER])) { ?>
        <div class="">
            <?php foreach ($modules[Module::POSITION_HEADER] as $module) {
                echo $module;
            } ?>
        </div>
    <?php } ?>

    <div class="col-md-12">
        <?/*= \common\widget\Yandex\YandexMetrikaApi::widget([
            'ids' => [
                Yii::$app->keyStorage->get('yandexMetrika.id'),
                39679200
            ],
            'oauth_token' => Yii::$app->keyStorage->get('yandexMetrika.token'),
            'data' => 'bytime',
            'group' => 'day',
            'metrics' => [
                'ym:s:visits',
                'ym:s:pageviews',
                'ym:s:users',
            ],
            'preset' => 'sources_summary',
            //'date1' => '2018-01-17',
            //'date2' => '2018-01-17',
            'dimensions' => [
                'ym:s:<attribution>TrafficSource',
                //'ym:pv:URL'
            ]

        ]) */?>
    </div>


</div>

<?= $this->registerCss('
.box-body{
    padding:0px
}
.summary{
    margin: 5px 0 0 10px;
}
')?>







