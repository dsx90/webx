<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/css/style.css',
        'static/css/morris.css'
    ];
    public $js = [
        'static/js/system.js',
        'static/js/analytics.js',
        'static/js/daterangepicker.js',
        //'static/js/demo.js',
        'static/js/fastclick.js',
        'static/js/jquery.knob.min.js',
        'static/js/jquery.slimscroll.min.js',
        'static/js/jquery.sparkline.min.js',
        'static/js/jquery-jvectormap-1.2.2.min.js',
        'static/js/jquery-jvectormap-world-mill-en.js',
        'static/js/moment.min.js',
        'static/js/morris.min.js',
        'static/js/raphael.min.js',
        'static/js/bootstrap3-wysihtml5.all.min.js',
        'static/js/bootstrap-datepicker.min.js',
        //'static/js/adminlte.min.js',
        'static/js/jquery-ui.min.js',
        'static/js/jquery.cookie.js',
        'static/js/translate.js' // launch
        //'static/js/dashboard.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\AdminLte',
        'common\assets\Html5shiv',
    ];
}
