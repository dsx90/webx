<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('backend', 'New tehnic')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wrench"></i></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><?= Html::a('Create Tehnic', ['/tehnic/admin/tehnic/create']) ?></li>
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProviderTehnic,
                'tableOptions' => [
                    'class' => 'table table-condensed table-hover table-striped table-gv'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'launch_id',
                    //[
                    //    'attribute'=>'attachment',
                    //    'contentOptions' =>['class' => 'table_image'],
                    //    'format' => 'image',
                    //    'value' => function($model) {
                    //        foreach ($model->attachment as $attachment){
                    //            return isset($attachment->path) ? \common\lib\Imager::thumbnail($attachment->path, 135, 135) : null;
                    //        }
                    //    }
                    //],
                    [
                        'attribute' => 'parent_id',
                        'options' => ['style' => 'width: 100px'],
                        //'filter' => \common\models\Launch::find()->select(['title', 'id'])->indexBy('id')->column(),
                        'value' => 'launch.parent.title',
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'html',
                        //'options' => ['style' => 'width: 25%'],
                        'value' => function ($model) {
                            return  '<h5><b>'.$model->launch->parent->title.' '.$model->launch->title.'</b></h5>'.
                                //'<h5>'.$model->cut(strip_tags($model->content), 130).'</h5>'.
                                '<h6>'.$model->getAttribut(', ').'</h6>'
                                ;
                        },
                    ],
                    'price',
                    'status',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">$35,210.43</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">$10,390.90</h5>
                        <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">$24,813.53</h5>
                        <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block">
                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('backend', 'New customer')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wrench"></i></button>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProviderCustomer,
                'filterModel' => $searchModelCustomer,
                'tableOptions' => [
                    'class' => 'table table-condensed table-hover table-striped table-gv'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'order_id',
                    'address',
                    'work_time:datetime',
                     'order_time:datetime',
                    // 'order_on_time:datetime',
                    // 'value_work',
                    // 'percent',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">$35,210.43</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">$10,390.90</h5>
                        <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">$24,813.53</h5>
                        <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block">
                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>


