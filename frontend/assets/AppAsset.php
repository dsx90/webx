<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/css/style.css',
        'static/css/callback.css'
    ];
    public $js = [
        'static/js/jquery.accordion.js',
        'static/js/jquery.cookie.js',
        'static/js/main.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\OpenSans',
        'common\assets\FontAwesome',
    ];
}
