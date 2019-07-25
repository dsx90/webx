<?php

namespace common\modules\shop;

use Yii;
use yii\console\Application;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = 'shop';

    public function controllerNamespace()
    {
        if (Yii::$app instanceof Application) {
            return 'app\modules\shop\commands';
        }
        return 'common\modules\shop\controllers';
    }

    public function layout()
    {
        return [
            'product' => [
                'model'         => dirname(dirname(__DIR__)) . '\Product',
                'controller'    => $this->controllerNamespace.'\ProductController',
                'form'          => '@common/modules/shop/views/admin/product/_cform'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->controllerNamespace = $this->controllerNamespace();
        $this->layout = $this->layout();
    }
}
