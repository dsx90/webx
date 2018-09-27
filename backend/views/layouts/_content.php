<?php

use yii\bootstrap\Html;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;
use lo\modules\noty\Wrapper;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo Html::encode($this->title);
                } else {
                    echo Inflector::camel2words(Inflector::id2camel($this->context->module->id));
                    echo ($this->context->module->id !== Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>

        <?= (isset($this->blocks['control-panel'])) ? $this->blocks['control-panel'] : '' ?>

    </section>

    <section class="content">
        <div class="container-fluid"><?= Wrapper::widget() ?></div>
        <div class="box">
           <div class="box-body">
               <div class="row">

                   <?php if (isset($this->blocks['image-panel'])): ?>
                   <div class="col-md-4">
                       <?= $this->blocks['image-panel']?>
                   </div>
                   <?php endif; ?>

                   <?php if (isset($this->blocks['left-top-panel']) or isset($this->blocks['left-panel']) or isset($this->blocks['left-bottom-panel'])): ?>
                       <div class="<?= isset($this->blocks['image-panel']) ? 'col-md-5' : 'col-md-9'?>">
                           <?php if (isset($this->blocks['left-top-panel'])) {
                               echo $this->blocks['left-top-panel'];
                           } ?>
                           <?php if (isset($this->blocks['left-panel'])) {
                               echo $this->blocks['left-panel'];
                           } ?>
                           <?php if (isset($this->blocks['left-bottom-panel'])) {
                               echo $this->blocks['left-bottom-panel'];
                           } ?>
                       </div>
                   <?php endif; ?>

                   <?php if (isset($this->blocks['right-top-panel']) or isset($this->blocks['right-panel']) or isset($this->blocks['right-bottom-panel'])): ?>
                       <div class="col-md-3">
                           <?php if (isset($this->blocks['right-top-panel'])) {
                               echo $this->blocks['right-top-panel'];
                           } ?>
                           <?php if (isset($this->blocks['right-panel'])) {
                               echo $this->blocks['right-panel'];
                           } ?>
                           <?php if (isset($this->blocks['right-bottom-panel'])) {
                               echo $this->blocks['right-bottom-panel'];
                           } ?>
                       </div>
                   <?php endif; ?>
               </div>
               <?= $content ?>
            </div>
        </div>
    </section>
</div>
