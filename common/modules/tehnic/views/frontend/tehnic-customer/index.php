<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use \yii\widgets\Pjax;

?>

<?php
    Modal::begin([
        'options' => [
            'id' => 'modal',
            'clientOptions' => false
        ],
        'header' => 'Заказ <h3 class="m-0">'.$tehnic->category->launch->title.' <small>'. $launch->title .'<b><div class="pull-right">'.$tehnic->price.'₽/час</div></b></small></h3>',
        'footer' => ''
    ]);
?>
    <div class="client-create">


        <?= $this->render('_form', [
            'model' => $model,
            'launch' => $launch,
            'customer' => $customer,
        ]) ?>

    </div>
<?php
    Modal::end();
?>