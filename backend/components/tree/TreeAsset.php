<?php
namespace backend\components\tree;

use yii\web\AssetBundle;

/**
 * Подключение CSS и JS для компонента JSTree
 * Class TreeAsset
 * @package lowbase\document
 */
class TreeAsset extends AssetBundle
{
    public $sourcePath = '@backend/components/tree/assets';

    public $css = [
        'css/themes/default/style.css',
        'css/themes/default/theme.css'
    ];

    public $js = [
        'js/jstree.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
